<?php

namespace App\Http\Controllers;

use App\Models\Valentine;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminValentineController extends Controller
{
    public function index()
    {
        $valentines = Valentine::latest()->get();
        return view('admin.index', compact('valentines'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'birth_date' => 'nullable|date',
            'message' => 'nullable|string',
            'ucapan' => 'nullable|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|max:2048',
            'audio' => 'nullable|file|max:10240',
        ]);

        $validated['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('valentines', 'public');
        }

        if ($request->hasFile('photos')) {
            $photos = [];
            foreach ($request->file('photos') as $photo) {
                $photos[] = $photo->store('valentines/photos', 'public');
            }
            $validated['photos'] = $photos;
        }

        if ($request->hasFile('audio')) {
            $validated['audio'] = $request->file('audio')->store('valentines/audio', 'public');
        }

        Valentine::create($validated);

        return redirect()->route('admin.index')->with('success', 'Valentine berhasil ditambahkan!');
    }

    public function edit(Valentine $valentine)
    {
        return view('admin.edit', compact('valentine'));
    }

    public function update(Request $request, Valentine $valentine)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'birth_date' => 'nullable|date',
            'message' => 'nullable|string',
            'ucapan' => 'nullable|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|max:2048',
            'audio' => 'nullable|file|max:10240',
        ]);

        $validated['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('valentines', 'public');
        }

        if ($request->hasFile('photos')) {
            $photos = [];
            foreach ($request->file('photos') as $photo) {
                $photos[] = $photo->store('valentines/photos', 'public');
            }
            $validated['photos'] = $photos;
        }

        if ($request->hasFile('audio')) {
            $validated['audio'] = $request->file('audio')->store('valentines/audio', 'public');
        }

        $valentine->update($validated);

        return redirect()->route('admin.index')->with('success', 'Valentine berhasil diupdate!');
    }

    public function destroy(Valentine $valentine)
    {
        $valentine->delete();
        return redirect()->route('admin.index')->with('success', 'Valentine berhasil dihapus!');
    }

    public function showPublic($slug)
    {
        $valentine = Valentine::where('slug', $slug)->firstOrFail();
        return view('valentine', compact('valentine'));
    }
}
