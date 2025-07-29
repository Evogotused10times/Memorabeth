<?php
namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'applicant_name' => 'required|string|max:255',
            'applicant_email' => 'required|email|max:255',
            'applicant_phone' => 'nullable|string|max:20',
            'deceased_name' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $filePath = $request->file('file')->store('applications', 'public');

        Application::create([
            'applicant_name' => $validated['applicant_name'],
            'applicant_email' => $validated['applicant_email'],
            'applicant_phone' => $validated['applicant_phone'],
            'deceased_name' => $validated['deceased_name'],
            'file_path' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Application submitted successfully.');
    }
}