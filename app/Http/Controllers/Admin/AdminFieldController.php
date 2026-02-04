<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFieldRequest;
use App\Http\Requests\UpdateFieldRequest;
use App\Models\Field;
use Illuminate\Support\Facades\Storage;

class AdminFieldController extends Controller
{
    /**
     * Display a listing of the fields
     */
    public function index()
    {
        $fields = Field::latest()->paginate(10);
        
        return view('admin.lapangan.index', compact('fields'));
    }

    /**
     * Show the form for creating a new field
     */
    public function create()
    {
        return view('admin.lapangan.create');
    }

    /**
     * Store a newly created field in database
     */
    public function store(StoreFieldRequest $request)
    {
        $validated = $request->validated();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('fields'), $filename);
            $validated['photo'] = $filename;
        }

        Field::create($validated);

        return redirect()
            ->route('admin.lapangan')
            ->with('success', 'Lapangan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified field
     */
    public function edit($id)
    {
        $field = Field::findOrFail($id);
        
        return view('admin.lapangan.edit', compact('field'));
    }

    /**
     * Update the specified field in database
     */
    public function update(UpdateFieldRequest $request, $id)
    {
        $field = Field::findOrFail($id);
        $validated = $request->validated();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($field->photo && file_exists(public_path('fields/' . $field->photo))) {
                unlink(public_path('fields/' . $field->photo));
            }

            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('fields'), $filename);
            $validated['photo'] = $filename;
        }

        $field->update($validated);

        return redirect()
            ->route('admin.lapangan')
            ->with('success', 'Lapangan berhasil diupdate!');
    }

    /**
     * Remove the specified field from database
     */
    public function destroy($id)
    {
        $field = Field::findOrFail($id);

        // Delete photo if exists
        if ($field->photo && file_exists(public_path('fields/' . $field->photo))) {
            unlink(public_path('fields/' . $field->photo));
        }

        $field->delete();

        return redirect()
            ->route('admin.lapangan')
            ->with('success', 'Lapangan berhasil dihapus!');
    }
}
