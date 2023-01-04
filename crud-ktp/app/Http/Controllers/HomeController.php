<?php

namespace App\Http\Controllers;

use App\Models\IdentifyCard;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard', [
            'title' => 'Dashboard',
            'actives' => 'dashboard',
            'sum_identify_cards' => IdentifyCard::count(),
            'sum_users' => User::count(),
        ]);
    }
}
