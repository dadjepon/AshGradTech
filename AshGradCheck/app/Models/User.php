<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'major',
        'StudentId',
        'password',
        'username',
        'yearGroup',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        
    ];

    // Defining an eloquent between user and posts
    // A user has many posts.
    public function posts(){
        return $this->hasMany(Post::class);
    }
    public function files(){
        return $this->hasMany(File::class);
    }

    public function hasRole($role)
    {
        // Check if the user's roles contain the specified role
        return in_array($role, explode(',', $this->role));
    }
}
