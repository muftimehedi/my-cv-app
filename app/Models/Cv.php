<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'full_name', 'email', 'phone', 'address', 'summary',
        'profile_picture', 'linkedin_url', 'github_url',
        'education', 'experience', 'skills', 'projects', 'awards',
    ];

    protected $casts = [
        'education' => 'array',
        'experience' => 'array',
        'skills' => 'array',
        'projects' => 'array',
        'awards' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
