<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    protected $fillable = ['year', 'semester', 'credits_required'];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }
}
