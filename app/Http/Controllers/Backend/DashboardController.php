<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        
        return view('Backend.dashboard', [
            'totalUsers' => User::count(),
        ]);
    }
}
