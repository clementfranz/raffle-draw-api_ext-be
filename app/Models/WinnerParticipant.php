<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinnerParticipant extends Model
{
    use HasFactory;

    protected $table = 'winner_participants';

    protected $fillable = [
        'participant_id',
        'old_participant_id',
        'full_name_raw',
        'full_name_cleaned',
        'id_entry',
        'raffle_code',
        'regional_location',
        'registered_at',
        'uploaded_at',
        'is_drawn',
        'drawn_at',
        'participant_batch_id',
        'has_won',
        'won_at',
        'winner_type',
        'is_cancelled',
        'cancelled_at',
        'is_proclaimed',
        'proclaimed_at',
    ];

    protected $casts = [
        'is_drawn' => 'boolean',
        'has_won' => 'boolean',
        'is_cancelled' => 'boolean',
        'is_proclaimed' => 'boolean',
        'registered_at' => 'datetime',
        'uploaded_at' => 'datetime',
        'drawn_at' => 'datetime',
        'won_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'proclaimed_at' => 'datetime',
    ];

    // Relationships
    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function participantBatch()
    {
        return $this->belongsTo(ParticipantBatch::class);
    }
}
