<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{

    public function index(Request $request)
    {
        $query = Booking::with(['schedule.bus', 'schedule.route'])->latest();

        // Filter by bus
        if ($request->filled('bus_id')) {
            $query->whereHas('schedule.bus', function ($q) use ($request) {
                $q->where('id', $request->bus_id);
            });
        }

        // Filter by travel date
        if ($request->filled('travel_date')) {
            $query->whereHas('schedule', function ($q) use ($request) {
                $q->whereDate('travel_date', $request->travel_date);
            });
        }

        $bookings = $query->paginate(20);

        $buses = Bus::where('is_active', 1)->orderBy('bus_no')->get();

        return view('admin.bookings.index', compact('bookings', 'buses'));
    }

    public function show($id)
    {
        $booking = Booking::with(['schedule.bus', 'schedule.route'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    public function cancelBooking($id)
    {
        $booking = Booking::with('schedule')->findOrFail($id);

        if ($booking->status == 'cancelled') {
            return back()->with('error', 'This booking is already cancelled.');
        }

        // Mark as cancelled
        $booking->update(['status' => 'cancelled']);

        // Increase available seats
        $schedule = $booking->schedule;
        if ($schedule) {
            $schedule->available_seats += count($booking->seat_numbers ?? []);
            $schedule->save();
        }

        return back()->with('success', 'Booking cancelled and seats are now available again.');
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return view('admin.bookings.edit', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'status' => 'required|string',
            'payment_status' => 'required|string',
            'razorpay_payment_id' => 'nullable|string',
            'razorpay_order_id' => 'nullable|string',
        ]);

        $booking->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_order_id' => $request->razorpay_order_id,
        ]);

        return redirect()->back()->with('success', 'Booking updated successfully.');
    }
}
