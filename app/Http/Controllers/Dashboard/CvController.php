<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Cv; // Ensure Cv model is imported
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Ensure Storage facade is imported
use Inertia\Inertia; // Ensure Inertia facade is imported

class CvController extends Controller
{
    public function edit(Request $request)
    {
        $cv = $request->user()->cv;
        if (!$cv) {
            $cv = new Cv();
        }

        return Inertia::render('Dashboard/Cv', [
            'cv' => $cv,
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        // 1. Validate the incoming request data
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:cvs,email,' . ($user->cv->id ?? 'NULL'),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'profile_picture' => 'nullable|image|max:2048', // 2MB max
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'education' => 'nullable|array',
            'education.*.degree' => 'nullable|string|max:255',
            'education.*.institution' => 'nullable|string|max:255',
            'education.*.year' => 'nullable|string|max:20',
            'experience' => 'nullable|array',
            // Add similar validation for other JSON fields like skills, projects, awards
            'experience.*.title' => 'nullable|string|max:255',
            'experience.*.company' => 'nullable|string|max:255',
            'experience.*.duration' => 'nullable|string|max:255',
            'experience.*.description' => 'nullable|string',
            'skills' => 'nullable|array',
            'skills.*' => 'nullable|string|max:255',
            'projects' => 'nullable|array',
            'projects.*.name' => 'nullable|string|max:255',
            'projects.*.description' => 'nullable|string',
            'projects.*.url' => 'nullable|url|max:255',
            'awards' => 'nullable|array',
            'awards.*.name' => 'nullable|string|max:255',
            'awards.*.issuer' => 'nullable|string|max:255',
            'awards.*.year' => 'nullable|string|max:20',
        ]);

        // Handle profile picture upload FIRST, before creating/updating the record
        if ($request->hasFile('profile_picture')) {
            // If there's an existing picture, delete it
            if ($user->cv && $user->cv->profile_picture) {
                Storage::disk('public')->delete($user->cv->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $validatedData['profile_picture'] = $path;
        }

        // 2. Find or create the CV record for the user,
        //    passing all validated data directly to ensure NOT NULL fields are present on creation.
        $cv = $user->cv()->updateOrCreate(
            [], // Conditions: since it's a hasOne relation, it's tied to the user
            $validatedData // Values to create/update
        );

        // No need for $cv->update($validatedData); here, as updateOrCreate handles it.

        return redirect()->back()->with('success', 'CV updated successfully!');
    }
}
