<?php

namespace App\Providers;

use App\Models\Company;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $company = Company::first();
        if (!$company) {
            $number = '1111111111';
            $address = 'test address';
            $email = 'test@gmail.com';
            $facebook = 'https://www.facebook.com/';
            $instagram = 'https://www.instagram.com/accounts/login/?hl=en';
            $twitter = 'https://twitter.com/login?';
            $linkdin = 'https://www.linkedin.com/login';
        } else {
            $number = $company->contact;
            $address = $company->address;
            $email = $company->email;
            $facebook = $company->facebook;
            $instagram = $company->instagram;
            $twitter = $company->twitter;
            $linkdin = $company->linkdin;
        }
        View::share([
            'contact' => $number,
            'address' => $address,
            'email' => $email,
            'facebook' => $facebook,
            'instagram' => $instagram,
            'twitter' => $twitter,
            'linkdin' => $linkdin,
            'whatsapp_no' => '9429989999',
        ]);
    }
}
