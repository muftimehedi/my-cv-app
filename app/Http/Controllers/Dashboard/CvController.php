<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Cv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CvController extends Controller
{
    public function edit(Request $request)
    {
        $cv = $request->user()->cv; // বর্তমান লগইন করা ইউজারের সিভি আনুন
        if (!$cv) {
            $cv = new Cv(); // যদি সিভি না থাকে, একটি নতুন খালি অবজেক্ট পাঠান
        }

        return Inertia::render('Dashboard/Cv', [
            'cv' => $cv,
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:cvs,email,' . ($user->cv->id ?? 'NULL'),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'profile_picture' => 'nullable|image|max:2048', // 2MB সর্বোচ্চ
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'education' => 'nullable|array',
            'education.*.degree' => 'nullable|string|max:255',
            'education.*.institution' => 'nullable|string|max:255',
            'education.*.year' => 'nullable|string|max:20',
            'experience' => 'nullable|array',
            // অভিজ্ঞতা, দক্ষতা, প্রকল্প, পুরস্কারের জন্য অনুরূপ ভ্যালিডেশন যোগ করুন
        ]);

        $cv = $user->cv()->firstOrCreate([]); // ইউজারের জন্য সিভি খুঁজুন অথবা তৈরি করুন

        if ($request->hasFile('profile_picture')) {
            if ($cv->profile_picture) {
                Storage::disk('public')->delete($cv->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $validatedData['profile_picture'] = $path;
        }

        $cv->update($validatedData);

        return redirect()->back()->with('success', 'CV updated successfully!');
    }
}
