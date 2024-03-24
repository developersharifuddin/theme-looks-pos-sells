<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{



    public function dashboard()
    {
        // Determine the user's role and redirect accordingly
        if (auth()->user()->role === 'admin') {
            return view('admin.home'); // View for admin dashboard
        } elseif (auth()->user()->role === 'manager') {
            return view('admin.home'); // View for manager dashboard
        } elseif (auth()->user()->role === 'employee') {
            return view('admin.home'); // View for employee dashboard
        }
        return redirect('/'); // Redirect to home or login page if the role is not recognized
    }



    public function index()
    {
        return view('admin.home');
    }
}
