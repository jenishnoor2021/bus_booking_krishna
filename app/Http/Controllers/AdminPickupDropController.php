<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\PickupDrop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminPickupDropController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pickupDrops = PickupDrop::orderBy('id', 'DESC')->get();
        return view('admin.pickup_drop.index', compact('pickupDrops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pickup_drop.create');
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
            'place_name' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $input = $request->all();

        PickupDrop::create($input);
        return redirect('/admin/pickup_drop')->with('success', "Add Record Successfully");
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
        $pickupDrop = PickupDrop::findOrFail($id);
        return view('admin.pickup_drop.edit', compact('pickupDrop'));
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
            'place_name' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $pickupDrop = PickupDrop::findOrFail($id);

        $input = $request->all();

        $pickupDrop->update($input);

        return  redirect('/admin/pickup_drop')->with('success', "Update Record Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pickupDrop = PickupDrop::findOrFail($id);
        $pickupDrop->delete();

        return  Redirect::back()->with('success', "Deleted Record Successfully");
    }


    public function statusUpdate(Request $request)
    {
        $pickupDrop = PickupDrop::findOrFail($request->id);

        if ($pickupDrop) {
            $pickupDrop->is_active = !$pickupDrop->is_active; // Toggle the status
            $pickupDrop->save();

            return response()->json([
                'success' => true,
                'status' => $pickupDrop->is_active ? 'Show' : 'Hide'
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Id not found!']);
    }
}
