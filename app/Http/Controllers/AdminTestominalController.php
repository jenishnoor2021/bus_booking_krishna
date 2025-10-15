<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Models\Testomonial;


class AdminTestominalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testomonial = Testomonial::orderBy('id', 'DESC')->get();
        return view('admin.testomonial.index', compact('testomonial'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.testomonial.create');
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
            'name' => 'required',
            'file' => 'required',
            'occupation' => 'required',
            'message' => 'required',
            'rate' => 'required',
        ]);

        if ($validator->fails()) {

            return Redirect::back()->withErrors($validator);
        }

        $input = $request->all();
        if ($file = $request->file('file')) {

            $str = $file->getClientOriginalName();
            $str = str_replace(' ', '_', $str);

            $name = time() . $str;

            $file->move('testomonialimg', $name);

            $input['file'] = "$name";
        }

        // $input = $request->all();
        Testomonial::create($input);
        return redirect('/admin/testomonial')->with('success', "Add Record Successfully");
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
        $testomonial = Testomonial::findOrFail($id);
        return view('admin.testomonial.edit', compact('testomonial'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'occupation' => 'required',
            'message' => 'required',
            'rate' => 'required',
        ]);

        if ($validator->fails()) {

            return Redirect::back()->withErrors($validator);
        }

        $push = Testomonial::findOrFail($id);

        $input = $request->all();

        if ($file = $request->file('file')) {

            $str = $file->getClientOriginalName();
            $str = str_replace(' ', '_', $str);

            $name = time() . $str;

            $file->move('testomonialimg', $name);

            $input['file'] = "$name";

            if ($push->file == "/testomonialimg/") {
            } else {
                if (file_exists(public_path() . $push->file)) {
                    unlink(public_path() . $push->file);
                }
            }
        }

        $push->update($input);

        return  redirect('/admin/testomonial')->with('success', "Update Record Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $backimg = Testomonial::findOrFail($id);
        if ($backimg->file == '/testomonialimg/') {
        } else {
            if (file_exists(public_path() . $backimg->file)) {
                unlink(public_path() . $backimg->file);
            }
        }
        $backimg->delete();

        return  Redirect::back()->with('success', "Deleted Record Successfully");
    }

    public function searchTestomonial(Request $request)
    {
        $data = $request->quer;
        $testomonial = Testomonial::where('name', 'like', '%' . $data . '%')->orderBy('id', 'DESC')->get();
        return view('admin.testomonial.index', compact('testomonial'));
    }

    public function statusUpdate(Request $request)
    {
        $testomonial = Testomonial::find($request->id);

        if ($testomonial) {
            $testomonial->is_active = !$testomonial->is_active; // Toggle the status
            $testomonial->save();

            return response()->json([
                'success' => true,
                'status' => $testomonial->is_active ? 'Show' : 'Hide'
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Id not found!']);
    }
}
