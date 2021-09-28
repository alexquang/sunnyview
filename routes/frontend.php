<?php

use App\Http\Controllers\Frontend\{
    Auth\AuthController,

    Aws\AccountController as AwsAccountController,
    Aws\RegionController as AwsRegionController,
    Aws\AmiController as AwsAmiController,
    Aws\ElasticIPController as AwsElasticIPControler,
    Aws\CloudWatchRuleController as AwsCloudWatchRuleController,
    Aws\LifeCycleController as AwsLifecycleController,
    Aws\ElasticLoadBalancerController as AwsElasticLoadBalancerController,
    Aws\TrustedAdvisorSettingController as AwsTrustedAdvisorSettingController,
    Aws\TrustedAdvisorReportController as AwsTrustedAdvisorReportController,

    Ec2\InstanceController as Ec2InstanceController,
    Ec2\InstanceTypeController as Ec2InstanceTypeController,
    Ec2\InstanceRequestController as Ec2InstanceRequestController,

    Rds\InstanceController as RdsInstanceController,
    Rds\InstanceRequestController as RdsInstanceRequestController,

    DashboardController,
    NotificationController,
    InvoiceController,
    SettingController,
    LogController,
    AppController,
    GroupController,
    UserController,
    ProjectController,
    HelpController,
    ContactController,
    FaqController,
    ProfileController,
};

use Illuminate\Support\Facades\Route;

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

Route::match(['GET', 'POST'], 'login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('', function () {
        return redirect()->route('frontend.dashboard');
    });

    Route::name('aws.')->prefix('aws')->group(function () {
        Route::get('elbs', [AwsElasticLoadBalancerController::class, 'index'])->name('elbs.index');

        Route::get('trusted-advisors/settings', [AwsTrustedAdvisorSettingController::class, 'index'])->name('trusted-advisors.settings.index');
        Route::get('trusted-advisors/reports', [AwsTrustedAdvisorReportController::class, 'index'])->name('trusted-advisors.reports.index');

        Route::get('regions', [AwsRegionController::class, 'index'])->name('regions.index');

        Route::get('amis', [AwsAmiController::class, 'index'])->name('amis.index');

        Route::get('eips', [AwsElasticIPControler::class, 'index'])->name('eips.index');

        Route::get('cloudwatches/rules', [AwsCloudWatchRuleController::class, 'index'])->name('cloudwatches.rules.index');

        Route::get('lifecycles', [AwsLifecycleController::class, 'index'])->name('lifecycles.index');

        Route::get('accounts', [AwsAccountController::class, 'index'])->name('accounts.index');
    });

    Route::name('ec2.instances.')->prefix('ec2/instances')->group(function () {
        Route::name('registered.')->group(function () {
            Route::get('', [Ec2InstanceController::class, 'index'])->name('index');
        });
        Route::name('requests.')->prefix('requests')->group(function () {
            Route::get('', [Ec2InstanceRequestController::class, 'index'])->name('index');
        });
        Route::name('types.')->prefix('types')->group(function () {
            Route::get('', [Ec2InstanceTypeController::class, 'index'])->name('index');
        });
    });

    Route::name('rds.instances.')->prefix('rds/instances')->group(function () {
        Route::name('registered.')->group(function () {
            Route::get('', [RdsInstanceController::class, 'index'])->name('index');
        });
        Route::name('requests.')->prefix('requests')->group(function () {
            Route::get('', [RdsInstanceRequestController::class, 'index'])->name('index');
        });
    });

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('invoices/csv', [InvoiceController::class, 'index'])->name('invoices.csv');
    Route::get('invoices/pdf', [InvoiceController::class, 'index'])->name('invoices.pdf');
    Route::get('logs', [LogController::class, 'index'])->name('logs.index');
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');

    Route::get('apps', [AppController::class, 'index'])->name('apps');
    Route::get('groups', [GroupController::class, 'index'])->name('groups.index');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');

    Route::get('manual', [HelpController::class, 'handle'])->name('help.manual');
    Route::get('specs', [HelpController::class, 'handle'])->name('help.specs');
    Route::get('terms', [HelpController::class, 'handle'])->name('help.terms');
    Route::get('faqs', [FaqController::class, 'index'])->name('faqs.index');

    Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::match(['GET', 'POST'], 'login/confirm', [AuthController::class, 'confirm'])->name('login.confirm');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
