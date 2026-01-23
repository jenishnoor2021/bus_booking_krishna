<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bus;
use App\Models\Booking;
use App\Models\BusRoute;
use App\Models\Locations;
use App\Models\BusSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class AdminBusScheduleController extends Controller
{

    public function index(Request $request)
    {
        $buses = Bus::where('is_active', 1)->get();

        $query = BusSchedule::with(['bus', 'route']);

        if ($request->filled('bus_id')) {
            $query->where('bus_id', $request->bus_id);
        }

        if ($request->filled('travel_date')) {
            $query->whereDate('travel_date', $request->travel_date);
        } else {
            // Default: show only upcoming schedules
            $query->whereDate('travel_date', '>=', now()->toDateString());
        }

        $busSchedules = $query->orderBy('travel_date', 'asc')->get();

        return view('admin.bus_schedules.index', compact('busSchedules', 'buses'));
    }

    public function create()
    {
        $buses = Bus::where('is_active', 1)->get();
        $routes = BusRoute::where('is_active', 1)->get();
        return view('admin.bus_schedules.form', compact('buses', 'routes'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'bus_id' => 'required|exists:buses,id',

            'schedule_type' => 'required|in:single,range',

            'travel_date' => 'required_if:schedule_type,single|nullable|date',

            'start_date'  => 'required_if:schedule_type,range|nullable|date',
            'end_date'    => 'required_if:schedule_type,range|nullable|date|after_or_equal:start_date',
            'interval_days' => 'required_if:schedule_type,range|nullable|integer|min:1',

            'trips' => 'required|array|min:1',
            'trips.*.route_id' => 'required|exists:bus_routes,id',
            'trips.*.time' => 'required',

            'available_seats' => 'required|integer|min:1',
        ]);

        if ($request->schedule_type === 'single') {
            $start = Carbon::parse($request->travel_date);
            $end = $start;
            $interval = 1;
        } else {
            $start = Carbon::parse($request->start_date);
            $end = Carbon::parse($request->end_date);
            $interval = (int) $request->interval_days;
        }

        DB::beginTransaction();

        try {

            for ($date = $start->copy(); $date->lte($end); $date->addDays($interval)) {

                foreach ($request->trips as $trip) {

                    $alreadyExists = BusSchedule::where([
                        'bus_id' => $request->bus_id,
                        'bus_route_id' => $trip['route_id'],
                        'travel_date' => $date->toDateString(),
                        'travel_time' => $trip['time'],
                    ])->exists();

                    if ($alreadyExists) {
                        continue; // skip duplicates
                    }

                    BusSchedule::create([
                        'bus_id' => $request->bus_id,
                        'bus_route_id' => $trip['route_id'],
                        'travel_date' => $date->toDateString(),
                        'travel_time' => $trip['time'],
                        'available_seats' => $request->available_seats,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.bus_schedules.index')
                ->with('success', 'Schedules generated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Failed to generate schedules');
        }
    }

    public function edit($id)
    {
        $schedule = BusSchedule::findOrFail($id);
        $buses = Bus::where('is_active', 1)->get();
        $routes = BusRoute::where('is_active', 1)->get();

        return view('admin.bus_schedules.form', compact('schedule', 'buses', 'routes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'bus_route_id' => 'required|exists:bus_routes,id',
            'travel_date' => 'required|date',
            'travel_time' => 'required',
            'available_seats' => 'required|integer|min:1',
        ]);

        $schedule = BusSchedule::findOrFail($id);

        $exists = BusSchedule::where('id', '!=', $id)
            ->where('bus_id', $request->bus_id)
            ->where('bus_route_id', $request->bus_route_id)
            ->where('travel_date', $request->travel_date)
            ->where('travel_time', $request->travel_time)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', 'Same bus, route, date and time already exists.');
        }

        $schedule->update([
            'bus_id' => $request->bus_id,
            'bus_route_id' => $request->bus_route_id,
            'travel_date' => $request->travel_date,
            'travel_time' => $request->travel_time,
            'available_seats' => $request->available_seats,
        ]);

        return  redirect('/admin/bus_schedules')->with('success', "Update Record Successfully");
    }

    public function destroy($id)
    {
        $busRoute = BusSchedule::findOrFail($id);
        $busRoute->delete();

        return  Redirect::back()->with('success', "Deleted Record Successfully");
    }

    // public function generateNext15Days()
    // {
    //     $today = Carbon::today();
    //     $endDate = $today->copy()->addDays(9);
    //     $createdCount = 0;

    //     $buses = Bus::where('is_active', 1)->get();

    //     foreach ($buses as $bus) {
    //         // Find Surat→Jamnagar and Jamnagar→Surat routes for this bus
    //         $routes = $bus->routes()->where('is_active', 1)->get();

    //         if ($routes->count() < 2) {
    //             continue; // skip if not both routes
    //         }

    //         // You can identify route A and B by from/to or just order
    //         $routeA = $routes[0];
    //         $routeB = $routes[1];

    //         $dayIndex = 0;

    //         for ($date = $today->copy(); $date->lte($endDate); $date->addDay()) {
    //             $selectedRoute = ($dayIndex % 2 == 0) ? $routeA : $routeB;

    //             // Avoid duplicate schedules for same bus+date
    //             $exists = BusSchedule::where('bus_id', $bus->id)
    //                 ->where('travel_date', $date->toDateString())
    //                 ->exists();

    //             if (! $exists) {
    //                 BusSchedule::create([
    //                     'bus_id' => $bus->id,
    //                     'bus_route_id' => $selectedRoute->id,
    //                     'travel_date' => $date->toDateString(),
    //                     'available_seats' => $selectedRoute->total_seat,
    //                 ]);

    //                 $createdCount++;
    //             }

    //             $dayIndex++;
    //         }
    //     }

    //     return back()->with('success', "✅ Generated {$createdCount} schedules successfully for next 15 days.");
    // }

    public function book($id)
    {
        $schedule = BusSchedule::with('bus', 'route')->findOrFail($id);
        $layout = json_decode($schedule->bus->seat_layout, true);
        $bookedSeats = Booking::where('bus_schedule_id', $id)->whereIn('status', ['confirmed', 'pending'])->pluck('seat_numbers')->flatten()->toArray();

        $fromLocations = Locations::where('pickupdrop_id', $schedule->route->from_id)->where('is_active', 1)->get();
        $toLocations = Locations::where('pickupdrop_id', $schedule->route->to_id)->where('is_active', 1)->get();

        return view('admin.bus_schedules.book', compact('schedule', 'layout', 'bookedSeats', 'fromLocations', 'toLocations'));
    }

    public function storeBooking(Request $request, $id)
    {
        $data = $request->validate([
            'seat_numbers' => 'required',
            'customer_name' => 'nullable|string',
            'customer_phone' => 'nullable|string',
        ]);

        Booking::create([
            'bus_schedule_id' => $id,
            'customer_name' => $data['customer_name'] ?? 'Reserved',
            'customer_phone' => $data['customer_phone'] ?? '',
            'seat_numbers' => json_decode($data['seat_numbers'], true),
            'total_amount' => 0,
            'status' => 'confirmed',
            'booked_by' => 'admin',
        ]);

        return redirect()->route('admin.bus_schedules.index')->with('success', 'Seats successfully booked.');
    }
}
