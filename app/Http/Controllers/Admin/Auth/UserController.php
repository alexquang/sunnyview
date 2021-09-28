<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserRequest;
use App\Models\AuthUser;
use App\Services\AuthUserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    const SCOPES = ['internal'];

    /**
     *
     * @var AuthUserService
     */
    private $authUserService;

    public function __construct(AuthUserService $authUserService)
    {
        $this->authUserService = $authUserService;
    }

    public function index()
    {
        $users = $this->authUserService
            ->withScopes(self::SCOPES)
            ->list([
                'id',
                'name',
                'email',
                'last_logged_in_at',
                'is_enabled',
            ]);

        return \Inertia::render('Admin/Auth/Users/Index', compact('users'));
    }

    public function show(AuthUser $user)
    {
        return \Inertia::render('Admin/Auth/Users/_tabs/Form', compact('user'));
    }

    public function update(AuthUser $user, UserRequest $request)
    {
        $this->authUserService->update($user, $request->input('auth.user', []));

        return back()->with([
            'iMessage' => \InertiaMessage::success('messages.update'),
        ]);
    }

    public function create(Request $request)
    {
        $user = new AuthUser(['is_enabled' => true]);

        return \Inertia::render('Admin/Auth/Users/Form', compact('user'));
    }

    public function store(UserRequest $request)
    {
        $user = $this->authUserService->create($request->input('auth.user', []));

        return redirect(route('admin.auth.users.show', $user))->with([
            'iMessage' => \InertiaMessage::success('messages.create'),
        ]);
    }

    public function destroy(AuthUser $user)
    {
        $this->authUserService->delete($user);

        return redirect(route('admin.auth.users.index'))->with([
            'iMessage' => \InertiaMessage::success('messages.delete'),
        ]);
    }
}
