<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->approved == "Pending" || Auth::user()->approved == "Disapproved") {
            Auth::logout();
            return view('admin.agency.approval');
        } else {
            // return redirect('/home');

            switch (Auth::user()->role) {
                case 1:
                    return view('admin.dashboard');
                    break;
                case 2:
                    return view('inspector.dashboard');
                    break;
                default:
                    return view('company.dashboard');
                    break;
            }
        }
    }
}
