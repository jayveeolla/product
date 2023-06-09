<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Auth;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    // protected $rootView = 'app';

    public function rootView(Request $request)
    {
        // if ($request->routeIs('admin.*')) {
        //     return 'admin';
        // }
        return 'admin';
    }

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {

        $user_permission = Auth::check() ? auth()->user()->getAllPermissions()->pluck('name') : [];
        $user_role = Auth::check() ? auth()->user()->roles->pluck('name') : [];
        return array_merge(parent::share($request), [
            'permission' => $user_permission,
            'role' => $user_role
        ]);
    }
}
