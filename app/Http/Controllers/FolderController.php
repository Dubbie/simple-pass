<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFolderRequest;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FolderController extends Controller
{
    public function store(StoreFolderRequest $request)
    {
        $validatedData = $request->validated();
        $folder = Folder::create([
            'name' => $validatedData['name'],
            'user_id' => Auth::id(),
        ]);
        return redirect(route('folders.show', $folder))->with('banner', 'Folder created successfully');
    }

    public function show(Folder $folder)
    {
        return Inertia::render('Folder/Show', ['folder' => $folder]);
    }
}
