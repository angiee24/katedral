<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    
    protected $rootView = 'app';

    
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    
    public function share(Request $request): array
    {
        $user = $request->user();
        $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user ? [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames()->toArray(),
                    'permissions' => $user->getAllPermissions()->pluck('name')->toArray(),
                ] : null,
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
            'settings' => [
                'church_name' => $settings['church_name'] ?? 'Katedral Samarinda',
                'church_address' => $settings['church_address'] ?? '',
                'church_phone' => $settings['church_phone'] ?? '',
                'church_maps_link' => $settings['church_maps_link'] ?? '',
                'church_logo' => $settings['church_logo'] ?? '/images/logo_katedral.png',
                'banner_image' => $settings['banner_image'] ?? '/images/katedral_hero_section.jpg',
            ]
        ];
    }
}
