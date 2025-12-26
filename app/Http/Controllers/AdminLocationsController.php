<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Locations;
use App\Models\PickupDrop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminLocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Locations::orderBy('id', 'DESC')->get();
        $pickupDrops = PickupDrop::where('is_active', 1)->orderBy('id', 'DESC')->get();
        return view('admin.locations.index', compact('locations', 'pickupDrops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.locations.create');
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
            'location_name' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $input = $request->all();

        Locations::create($input);
        return redirect('/admin/locations')->with('success', "Add Record Successfully");
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
        $location = Locations::findOrFail($id);
        $pickupDrops = PickupDrop::orderBy('id', 'DESC')->get();
        return view('admin.locations.edit', compact('location', 'pickupDrops'));
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
            'location_name' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $location = Locations::findOrFail($id);

        $input = $request->all();

        $location->update($input);

        return  redirect('/admin/locations')->with('success', "Update Record Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $location = Locations::findOrFail($id);
        $location->delete();

        return  Redirect::back()->with('success', "Deleted Record Successfully");
    }


    public function statusUpdate(Request $request)
    {
        $location = Locations::findOrFail($request->id);

        if ($location) {
            $location->is_active = !$location->is_active; // Toggle the status
            $location->save();

            return response()->json([
                'success' => true,
                'status' => $location->is_active ? 'Show' : 'Hide'
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Id not found!']);
    }
}
