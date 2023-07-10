<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PagesController extends Controller
{
    public function index()
    {
        return Inertia::render('Index');
    }

    public function dashboard()
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        return Inertia::render('Dashboard')->with([
            'foldersCount' => $user->folders()->count(),
            'entriesCount' => $user->passwordEntries()->count(),
        ]);
    }
}
