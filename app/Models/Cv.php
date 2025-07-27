<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo

class Cv extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'phone',
        'address',
        'summary',
        'profile_picture', // Assuming you have this column
        'linkedin_url',
        'github_url',
        'education',
        'experience',
        'skills',
        'projects',
        'awards',
    ];

    /**
     * The attributes that should be cast to native types.
     * These are crucial for handling JSON columns.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'education' => 'array',
        'experience' => 'array',
        'skills' => 'array',
        'projects' => 'array',
        'awards' => 'array',
    ];

    // Define the relationship to the User model
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); // A Cv belongs to one User
    }
}
