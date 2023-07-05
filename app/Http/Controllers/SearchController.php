<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchQueryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function find(SearchQueryRequest $request)
    {
        $query = $request->validated('query');

        // Search all folders the user has access to
        /** @var \App\User */
        $user = Auth::user();
        $folders = $user->folders()->where('name', 'like', '%' . $query . '%')->limit(5)->get();

        // Search all passwords the user has access to
        $entries = $user->passwordEntries()
            ->where('title', 'like', '%' . $query . '%')
            ->orWhere('username', 'like', '%' . $query . '%')
            ->orWhere('url', 'like', '%' . $query . '%')
            ->orWhere('notes', 'like', '%' . $query . '%')
            ->limit(5)
            ->get();

        return [
            'folders' => $folders,
            'entries' => $entries,
        ];
    }
}
