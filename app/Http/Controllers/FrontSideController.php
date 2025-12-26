<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Razorpay\Api\Api;
use App\Models\Booking;
use App\Models\Locations;
use App\Models\PickupDrop;
use App\Models\BusSchedule;
use App\Models\JournyPlaces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FrontSideController extends Controller
{
    public function search(Request $request)
    {
        $pickupDrops = PickupDrop::where('is_active', 1)->get();

        $fromLocations = Locations::where('is_active', 1)->get();
        $toLocations = Locations::where('is_active', 1)->get();

        if ($request->from_id != '') {
            $fromLocations = Locations::where('pickupdrop_id', $request->from_id)->where('is_active', 1)->get();
        }
        if ($request->to_id != '') {
            $toLocations = Locations::where('pickupdrop_id', $request->to_id)->where('is_active', 1)->get();
        }

        $fromId = $request->from_id ?? null;
        $toId = $request->to_id ?? null;
        $date = $request->travel_date ?? null;

        return view('front.search', compact('pickupDrops', 'fromId', 'toId', 'date', 'fromLocations', 'toLocations'));
    }

    // public function results(Request $request)
    // {
    //     $request->validate([
    //         'from_id' => 'required',
    //         'to_id' => 'required',
    //         'travel_date' => 'required|date',
    //     ]);

    //     $date = Carbon::parse($request->travel_date)->toDateString();

    //     $schedules = BusSchedule::with(['bus', 'route'])
    //         ->where('travel_date', $date)
    //         ->whereHas('route', function ($q) use ($request) {
    //             $q->where('from_id', $request->from_id)
    //                 ->where('to_id', $request->to_id)
    //                 ->where('is_active', 1);
    //         })
    //         ->get();

    //     // Return JSON response for AJAX
    //     return response()->json([
    //         'schedules' => $schedules,
    //         'search' => $request->only('from_id', 'to_id', 'travel_date'),
    //     ]);
    // }


    public function results(Request $request)
    {
        $request->validate([
            'from_id' => 'required|different:to_id',
            'to_id'   => 'required|different:from_id',
            'travel_date' => 'required|date',
        ]);

        $date = Carbon::parse($request->travel_date)->toDateString();

        // Step 1: Find all routes that include both from_id and to_id
        $routes = JournyPlaces::select('bus_route_id')
            ->whereIn('bus_route_id', function ($query) use ($request) {
                $query->select('bus_route_id')
                    ->from('journy_places')
                    ->where('pickupdrop_id', $request->from_id);
            })
            ->whereIn('bus_route_id', function ($query) use ($request) {
                $query->select('bus_route_id')
                    ->from('journy_places')
                    ->where('pickupdrop_id', $request->to_id);
            })
            ->groupBy('bus_route_id')
            ->get()
            ->pluck('bus_route_id');

        // Step 2: Make sure 'from' comes before 'to' (by sort_order)
        $validRouteIds = [];
        foreach ($routes as $routeId) {
            $fromOrder = JournyPlaces::where('bus_route_id', $routeId)
                ->where('pickupdrop_id', $request->from_id)
                ->value('sort_order');
            $toOrder = JournyPlaces::where('bus_route_id', $routeId)
                ->where('pickupdrop_id', $request->to_id)
                ->value('sort_order');

            if ($fromOrder < $toOrder) {
                $validRouteIds[] = $routeId;
            }
        }

        // Step 3: Get schedules only for these valid routes
        $schedules = BusSchedule::with(['bus', 'route'])
            ->where('travel_date', $date)
            ->whereIn('bus_route_id', $validRouteIds)
            ->get();

        return response()->json([
            'schedules' => $schedules,
            'search' => $request->only('from_id', 'to_id', 'travel_date'),
        ]);
    }

    public function getBookedSeats($scheduleId)
    {
        $bookedSeats = Booking::where('bus_schedule_id', $scheduleId)
            ->whereIn('status', ['confirmed', 'pending'])
            ->whereIn('payment_status', ['paid', 'failed'])
            ->pluck('seat_numbers')
            ->flatten()
            ->toArray();

        return response()->json([
            'booked_seats' => $bookedSeats
        ]);
    }

    public function confirm(Request $request, $id)
    {
        $schedule = BusSchedule::with('route')->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:15',
            'customer_email' => 'nullable|email',
            'seat_numbers' => 'required',
            'total_amount' => 'required|numeric|min:1',
            'alternate_phone' => 'required|string|max:15',
            'pick_location' => 'required|string',
            'drop_location' => 'required|string',
            'pin_code' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'age' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        $seatNumbers = json_decode($data['seat_numbers'], true);

        // Check if seats are already booked
        $existingBookings = Booking::where('bus_schedule_id', $id)
            ->whereIn('status', ['confirmed', 'pending'])
            ->get();

        foreach ($existingBookings as $booking) {
            $bookedSeats = is_array($booking->seat_numbers)
                ? $booking->seat_numbers
                : json_decode($booking->seat_numbers, true);

            $conflict = array_intersect($seatNumbers, $bookedSeats);
            if (!empty($conflict)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Some seats are already booked: ' . implode(', ', $conflict)
                ], 400);
            }
        }

        try {
            $booking = Booking::create([
                'bus_schedule_id' => $id,
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'customer_email' => $data['customer_email'] ?? null,
                'seat_numbers' => $seatNumbers,
                'total_amount' => $data['total_amount'],
                'alternate_phone' => $data['alternate_phone'] ?? null,
                'pick_location' => $data['pick_location'],
                'drop_location' => $data['drop_location'],
                'pin_code' => $data['pin_code'],
                'state' => $data['state'],
                'city' => $data['city'],
                'address' => $data['address'],
                'age' => $data['age'],
                'status' => 'pending',
            ]);

            // Reduce available seats
            $schedule->available_seats -= count($seatNumbers);
            $schedule->save();

            return response()->json([
                'success' => true,
                'booking_id' => $booking->id,
                'message' => 'Booking created successfully!'
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Booking creation failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to create booking. Please try again.'
            ], 500);
        }
    }

    public function payment($bookingId)
    {
        $booking = Booking::with(['schedule.bus', 'schedule.route'])
            ->findOrFail($bookingId);

        return view('front.payment', compact('booking'));
    }

    public function paymentProcess($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $orderData = [
            'receipt'         => 'order_' . uniqid(),
            'amount'          => $booking->total_amount * 100, // convert to paise
            'currency'        => 'INR',
            'payment_capture' => 1
        ];

        $order = $api->order->create($orderData);

        // Save order id
        $booking->update([
            'razorpay_order_id' => $order['id'],
            'payment_status' => 'pending',
        ]);

        return view('front.razorpay', [
            'booking' => $booking,
            'order' => $order,
            'razorpayKey' => env('RAZORPAY_KEY')
        ]);
    }

    public function paymentSuccess(Request $request)
    {
        try {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            $payment = $api->payment->fetch($request->razorpay_payment_id);

            $booking = Booking::where('razorpay_order_id', $request->razorpay_order_id)->first();

            if (!$booking) {
                abort(403, 'Booking not found.');
            }

            $bookedSeats = is_array($booking->seat_numbers)
                ? $booking->seat_numbers
                : explode(',', $booking->seat_numbers);


            $bus_schedule_id = $booking->bus_schedule_id;

            Booking::where('bus_schedule_id', $bus_schedule_id)
                ->where('id', '!=', $booking->id)
                ->where('payment_status', 'pending')
                ->where(function ($query) use ($bookedSeats) {
                    foreach ($bookedSeats as $seat) {
                        $query->orWhereRaw("FIND_IN_SET(?, seat_numbers)", [$seat]);
                    }
                })
                ->update(['status' => 'cancelled']);

            if ($booking) {
                $booking->update([
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'payment_status' => 'paid',
                    'status' => 'confirmed'
                ]);
            }

            return redirect()->route('site.payment.successfully', ['bookingId' => $booking->id]);
        } catch (Exception $e) {
            // return redirect()->route('site.payment.failed')->with('error', $e->getMessage());
            abort(403, $e->getMessage());
        }
    }
}
