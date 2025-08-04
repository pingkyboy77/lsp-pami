<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Footer;
use App\Observers\ActivityObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $footer = Footer::first();

            $view->with([
                'footer_logo' => $footer?->logo,
                'footer_description' => $footer?->description,
                'footer_map_embed' => $footer?->map_embed,
                'footer_address' => $footer?->address,
                'footer_phone' => $footer?->phone,
                'footer_email' => $footer?->email,
                'footer_city' => $footer?->city,
                'footer_socials' => json_decode($footer?->socials ?? '[]', true),
                'footer_certification_title' => $footer?->certification_title,
                'footer_certification_links' => json_decode($footer?->certification_links ?? '[]', true),
                'footer_subscription_title' => $footer?->subscription_title,
                'footer_subscription_text' => $footer?->subscription_text,
                'footer_subscription_button' => $footer?->subscription_button,
                'footer_subscription_url' => $footer?->subscription_url,
            ]);

        });
    }
}
