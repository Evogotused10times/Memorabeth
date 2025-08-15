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
            'address' => 'required|string|max:255',
            'cellphone_no' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'facebook_messenger' => 'nullable|string|max:255',
            'next_of_kin' => 'required|string|max:255',
            'lots' => 'required|array|min:1',
            'lots.*.niche_lot' => 'required|string|max:50',
            'lots.*.block_level' => 'required|string|max:50',
            'lots.*.desc' => 'required|string|max:255',
            'lots.*.price' => 'required|numeric|min:0',
            'terms' => 'required|string',
            'remarks' => 'required|string',
            'purchaser_name' => 'required|string|max:255',
            'agent_name' => 'required|string|max:255',
            'date' => 'required|date',
            'signature_agreement' => 'required|boolean',
            'file' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        if (empty($validated['email']) && empty($validated['cellphone_no'])) {
            return back()->withErrors(['contact' => 'At least one of email or cellphone number is required for contact purposes.']);
        }

        $filePath = $request->file('file')->store('applications', 'public');

        $application = Application::create([
            'applicant_name' => $validated['applicant_name'],
            'address' => $validated['address'],
            'cellphone_no' => $validated['cellphone_no'],
            'email' => $validated['email'],
            'facebook_messenger' => $validated['facebook_messenger'],
            'next_of_kin' => $validated['next_of_kin'],
            'lots' => json_encode($validated['lots']),
            'terms' => $validated['terms'],
            'remarks' => $validated['remarks'],
            'purchaser_name' => $validated['purchaser_name'],
            'agent_name' => $validated['agent_name'],
            'date' => $validated['date'],
            'signature_agreement' => $validated['signature_agreement'],
            'file_path' => $filePath,
            'status' => 'pending',
        ]);

        Mail::to('mdc.ejcentillas@gmail.com')->send(new ApplicationSubmitted($application));

        return redirect()->back()->with('success', 'Application submitted successfully. It is now pending review.');
    }
}