<?php
namespace App\Http\Controllers;

use App\Models\BurialRecord;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BurialRecordController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Dashboard', [
            'records' => BurialRecord::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'plot_id' => 'required|string|max:50|unique:burial_records,plot_id',
            'dates' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        BurialRecord::create($validated);

        return redirect()->back()->with('success', 'Burial record added successfully.');
    }

    public function destroy($id)
    {
        $record = BurialRecord::findOrFail($id);
        $record->delete();

        return redirect()->back()->with('success', 'Burial record deleted successfully.');
    }
}