<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function index()
    {
        return  redirect('admin/dashboard');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function clearCache()
    {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('config:cache');
        return "Cache is cleared";
    }
}
