<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminBusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buses = Bus::orderBy('id', 'DESC')->get();
        return view('admin.buses.index', compact('buses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.buses.create');
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
            'file' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'bus_no' => ['required', 'regex:/^\S+$/'],
            'bus_type' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $request->merge([
            'bus_no' => strtoupper($request->bus_no)
        ]);

        $input = $request->all();
        if ($file = $request->file('file')) {

            $str = $file->getClientOriginalName();
            $str = str_replace(' ', '_', $str);

            $name = time() . $str;

            $file->move('bus', $name);

            $input['file'] = "$name";
        }

        Bus::create($input);
        return redirect('/admin/bus')->with('success', "Add Record Successfully");
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
        $bus = Bus::findOrFail($id);
        return view('admin.buses.edit', compact('bus'));
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
            // 'file' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'bus_no' => 'required',
            'bus_type' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $bus = Bus::findOrFail($id);

        $request->merge([
            'bus_no' => strtoupper($request->bus_no)
        ]);

        $input = $request->all();

        if ($file = $request->file('file')) {

            $str = $file->getClientOriginalName();
            $str = str_replace(' ', '_', $str);

            $name = time() . $str;

            $file->move('bus', $name);

            $input['file'] = "$name";

            if ($bus->file == "/bus/") {
            } else {
                if (file_exists(public_path() . $bus->file)) {
                    unlink(public_path() . $bus->file);
                }
            }
        }

        $bus->update($input);

        return  redirect('/admin/bus')->with('success', "Update Record Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bus = Bus::findOrFail($id);
        if ($bus->file == '/bus/') {
        } else {
            if (file_exists(public_path() . $bus->file)) {
                unlink(public_path() . $bus->file);
            }
        }
        $bus->delete();

        return  Redirect::back()->with('success', "Deleted Record Successfully");
    }


    public function statusUpdate(Request $request)
    {
        $bus = Bus::findOrFail($request->id);

        if ($bus) {
            $bus->is_active = !$bus->is_active; // Toggle the status
            $bus->save();

            return response()->json([
                'success' => true,
                'status' => $bus->is_active ? 'Show' : 'Hide'
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Id not found!']);
    }
}
