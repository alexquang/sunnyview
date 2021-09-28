<?php

use App\Http\Controllers\Admin\{
    TestController,
    DashboardController,

    Auth\AuthController,
    Auth\UserController,
    Auth\RoleController as AuthRoleController,
    Auth\RoleUserController as AuthRoleUserController,
    Auth\RolePermissionController as AuthRolePermissionController,
    Auth\PermissionController as AuthPermissionController,
    Auth\UserPermissionController as AuthUserPermissionController,
    Auth\UserRoleController as AuthUserRoleController,

    Aws\AccountController as AwsAccountController,

    Company\CompanyController,
    Company\CompanyContractController,
    Company\CompanyGroupController,
    Company\CompanySettingController,
    Company\CompanyTrustController,
    Company\CompanyUserController,

    Invoice\InvoiceController,
    Invoice\InvoiceFeeController,
    Invoice\InvoiceOverrideController,
    Invoice\DownloadHistoryController as InvoiceDownloadHistoryController,
    Invoice\DownloadSettingController as InvoiceDownloadSettingController,
    Invoice\NoticeSettingController as InvoiceNoticeSettingController,
    Invoice\VisibilitySettingController as InvoiceVisibilitySettingController,
    Invoice\RateController as InvoiceRateController,

    System\LogController as SystemLogController,
    System\MessageController as SystemMessageController,
    System\ScheduleController as SystemScheduleController,
    System\SettingController as SystemSettingController,

    Support\FaqController as SupportFaqController,
};

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::match(['GET', 'POST'], 'login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('test', [TestController::class, 'index'])->name('test');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::name('auth.')->prefix('auth')->group(function () {
        // assign user to roles
        Route::get('users/{user}/roles', [AuthUserRoleController::class, 'index'])->name('users.roles.index');
        Route::get('users/{user}/roles/attach', [AuthUserRoleController::class, 'attachForm'])->name('users.roles.attach.form');
        Route::post('users/{user}/roles/attach', [AuthUserRoleController::class, 'attachRoles'])->name('users.roles.attach');
        Route::post('users/{user}/roles/detach', [AuthUserRoleController::class, 'detachRoles'])->name('users.roles.detach');

        // attach permissions to user
        Route::get('users/{user}/permissions', [AuthUserPermissionController::class, 'index'])->name('users.permissions.index');
        Route::get('users/{user}/permissions/attach', [AuthUserPermissionController::class, 'attachForm'])->name('users.permissions.attach.form');
        Route::post('users/{user}/permissions/attach', [AuthUserPermissionController::class, 'attachPermissions'])->name('users.permissions.attach');
        Route::post('users/{user}/permissions/detach', [AuthUserPermissionController::class, 'detachPermissions'])->name('users.permissions.detach');

        Route::resource('users', UserController::class);

        Route::name('roles.')->prefix('roles/{role}')->group(function () {
            // assign role to users
            Route::get('users', [AuthRoleUserController::class, 'index'])->name('users.index');
            Route::get('users/assign', [AuthRoleUserController::class, 'assignForm'])->name('users.assign.form');
            Route::post('users/assign', [AuthRoleUserController::class, 'assign'])->name('users.assign');
            Route::post('users/retract', [AuthRoleUserController::class, 'retract'])->name('users.retract');

            // attach permissions to role
            Route::get('permissions', [AuthRolePermissionController::class, 'index'])->name('permissions.index');
            Route::get('permissions/attach', [AuthRolePermissionController::class, 'attachForm'])->name('permissions.attach.form');
            Route::post('permissions/attach', [AuthRolePermissionController::class, 'attach'])->name('permissions.attach');
            Route::post('permissions/detach', [AuthRolePermissionController::class, 'detach'])->name('permissions.detach');
        });
        Route::resource('roles', AuthRoleController::class);

        Route::resource('permissions', AuthPermissionController::class);
    });

    Route::name('companies.')->prefix('companies')->group(function () {
        Route::get('', [CompanyController::class, 'index'])->name('index');
        Route::get('create', [CompanyController::class, 'create'])->name('create');
        Route::post('store', [CompanyController::class, 'store'])->name('store');
        Route::put('{company}/update', [CompanyController::class, 'update'])->name('update');
        Route::delete('{company}/destroy', [CompanyController::class, 'destroy'])->name('destroy');

        Route::prefix('{company}')->group(function () {
            Route::get('', [CompanyController::class, 'show'])->name('show');

            Route::name('users.')->prefix('users')->group(function () {
                Route::get('', [CompanyUserController::class, 'index'])->name('index');
                Route::get('create', [CompanyUserController::class, 'create'])->name('create');
                Route::get('{user}/edit', [CompanyUserController::class, 'edit'])->name('edit');
                Route::post('store', [CompanyUserController::class, 'store'])->name('store');
                Route::put('{user}/update', [CompanyUserController::class, 'update'])->name('update');
                Route::post('{user}/enabled', [CompanyUserController::class, 'enabled'])->name('enabled');
                Route::delete('{user}/destroy', [CompanyUserController::class, 'destroy'])->name('destroy');
            });

            Route::resource('groups', CompanyGroupController::class)->except('show');

            Route::name('contracts.')->prefix('contracts')->group(function () {
                Route::get('', [CompanyContractController::class, 'index'])->name('index');
            });

            Route::name('trusts.')->prefix('trusts')->group(function () {
                Route::get('', [CompanyTrustController::class, 'index'])->name('index');
            });

            Route::name('settings.')->prefix('settings')->group(function () {
                Route::get('', [CompanySettingController::class, 'index'])->name('index');
                Route::put('update', [CompanySettingController::class, 'update'])->name('update');
            });
        });
    });

    Route::name('invoices.')->prefix('invoices')->group(function () {
        Route::name('downloads.')->prefix('downloads')->group(function () {
            Route::get('', [InvoiceDownloadHistoryController::class, 'index'])->name('index');

            Route::name('settings.')->prefix('settings')->group(function () {
                Route::get('', [InvoiceDownloadSettingController::class, 'index'])->name('index');
                Route::post('', [InvoiceDownloadSettingController::class, 'update'])->name('update');
            });
        });
        Route::name('settings.')->prefix('settings')->group(function () {
            Route::name('notices.')->prefix('notices')->group(function () {
                Route::get('', [InvoiceNoticeSettingController::class, 'index'])->name('index');
                Route::post('', [InvoiceNoticeSettingController::class, 'update'])->name('update');
            });

            Route::name('visibilities.')->prefix('visibilities')->group(function () {
                Route::get('', [InvoiceVisibilitySettingController::class, 'index'])->name('index');
            });
        });

        Route::resource('rates', InvoiceRateController::class)->except('show');

        Route::name('releases.')->group(function () {
            Route::get('', [InvoiceController::class, 'index'])->name('index');
            Route::get('{invoice}', [InvoiceController::class, 'show'])->name('show');

            Route::prefix('{invoice}')->group(function () {
                Route::name('fees.')->prefix('fees')->group(function () {
                    Route::get('', [InvoiceFeeController::class, 'index'])->name('index');
                });

                Route::name('overrides.')->prefix('overrides')->group(function () {
                    Route::get('', [InvoiceOverrideController::class, 'index'])->name('index');
                });
            });
        });
    });

    Route::name('systems.')->prefix('systems')->group(function () {
        Route::name('logs.')->prefix('logs')->group(function () {
            Route::get('', [SystemLogController::class, 'index'])->name('index');
        });

        Route::name('messages.')->prefix('messages')->group(function () {
            Route::get('', [SystemMessageController::class, 'index'])->name('index');
        });

        Route::name('schedules.')->prefix('schedules')->group(function () {
            Route::get('', [SystemScheduleController::class, 'index'])->name('index');
        });

        Route::name('settings.')->prefix('settings')->group(function () {
            Route::get('', [SystemSettingController::class, 'index'])->name('index');
        });
    });

    Route::name('aws.')->prefix('aws')->group(function () {
        Route::resource('accounts', AwsAccountController::class)->except(['show']);
    });

    Route::name('supports.')->prefix('supports')->group(function () {
        Route::name('faqs.')->prefix('faqs')->group(function () {
            Route::get('', [SupportFaqController::class, 'index'])->name('index');
        });
    });

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
