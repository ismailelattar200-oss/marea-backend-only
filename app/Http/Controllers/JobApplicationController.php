<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'position' => 'required|string|max:255',
            'message' => 'nullable|string',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // 5MB max
        ]);

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'public');
        }

        $application = JobApplication::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'position' => $validated['position'],
            'message' => $validated['message'],
            'cv_path' => $cvPath,
        ]);

        return response()->json([
            'message' => 'Solicitud enviada correctamente',
            'application' => $application
        ], 201);
    }
}
