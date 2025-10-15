<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Exception;
use Validator;
use App\Models\User;
use App\Models\Slider;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\PickupDrop;
use App\Models\Testomonial;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{

    public function login(Request $req)
    {
        // return $req->input();
        $user = User::where(['username' => $req->username])->first();
        if (!$user || !Hash::check($req->password, $user->password)) {
            return redirect()->back()->with('alert-error', 'Username or password is not matched');
            // return "Username or password is not matched";
        } else {
            if ($user->is_active == 1) {
                Auth::loginUsingId($user->id);
                $req->session()->put('user', $user);
                return redirect('/admin/dashboard');
            } else {
                return redirect()->back()->with('alert-error', 'Your account is not activated. Please contact to administrator!!');
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

    public function dashboard()
    {
        $countGallery = Gallery::Where('is_active', 1)->count();
        $countContacts = Contact::count();
        $buses = Bus::Where('is_active', 1)->count();
        $sliders = Slider::Where('is_show', 1)->count();
        $testomonials = Testomonial::Where('is_active', 1)->count();

        return view('admin.index', compact('countGallery', 'countContacts', 'buses', 'sliders', 'testomonials'));
    }

    public function profiledit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.profile.edit', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        $user = Session::get('user');
        if (!(Hash::check($request->get('current_password'), $user->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }

        if (strcmp($request->get('current_password'), $request->get('new_password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Session::get('user');
        $user->password = bcrypt($request->get('new_password'));
        $user->original_password = $request->get('new_password');
        $user->save();

        return redirect()->back()->with("success", "Password changed successfully !");
    }

    public function siteHomePage()
    {
        // return view('auth.login');

        $sliders = Slider::where('is_show', 1)->inRandomOrder()->get();
        $pickupDrops = PickupDrop::where('is_active', 1)->get();
        $galleries = Gallery::where('is_active', 1)->get();
        $testomonials = Testomonial::where('is_active', 1)->get();
        return view('front.index', compact('sliders', 'galleries', 'testomonials', 'pickupDrops'));
    }

    public function about()
    {
        $galleries = Gallery::where('is_active', 1)->get();
        $testomonials = Testomonial::where('is_active', 1)->get();
        return view('front.about', compact('testomonials', 'galleries'));
    }

    public function gallery()
    {
        $galleries = Gallery::where('is_active', 1)->inRandomOrder()->get();
        return view('front.gallery', compact('galleries'));
    }

    public function manageBooking()
    {
        return view('front.packages');
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function storeContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'contact' => 'required',
            // 'address' => 'required',
            'message' => 'required',
        ]);

        // Honeypot check
        if (!empty($request->website)) {
            return back()->withErrors(['error' => 'Bot detected'])->withInput();
        }

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }

        $input = $request->except(['website']);

        Contact::create($input);

        return redirect()->back()->with("success", "Contact request sent successfully!");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $loginRole = Session::get('user')->role;
        $loginId = Session::get('user')->id;

        $usersQuery = User::query();

        if ($loginRole != 'Admin') {
            $usersQuery->where('id', $loginId)
                ->where('role', 'User');
        } else {
            $usersQuery->where('role', '!=', 'Admin');
        }

        $users = $usersQuery
            ->orderBy('id', 'DESC')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'mobile' => 'required',
            'role' => 'required',
            // 'address' => 'required',
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }

        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        $input['original_password'] = $request->password;
        User::create($input);
        Session::flash('message', "Record Save Successfully");
        return redirect('admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'name' => ['required', 'string', 'max:255'],
            'mobile' => 'required',
            'role' => 'required',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            // 'address' => 'required',
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }

        $input = $request->all();

        if (!empty($request->password)) {
            $input['password'] = bcrypt($request->password);
            $input['original_password'] = $request->password;
        }

        $user->update($input);

        Session::flash('message', "Record updated Successfully");
        return redirect('admin/users');
        // return redirect('admin/posts/edit/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        Session::flash('message', "Record deleted Successfully");
        return Redirect::back();
    }

    public function accountActive(Request $request)
    {
        $user = User::find($request->id);

        if ($user) {
            $user->is_active = !$user->is_active; // Toggle the status
            $user->save();

            return response()->json([
                'success' => true,
                'status' => $user->is_active ? 'Active' : 'De-active'
            ]);
        }

        return response()->json(['success' => false, 'message' => 'User not found!']);
    }
}
