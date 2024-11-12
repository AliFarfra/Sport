<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Middleware to check if user is admin
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->hasRole('admin')) {
                return redirect('/')->with('error', 'You do not have access to this page.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        // Admin logic here...
        return view('admin.dashboard');
    }

    // Example method for managing users
    public function manageUsers()
    {
        // Logic to manage users
        return view('admin.manage-users');
    }

    // Additional admin methods can be added here...
    public function managePacks()
    {
        // Logic to manage packs
        return view('admin.manage-packs');
    }

    public function manageCourses()
    {
        // Logic to manage courses
        return view('admin.manage-courses');
    }

    // Add more methods as needed...
}