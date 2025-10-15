<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Bus;
use Illuminate\Support\Str;
use App\Models\BusRoute;
use App\Models\JournyPlaces;
use App\Models\PickupDrop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminBusRouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $busRoutes = BusRoute::orderBy('id', 'DESC')->get();
        return view('admin.bus_routes.index', compact('busRoutes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $buses = Bus::where('is_active', 1)->get();
        $pickupdrops = PickupDrop::where('is_active', 1)->get();
        return view('admin.bus_routes.create', compact('buses', 'pickupdrops'));
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
            // 'buses_id' => 'required|exists:buses,id',
            'route_name' => ['required'],
            'from_id' => 'required',
            'departure_time' => 'required',
            'to_id' => 'required',
            'arrival_time' => 'required',
            'total_duration' => 'required',
            'total_seat' => 'required',
            'price' => 'required',
            'run' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Generate unique slug
        $slug = Str::slug($request->route_name);
        $originalSlug = $slug;
        $counter = 1;

        while (BusRoute::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $busRoute = BusRoute::create([
            // 'buses_id'       => $request->buses_id,
            'route_name'     => $request->route_name,
            'slug'           => $slug,
            'from_id'  => $request->from_id,
            'departure_time'  => $request->departure_time,
            'to_id' => $request->to_id,
            'arrival_time'  => $request->arrival_time,
            'total_duration' => $request->total_duration,
            'total_seat'     => $request->total_seat,
            'price'          => $request->price,
            'run'            => $request->run,
        ]);

        // return redirect('/admin/bus_routes')->with('success', "Add Record Successfully");
        return redirect('/admin/bus_routes/edit/' . $busRoute->id)->with('success', "Add Record Successfully");
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
        $buses = Bus::where('is_active', 1)->get();
        $pickupdrops = PickupDrop::where('is_active', 1)->get();
        $busRoute = BusRoute::findOrFail($id);
        $journeyPlaces = JournyPlaces::where('bus_route_id', $id)
            ->orderBy('sort_order')
            ->get();
        return view('admin.bus_routes.edit', compact('busRoute', 'buses', 'pickupdrops', 'journeyPlaces'));
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
            // 'buses_id' => 'required|exists:buses,id',
            'route_name' => ['required'],
            'from_id' => 'required',
            'departure_time' => 'required',
            'to_id' => 'required',
            'arrival_time' => 'required',
            'total_duration' => 'required',
            'total_seat' => 'required',
            'price' => 'required',
            'run' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $busRoute = BusRoute::findOrFail($id);

        if ($busRoute->route_name !== $request->route_name) {
            $slug = Str::slug($request->route_name);
            $originalSlug = $slug;
            $counter = 1;

            while (BusRoute::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }
        } else {
            $slug = $busRoute->slug;
        }

        $busRoute->update([
            // 'buses_id'       => $request->buses_id,
            'route_name'     => $request->route_name,
            'slug'           => $slug,
            'from_id'  => $request->from_id,
            'departure_time'  => $request->departure_time,
            'to_id' => $request->to_id,
            'arrival_time'  => $request->arrival_time,
            'total_duration' => $request->total_duration,
            'total_seat'     => $request->total_seat,
            'price'          => $request->price,
            'run'            => $request->run,
        ]);

        return  redirect('/admin/bus_routes')->with('success', "Update Record Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $busRoute = BusRoute::findOrFail($id);
        $busRoute->delete();

        return  Redirect::back()->with('success', "Deleted Record Successfully");
    }


    public function statusUpdate(Request $request)
    {
        $busRoute = BusRoute::findOrFail($request->id);

        if ($busRoute) {
            $busRoute->is_active = !$busRoute->is_active;
            $busRoute->save();

            return response()->json([
                'success' => true,
                'status' => $busRoute->is_active ? 'Show' : 'Hide'
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Id not found!']);
    }

    public function copy($id)
    {
        $route = BusRoute::findOrFail($id);

        $newRoute = $route->replicate();
        $newRoute->route_name = $route->route_name . ' ' . time();
        $newRoute->slug = $route->slug . '_' . time(); // avoid duplicate slug
        $newRoute->is_active = 1;
        $newRoute->save();

        $journeyPlaces = JournyPlaces::where('bus_route_id', $route->id)->get();

        foreach ($journeyPlaces as $place) {
            $newPlace = $place->replicate();
            $newPlace->bus_route_id = $newRoute->id;
            $newPlace->save();
        }

        return redirect()->route('admin.bus_routes.edit', $newRoute->id)
            ->with('success', '✅ Bus route copied successfully! You can now edit it.');
    }

    public function getPlaces()
    {
        return response()->json(PickupDrop::select('id', 'place_name')->get());
    }

    public function saveJourney(Request $request)
    {
        $data = $request->all();
        $sortingOrder = 1;

        foreach ($data['places'] as $place) {
            // If 'id' exists, update
            if (isset($place['id']) && $place['id']) {
                JournyPlaces::where('id', $place['id'])->update([
                    'bus_route_id' => $data['bus_route_id'],
                    'pickupdrop_id' => $place['pickupdrop_id'],
                    'time' => $place['time'],
                    'sort_order' => $sortingOrder,
                ]);
            } else {
                // Check if this pickupdrop already exists for this bus route
                $existing = JournyPlaces::where('bus_route_id', $data['bus_route_id'])
                    ->where('pickupdrop_id', $place['pickupdrop_id'])
                    ->first();

                if ($existing) {
                    // Update the existing record instead of creating new
                    $existing->update([
                        'time' => $place['time'],
                        'sort_order' => $sortingOrder,
                    ]);
                } else {
                    // Create new record
                    JournyPlaces::create([
                        'bus_route_id' => $data['bus_route_id'],
                        'pickupdrop_id' => $place['pickupdrop_id'],
                        'time' => $place['time'],
                        'sort_order' => $sortingOrder,
                    ]);
                }
            }

            $sortingOrder++;
        }

        return response()->json(['success' => true, 'message' => 'Journey saved successfully']);
    }

    public function deleteJourneyPlace($id)
    {
        $place = JournyPlaces::findOrFail($id);
        $place->delete();

        return response()->json(['success' => true]);
    }

    public function reorderJourney(Request $request)
    {
        foreach ($request->order as $item) {
            JournyPlaces::where('id', $item['id'])
                ->update(['sort_order' => $item['position']]);
        }

        return response()->json(['success' => true, 'message' => 'Order updated successfully']);
    }
}
