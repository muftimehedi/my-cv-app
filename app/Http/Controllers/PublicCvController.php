<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class PublicCvController extends Controller
{
    public function show(User $user)
    {
        $cv = $user->load('cv')->cv;

        if (!$cv) {
            abort(404, 'এই ব্যবহারকারীর জন্য সিভি পাওয়া যায়নি।');
        }

        return Inertia::render('Public/Cv', [
            'cv' => $cv,
            'user' => $user,
        ]);
    }
}
