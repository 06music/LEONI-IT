<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SiteController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Sites/Index', [
            'sites' => Site::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:sites,name|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        Site::create($request->all());

        return redirect()->route('sites.index')->with('success', 'Site added successfully!');
    }

    public function update(Request $request, Site $site)
    {
        $request->validate([
            'name' => 'required|unique:sites,name,' . $site->id . '|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $site->update($request->all());

        return redirect()->route('sites.index')->with('success', 'Site updated successfully!');
    }

    public function destroy(Site $site)
    {
        $site->delete();
        return redirect()->route('sites.index')->with('success', 'Site deleted successfully!');
    }
}
