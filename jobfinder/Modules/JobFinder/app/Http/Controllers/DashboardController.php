<?php

namespace Modules\JobFinder\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends BaseController
{
    /**
     * Tampilkan dashboard sesuai role user
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('jobfinder::dashboard.admin');
        }

        return view('jobfinder::dashboard.pelamar');
    }
}
