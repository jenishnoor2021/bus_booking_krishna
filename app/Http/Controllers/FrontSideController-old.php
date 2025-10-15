<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\PickupDrop;
use App\Models\BusSchedule;
use Illuminate\Http\Request;

class FrontSideController extends Controller
{
    public function index()
    {
        $pickupDrops = PickupDrop::where('is_active', 1)->get();
        return view('front.search', compact('pickupDrops'));
    }

    public function results(Request $request)
    {
        $request->validate([
            'from_id' => 'required',
            'to_id' => 'required',
            'travel_date' => 'required|date',
        ]);

        $date = Carbon::parse($request->travel_date)->toDateString();

        $schedules = BusSchedule::with(['bus', 'route'])
            ->where('travel_date', $date)
            ->whereHas('route', function ($q) use ($request) {
                $q->where('from_id', $request->from_id)
                    ->where('to_id', $request->to_id)
                    ->where('is_active', 1);
            })
            ->get();

        return view('front.results', [
            'schedules' => $schedules,
            'pickupDrops' => PickupDrop::where('is_active', 1)->get(),
            'search' => $request->only('from_id', 'to_id', 'travel_date'),
        ]);
    }

    public function book($id)
    {
        $schedule = BusSchedule::with(['bus', 'route'])->findOrFail($id);
        $layout = json_decode($schedule->bus->seat_layout, true);
        $bookedSeats = Booking::where('bus_schedule_id', $id)->whereIn('status', ['confirmed', 'pending'])->pluck('seat_numbers')->flatten()->toArray();

        return view('front.book', compact('schedule', 'layout', 'bookedSeats'));
    }

    public function confirm(Request $request, $id)
    {
        $schedule = BusSchedule::with('route')->findOrFail($id);

        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            // 'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string|max:15',
            'seat_numbers' => 'required',
            'total_amount' => 'required|numeric|min:1',
        ]);

        $booking = Booking::create([
            'bus_schedule_id' => $id,
            'customer_name' => $data['customer_name'],
            'customer_phone' => $data['customer_phone'],
            'customer_email' => $request->customer_email,
            'seat_numbers' => json_decode($data['seat_numbers'], true),
            'total_amount' => $data['total_amount'],
            'status' => 'pending',
        ]);

        // Reduce available seats
        $schedule->available_seats -= 1;
        $schedule->save();

        // return redirect()->route('site.search')->with('success', 'Booking confirmed successfully!');
        return redirect()->route('site.payment', $booking->id);
    }

    public function payment($bid)
    {
        return view('front.payment');
    }
}
