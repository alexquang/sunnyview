<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * Sets the root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @param Request $request
     * @return string
     */
    public function rootView(Request $request)
    {
        if ($request->routeIs('admin.*')) {
            return 'admin';
        }

        return 'frontend';
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
        $site = $request->routeIs('admin.*') ? 'admin' : 'frontend';

        $data = [
            'navigations' => fn () => cache()->rememberForever("{$site}.navigations", function () use ($site) {
                return \App\Models\Navigation::scopes([$site, 'parent', 'sidebar'])->with('subs')->get();
            }),
            'flash' => [
                'iMessage' => fn () => $request->session()->get('iMessage')
            ],
        ];

        if ($site == 'frontend') {
            $data['user'] = function () use ($request) {
                if ($user = $request->user()) {
                    $data = $user->only(['id', 'name', 'email']);
                    $data['company'] = optional($user->company)->only(['aws_usage_account_id']);

                    return $data;
                }

                return null;
            };

            $data['headers'] = fn () => cache()->rememberForever("{$site}.headers", function () use ($site) {
                return \App\Models\Navigation::scopes([$site, 'parent', 'header'])->with('subs')->get();
            });
        } else {
            $data['user'] = optional($request->user())->only(['id', 'name', 'email']);
        }

        return array_merge(parent::share($request), $data);
    }
}
