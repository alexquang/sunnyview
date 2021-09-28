<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RoleRequest;
use App\Models\AuthRole;
use App\Services\AuthRoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $authRoleService;

    public function __construct(AuthRoleService $authRoleService)
    {
        $this->authRoleService = $authRoleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->authRoleService
            ->withCounts(['users' => function ($query) {
                $query->internal();
            }])
            ->list([
                'id',
                'name',
                'is_enabled',
                'is_published',
            ]);

        return \Inertia::render('Admin/Auth/Roles/Index', compact('roles'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AuthRole  $role
     * @return \Illuminate\Http\Response
     */
    public function show(AuthRole $role)
    {
        return \Inertia::render('Admin/Auth/Roles/_tabs/Form', compact('role'));
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\AuthRole  $role
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(AuthRole $role)
    // {
    //     //
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \App\Http\Requests\Auth\RoleRequest $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(RoleRequest $request)
    // {
    //     $authRole = $this->authRoleService->create($request->input('auth.role'));

    //     return back()->with([
    //         'authRole' => $role,
    //         'iMessage' => \InertiaMessage::success('messages.create'),
    //     ]);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\AuthRole  $role
     * @param  \App\Http\Requests\Auth\RoleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(AuthRole $role, RoleRequest $request)
    {
        $this->authRoleService->update($role, $request->input('auth.role'));

        return back()->with([
            'iMessage' => \InertiaMessage::success('messages.update'),
        ]);
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\AuthRole  $role
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(AuthRole $role)
    // {
    //     $this->authRoleService->delete($authRole);

    //     return back()->with([
    //         'iMessage' => \InertiaMessage::success('messages.delete'),
    //     ]);
    // }
}
