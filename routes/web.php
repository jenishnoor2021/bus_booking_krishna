<?php

use App\Models\Gallery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminBusController;
use App\Http\Controllers\FrontSideController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\AdminCompanyController;
use App\Http\Controllers\AdminContactController;
use App\Http\Controllers\AdminGalleryController;
use App\Http\Controllers\AdminSlidersController;
use App\Http\Controllers\AdminBusRouteController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminLocationsController;
use App\Http\Controllers\AdminPickupDropController;
use App\Http\Controllers\AdminTestominalController;
use App\Http\Controllers\AdminBusScheduleController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', [AdminController::class, 'siteHomePage'])->name('site.home');

// Route::get('/search', [FrontSideController::class, 'index'])->name('site.search');
// Route::get('/search/results', [FrontSideController::class, 'results'])->name('site.search.results');
// Route::get('/book/{schedule}', [FrontSideController::class, 'book'])->name('site.book');
// Route::post('/book/{schedule}', [FrontSideController::class, 'confirm'])->name('site.book.confirm');
// Route::get('/payment/{bid}', [FrontSideController::class, 'payment'])->name('site.payment');

Route::get('/about', [AdminController::class, 'about'])->name('site.about');
Route::get('/gallerys', [AdminController::class, 'gallery'])->name('site.gallerys');
Route::get('/contact', [AdminController::class, 'contact'])->name('site.contact');
Route::post('/contactstore', [AdminController::class, 'storeContact'])->name('storeContact')->middleware('throttle:5,1');
Route::get('/booking-info', [AdminController::class, 'bookingInfo'])->name('site.bookingInfo');
Route::post('/bookingInfoFind', [AdminController::class, 'bookingInfoFind'])->name('bookingInfoFind')->middleware('throttle:5,1');

// Route::get('/manage-booking', [AdminController::class, 'manageBooking'])->name('site.manage-booking');
Route::get('/search', [FrontSideController::class, 'search'])->name('site.search');
Route::get('/search/results', [FrontSideController::class, 'results'])->name('site.search.results');
Route::get('/api/booked-seats/{scheduleId}', [FrontSideController::class, 'getBookedSeats']);
Route::post('/book/confirm/{id}', [FrontSideController::class, 'confirm'])->name('site.book.confirm');
Route::get('/payment/{bookingId}', [FrontSideController::class, 'payment'])->name('site.payment');
Route::post('/payment/process/{bookingId}', [FrontSideController::class, 'paymentProcess'])->name('site.payment.process');
Route::post('/payment/success', [FrontSideController::class, 'paymentSuccess'])->name('site.payment.success');
Route::get('/payment/success/{bookingId}', function ($bookingId) {
    $booking = \App\Models\Booking::find($bookingId);
    return view('front.payment_success', compact('booking'));
})->name('site.payment.successfully');


//  for admin registration below comment uncomment karvi and above auth.login ne comment karvi
// Route::get('/', function () {
//     return view('welcome');
// });
// Auth::routes();

// Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/admin/login', function () {
    return view('auth.login');
})->name('admin.login');
Route::post('/login', [AdminController::class, 'login'])->name('login');
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

Route::get('/admin/bookings/ticket/{id}', [AdminBookingController::class, 'ticketDownload'])
    ->name('admin.bookings.ticket');


