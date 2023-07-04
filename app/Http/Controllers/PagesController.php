<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PagesController extends Controller
{
    public function index()
    {
        return Inertia::render('Index');
    }

    public function dashboard()
    {
        return Inertia::render('Dashboard');
    }
}
