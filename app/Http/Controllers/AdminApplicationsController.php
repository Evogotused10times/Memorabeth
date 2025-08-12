<?php
namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminApplicationsController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Applications', [
            'applications' => Application::all(),
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,denied',
        ]);

        $application = Application::findOrFail($id);
        $application->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Application status updated successfully.');
    }
}