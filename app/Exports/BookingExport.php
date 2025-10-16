<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookingExport implements FromCollection, WithHeadings, WithMapping
{
    protected $busId;
    protected $travelDate;

    public function __construct($busId = null, $travelDate = null)
    {
        $this->busId = $busId;
        $this->travelDate = $travelDate;
    }

    public function collection()
    {
        $query = Booking::with(['schedule.bus', 'schedule.route']);

        if ($this->busId) {
            $query->whereHas('schedule', function ($q) {
                $q->where('bus_id', $this->busId);
            });
        }

        if ($this->travelDate) {
            $query->whereHas('schedule', function ($q) {
                $q->whereDate('travel_date', $this->travelDate);
            });
        }

        return $query->latest()->get();
    }

    public function map($booking): array
    {
        return [
            $booking->id,
            optional($booking->schedule->bus)->bus_no ?? '-',
            optional($booking->schedule->route)->route_name ?? '-',
            optional($booking->schedule)->travel_date ?? '-',
            is_array($booking->seat_numbers)
                ? implode(', ', $booking->seat_numbers)
                : implode(', ', json_decode($booking->seat_numbers ?? '[]', true)),
            $booking->customer_name ?? '-',
            $booking->customer_phone ?? '-',
            $booking->pick_location ?? '-',
            $booking->drop_location ?? '-',
            ucfirst($booking->booked_by ?? '-'),
            ucfirst($booking->status ?? '-'),
            ucfirst($booking->payment_status ?? '-'),
            $booking->razorpay_order_id ?? '-',
            $booking->razorpay_payment_id ?? '-',
            $booking->total_amount ?? 0,
            $booking->customer_email ?? '-',
            $booking->alternate_phone ?? '-',
            $booking->address ?? '-',
            $booking->pin_code ?? '-',
            $booking->state ?? '-',
            $booking->city ?? '-',
            $booking->age ?? '-',
            $booking->created_at->format('Y-m-d H:i A'),
        ];
    }

    public function headings(): array
    {
        return [
            'Booking ID',
            'Bus',
            'Route',
            'Travel Date',
            'Seats',
            'Customer Name',
            'Customer Phone',
            'Pick Location',
            'Drop Location',
            'Booked By',
            'Status',
            'Payment Status',
            'Razorpay Order ID',
            'Razorpay Payment ID',
            'Total Amount',
            'Customer Email',
            'Alternet Phone',
            'Address',
            'Pincode',
            'State',
            'City',
            'Age',
            'Created At',
        ];
    }
}
