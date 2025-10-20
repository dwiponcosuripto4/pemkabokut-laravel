<?php

namespace App\Http\Controllers;

use App\Models\Icon;
use App\Models\Dropdown;
use Illuminate\Http\Request;

class IconController extends Controller
{
    public function index()
    {
        $icons = Icon::all();
        $icons = Icon::with('dropdowns')->get();
        return view('admin.icon.data', compact('icons'));
    }

    public function data()
    {
        $icons = Icon::all();
        return view('admin.icon.data', compact('icons'));
    }

    // Show the form for creating a new icon.
    public function create()
    {
        return view('admin.icon.create');
    }

    // app/Http/Controllers/IconController.php

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dropdowns' => 'nullable|array',
            'dropdowns.*.title' => 'nullable|string',
            'dropdowns.*.icon_dropdown' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'dropdowns.*.link' => 'nullable|string',
        ]);

        // Proses upload gambar
        $originalName = $request->file('image')->getClientOriginalName();
        $imagePath = $request->file('image')->storeAs('uploads/icons', $originalName, 'public');

        // Buat Icon
        $icon = Icon::create([
            'title' => $request->input('title'),
            'image' => $imagePath,
            'user_id' => auth()->id(),
        ]);

        // Simpan dropdowns yang terkait
        if ($request->has('dropdowns')) {
            foreach ($request->input('dropdowns') as $index => $dropdownData) {
                $iconDropdownPath = null;
                if ($request->hasFile("dropdowns.$index.icon_dropdown")) {
                    $originalName = $request->file("dropdowns.$index.icon_dropdown")->getClientOriginalName();
                    $iconDropdownPath = $request->file("dropdowns.$index.icon_dropdown")->storeAs('dropdown_icons', $originalName, 'public');
                }
                Dropdown::create([
                    'title' => $dropdownData['title'] ?? null,
                    'icon_dropdown' => $iconDropdownPath,
                    'link' => $dropdownData['link'] ?? null,
                    'icon_id' => $icon->id,
                    'user_id' => auth()->id(),
                ]);
            }
        }

        return redirect()->route('icon.index')->with('success', 'Icon and Dropdowns created successfully.');
    }

    // Display the specified icon.
    public function show(Icon $icon)
    {
        return view('admin.icon.show', compact('icon'));
    }

    // Show the form for editing the specified icon.
    public function edit($id)
    {
        // Ambil Icon berdasarkan ID beserta Dropdowns yang terkait
        $icon = Icon::with('dropdowns')->findOrFail($id);

        return view('admin.icon.edit', compact('icon'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dropdowns' => 'nullable|array',
            'dropdowns.*.title' => 'nullable|string',
            'dropdowns.*.icon_dropdown' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'dropdowns.*.link' => 'nullable|string',
        ]);

        // Temukan Icon berdasarkan ID
        $icon = Icon::findOrFail($id);

        // Update gambar jika ada file baru
        if ($request->hasFile('image')) {
            $originalName = $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('uploads/icons', $originalName, 'public');
            $icon->image = $imagePath;
        }

        // Update title
        $icon->title = $request->input('title');
        $icon->save();

        // Update dropdowns
        $inputDropdowns = $request->input('dropdowns', []);
        $existingDropdownIds = $icon->dropdowns()->pluck('id')->toArray();
        $inputIds = [];

        foreach ($inputDropdowns as $key => $dropdownData) {
            // Jika key adalah id dropdown lama
            if (is_numeric($key)) {
                $inputIds[] = (int)$key;
                $dropdown = Dropdown::find($key);
                if ($dropdown) {
                    // Update data lama
                    $dropdown->title = $dropdownData['title'] ?? $dropdown->title;
                    $dropdown->link = $dropdownData['link'] ?? $dropdown->link;
                    // Update icon_dropdown jika ada file baru
                    if ($request->hasFile("dropdowns.$key.icon_dropdown")) {
                        $originalName = $request->file("dropdowns.$key.icon_dropdown")->getClientOriginalName();
                        $iconDropdownPath = $request->file("dropdowns.$key.icon_dropdown")->storeAs('dropdown_icons', $originalName, 'public');
                        $dropdown->icon_dropdown = $iconDropdownPath;
                    }
                    $dropdown->save();
                }
            } else if (str_starts_with($key, 'new_')) {
                // Dropdown baru
                $iconDropdownPath = null;
                if ($request->hasFile("dropdowns.$key.icon_dropdown")) {
                    $originalName = $request->file("dropdowns.$key.icon_dropdown")->getClientOriginalName();
                    $iconDropdownPath = $request->file("dropdowns.$key.icon_dropdown")->storeAs('dropdown_icons', $originalName, 'public');
                }
                Dropdown::create([
                    'title' => $dropdownData['title'] ?? null,
                    'icon_dropdown' => $iconDropdownPath,
                    'link' => $dropdownData['link'] ?? null,
                    'icon_id' => $icon->id,
                ]);
            }
        }

        // Hapus dropdown yang dihapus oleh user
        $dropdownsToDelete = array_diff($existingDropdownIds, $inputIds);
        if (!empty($dropdownsToDelete)) {
            Dropdown::whereIn('id', $dropdownsToDelete)->delete();
        }

        return redirect()->route('icon.index')->with('success', 'Icon and Dropdowns updated successfully.');
    }

    // Remove the specified icon from storage.
    public function destroy($id)
    {
        // Cari headline berdasarkan ID
        $icon = Icon::find($id);

        if (!$icon) {
            return redirect()->route('icon.index')->with('error', 'Icon not found.');
        }

        // Hapus headline
        $icon->delete();

        return redirect()->route('icon.index')->with('success', 'Icon deleted successfully.');
    }
}
