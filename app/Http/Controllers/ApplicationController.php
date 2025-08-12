<?php
namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use App\Mail\ApplicationSubmitted;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    public function index()
    {
        return Inertia::render('Public/Application');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'applicant_name' => 'required|string|max:255',
            'applicant_email' => 'nullable|email|max:255',
            'applicant_phone' => 'nullable|string|max:20',
            'deceased_name' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        if (empty($validated['applicant_email']) && empty($validated['applicant_phone'])) {
            return back()->withErrors(['contact' => 'At least one of email or phone is required for contact purposes.']);
        }

        $filePath = $request->file('file')->store('applications', 'public');

        $application = Application::create([
            'applicant_name' => $validated['applicant_name'],
            'applicant_email' => $validated['applicant_email'],
            'applicant_phone' => $validated['applicant_phone'],
            'deceased_name' => $validated['deceased_name'],
            'file_path' => $filePath,
            'status' => 'pending',
        ]);

        Mail::to('admin@bethanymemorialpark.com')->send(new ApplicationSubmitted($application));

        return redirect()->back()->with('success', 'Application submitted successfully. It is now pending review.');
    }
}