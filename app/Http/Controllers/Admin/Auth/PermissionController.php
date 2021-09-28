<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuthPermission;
use App\Services\AuthPermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private $authPermissionService;

    public function __construct(AuthPermissionService $authPermissionService)
    {
        $this->authPermissionService = $authPermissionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = $this->authPermissionService->withScopes(['enabled'])->list([
            'id',
            'name',
            'is_premium_feature',
            'is_developer_feature',
            'is_enabled',
            'description',
        ]);

        return \Inertia::render('Admin/Auth/Permissions/Index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AuthPermission  $authPermission
     * @return \Illuminate\Http\Response
     */
    public function show(AuthPermission $authPermission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AuthPermission  $authPermission
     * @return \Illuminate\Http\Response
     */
    public function edit(AuthPermission $authPermission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AuthPermission  $authPermission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuthPermission $authPermission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AuthPermission  $authPermission
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuthPermission $authPermission)
    {
        //
    }
}