Route::group(['middleware' => ['auth', 'usersession']], function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin');

    Route::get('/profile/{id}', [AdminController::class, 'profiledit'])->name('profile.edit');
    Route::post('/profile/update', [AdminController::class, 'profileUpdate'])->name('profile.update');

    Route::get("admin/company", [AdminCompanyController::class, 'index'])->name('admin.company.index');
    Route::get('admin/company/create', [AdminCompanyController::class, 'create'])->name('admin.company.create');
    Route::post('admin/company/store', [AdminCompanyController::class, 'store'])->name('admin.company.store');
    Route::get('admin/company/edit/{id}', [AdminCompanyController::class, 'edit'])->name('admin.company.edit');
    Route::patch('admin/company/update/{id}', [AdminCompanyController::class, 'update'])->name('admin.company.update');
    Route::get('admin/company/destroy/{id}', [AdminCompanyController::class, 'destroy'])->name('admin.company.destroy');
    Route::post("admin/company/active", [AdminCompanyController::class, 'statusUpdate'])->name('admin.company.active');

    Route::get("admin/users", [AdminController::class, 'index'])->name('admin.users.index');
    Route::get('admin/users/create', [AdminController::class, 'create'])->name('admin.users.create');
    Route::post('admin/users/store', [AdminController::class, 'store'])->name('admin.users.store');
    Route::get('admin/users/edit/{id}', [AdminController::class, 'edit'])->name('admin.users.edit');
    Route::patch('admin/users/update/{id}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::get('admin/users/destroy/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    Route::post("admin/users/active", [AdminController::class, 'accountActive'])->name('admin.users.active');

    Route::get("admin/album", [AdminGalleryController::class, 'index'])->name('admin.album.index');
    Route::get('admin/album/create', [AdminGalleryController::class, 'create'])->name('admin.album.create');
    Route::post('admin/album/store', [AdminGalleryController::class, 'store'])->name('admin.album.store');
    Route::get('admin/album/edit/{id}', [AdminGalleryController::class, 'edit'])->name('admin.album.edit');
    Route::patch('admin/album/update/{id}', [AdminGalleryController::class, 'update'])->name('admin.album.update');
    Route::get('admin/album/destroy/{id}', [AdminGalleryController::class, 'destroy'])->name('admin.album.destroy');
    Route::post("admin/album/active", [AdminGalleryController::class, 'statusUpdate'])->name('admin.album.active');

    Route::get("admin/testomonial", [AdminTestominalController::class, 'index'])->name('admin.testomonial.index');
    Route::get('admin/testomonial/create', [AdminTestominalController::class, 'create'])->name('admin.testomonial.create');
    Route::post('admin/testomonial/store', [AdminTestominalController::class, 'store'])->name('admin.testomonial.store');
    Route::get('admin/testomonial/edit/{id}', [AdminTestominalController::class, 'edit'])->name('admin.testomonial.edit');
    Route::patch('admin/testomonial/update/{id}', [AdminTestominalController::class, 'update'])->name('admin.testomonial.update');
    Route::get('admin/testomonial/destroy/{id}', [AdminTestominalController::class, 'destroy'])->name('admin.testomonial.destroy');
    Route::delete('/mytestomonialDeleteAll', [AdminTestominalController::class, 'deleteTestomonialAll'])->name('deletetestomonialAll');
    Route::get("admin/testomonial/searchtestompnial", [AdminTestominalController::class, 'searchTestomonial'])->name('admin.testomonial.search');
    Route::post("admin/testomonial/active", [AdminTestominalController::class, 'statusUpdate'])->name('admin.testomonial.active');

    Route::get("admin/slider", [AdminSlidersController::class, 'index'])->name('admin.slider.index');
    Route::get('admin/slider/create', [AdminSlidersController::class, 'create'])->name('admin.slider.create');
    Route::post('admin/slider/store', [AdminSlidersController::class, 'store'])->name('admin.slider.store');
    Route::get('admin/slider/edit/{id}', [AdminSlidersController::class, 'edit'])->name('admin.slider.edit');
    Route::patch('admin/slider/update/{id}', [AdminSlidersController::class, 'update'])->name('admin.slider.update');
    Route::get('admin/slider/destroy/{id}', [AdminSlidersController::class, 'destroy'])->name('admin.slider.destroy');
    Route::post("admin/slider/active", [AdminSlidersController::class, 'statusUpdate'])->name('admin.slider.active');

    Route::get("admin/bus", [AdminBusController::class, 'index'])->name('admin.bus.index');
    Route::get('admin/bus/create', [AdminBusController::class, 'create'])->name('admin.bus.create');
    Route::post('admin/bus/store', [AdminBusController::class, 'store'])->name('admin.bus.store');
    Route::get('admin/bus/edit/{id}', [AdminBusController::class, 'edit'])->name('admin.bus.edit');
    Route::patch('admin/bus/update/{id}', [AdminBusController::class, 'update'])->name('admin.bus.update');
    Route::get('admin/bus/destroy/{id}', [AdminBusController::class, 'destroy'])->name('admin.bus.destroy');
    Route::post("admin/bus/active", [AdminBusController::class, 'statusUpdate'])->name('admin.bus.active');

    Route::get("admin/pickup_drop", [AdminPickupDropController::class, 'index'])->name('admin.pickup_drop.index');
    Route::get('admin/pickup_drop/create', [AdminPickupDropController::class, 'create'])->name('admin.pickup_drop.create');
    Route::post('admin/pickup_drop/store', [AdminPickupDropController::class, 'store'])->name('admin.pickup_drop.store');
    Route::get('admin/pickup_drop/edit/{id}', [AdminPickupDropController::class, 'edit'])->name('admin.pickup_drop.edit');
    Route::patch('admin/pickup_drop/update/{id}', [AdminPickupDropController::class, 'update'])->name('admin.pickup_drop.update');
    Route::get('admin/pickup_drop/destroy/{id}', [AdminPickupDropController::class, 'destroy'])->name('admin.pickup_drop.destroy');
    Route::post("admin/pickup_drop/active", [AdminPickupDropController::class, 'statusUpdate'])->name('admin.pickup_drop.active');

    Route::get("admin/bus_routes", [AdminBusRouteController::class, 'index'])->name('admin.bus_routes.index');
    Route::get('admin/bus_routes/create', [AdminBusRouteController::class, 'create'])->name('admin.bus_routes.create');
    Route::post('admin/bus_routes/store', [AdminBusRouteController::class, 'store'])->name('admin.bus_routes.store');
    Route::get('admin/bus_routes/edit/{id}', [AdminBusRouteController::class, 'edit'])->name('admin.bus_routes.edit');
    Route::patch('admin/bus_routes/update/{id}', [AdminBusRouteController::class, 'update'])->name('admin.bus_routes.update');
    Route::get('admin/bus_routes/destroy/{id}', [AdminBusRouteController::class, 'destroy'])->name('admin.bus_routes.destroy');
    Route::post("admin/bus_routes/active", [AdminBusRouteController::class, 'statusUpdate'])->name('admin.bus_routes.active');
    Route::get('admin/bus_routes/{id}/copy', [AdminBusRouteController::class, 'copy'])->name('admin.bus_routes.copy');

    Route::post('bus-route/journey/save', [AdminBusRouteController::class, 'saveJourney'])->name('bus_route.journey.save');
    Route::delete('bus-route/journey/{id}', [AdminBusRouteController::class, 'deleteJourneyPlace'])->name('bus_route.journey.delete');
    Route::post('bus-route/journey/reorder', [AdminBusRouteController::class, 'reorderJourney'])
        ->name('bus_route.journey.reorder');

    Route::get("admin/bus_schedules", [AdminBusScheduleController::class, 'index'])->name('admin.bus_schedules.index');
    Route::get('admin/bus_schedules/create', [AdminBusScheduleController::class, 'create'])->name('admin.bus_schedules.create');
    Route::post('admin/bus_schedules/store', [AdminBusScheduleController::class, 'store'])->name('admin.bus_schedules.store');
    Route::get('admin/bus_schedules/edit/{id}', [AdminBusScheduleController::class, 'edit'])->name('admin.bus_schedules.edit');
    Route::patch('admin/bus_schedules/update/{id}', [AdminBusScheduleController::class, 'update'])->name('admin.bus_schedules.update');
    Route::get('admin/bus_schedules/destroy/{id}', [AdminBusScheduleController::class, 'destroy'])->name('admin.bus_schedules.destroy');
    Route::get('admin/bus_schedules/{schedule}/book', [AdminBusScheduleController::class, 'book'])->name('admin.bus_schedules.book');
    Route::post('admin/bus_schedules/{schedule}/book', [AdminBusScheduleController::class, 'storeBooking'])->name('admin.bus_schedules.book.store');

    Route::get('/admin/generate-schedules', [AdminBusScheduleController::class, 'generateNext15Days'])
        ->name('admin.generateSchedules');

    Route::get("admin/bookings", [AdminBookingController::class, 'index'])->name('admin.bookings.index');
    Route::get('/bookings/{id}', [AdminBookingController::class, 'show'])->name('admin.bookings.show');
    Route::get('/admin/bookings/cancel/{id}', [AdminBookingController::class, 'cancelBooking'])
        ->name('admin.bookings.cancel');
    Route::get('/admin/bookings/{id}/edit', [AdminBookingController::class, 'edit'])->name('admin.bookings.edit');
    Route::post('/admin/bookings/{id}', [AdminBookingController::class, 'update'])->name('admin.bookings.update');
    Route::get('/admin/bookings/export', [AdminBookingController::class, 'export'])
        ->name('admin.bookings.export');

    // Route::get('admin/bookings/create', [AdminBookingController::class, 'create'])->name('admin.bookings.create');
    // Route::post('admin/bookings/store', [AdminBookingController::class, 'store'])->name('admin.bookings.store');
    // Route::get('admin/bookings/destroy/{id}', [AdminBookingController::class, 'destroy'])->name('admin.bookings.destroy');
    // Route::post("admin/bookings/active", [AdminBookingController::class, 'statusUpdate'])->name('admin.bookings.active');

    Route::get("admin/contact", [AdminContactController::class, 'index'])->name('admin.contact.index');
    Route::get('admin/contact/create', [AdminContactController::class, 'create'])->name('admin.contact.create');
    Route::post('admin/contact/store', [AdminContactController::class, 'store'])->name('admin.contact.store');
    Route::get('admin/contact/edit/{id}', [AdminContactController::class, 'edit'])->name('admin.contact.edit');
    Route::patch('admin/contact/update/{id}', [AdminContactController::class, 'update'])->name('admin.contact.update');
    Route::get('admin/contact/destroy/{id}', [AdminContactController::class, 'destroy'])->name('admin.contact.destroy');
    Route::post("admin/contact/active", [AdminContactController::class, 'statusUpdate'])->name('admin.contact.active');
    Route::post('/admin/contact/bulk-delete', [AdminContactController::class, 'bulkDelete'])->name('admin.contact.bulkDelete');

    Route::get("admin/locations", [AdminLocationsController::class, 'index'])->name('admin.locations.index');
    Route::get('admin/locations/create', [AdminLocationsController::class, 'create'])->name('admin.locations.create');
    Route::post('admin/locations/store', [AdminLocationsController::class, 'store'])->name('admin.locations.store');
    Route::get('admin/locations/edit/{id}', [AdminLocationsController::class, 'edit'])->name('admin.locations.edit');
    Route::patch('admin/locations/update/{id}', [AdminLocationsController::class, 'update'])->name('admin.locations.update');
    Route::get('admin/locations/destroy/{id}', [AdminLocationsController::class, 'destroy'])->name('admin.locations.destroy');
    Route::post("admin/locations/active", [AdminLocationsController::class, 'statusUpdate'])->name('admin.locations.active');
});

//Clear Cache facade value:
Route::get('/admin/clear-cache', function () {
    Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/admin/optimize', function () {
    Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/admin/route-cache', function () {
    Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/admin/route-clear', function () {
    Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/admin/view-clear', function () {
    Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/admin/config-cache', function () {
    Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});
