<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantBatch extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'raffle_week_code',
    ];

    // If you want automatic timestamps (usually yes)
    public $timestamps = true;

    // Define relationship: One batch has many participants
    public function participants()
    {
        return $this->hasMany(Participant::class);
    }
}
