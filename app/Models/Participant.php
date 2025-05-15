<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    // Define the table name if it is not the plural of the model name
    protected $table = 'participants';

    // Define the fillable columns for mass assignment
    protected $fillable = [
        'full_name',
        'id_entry',
        'raffle_code',
        'regional_location',
        'registered_at',
        'uploaded_at',
        'is_drawn',
        'drawn_at',
        // 'participant_batch_id',
    ];

    // Define relationships, e.g., a participant belongs to a participant batch
    public function participantBatch()
    {
        return $this->belongsTo(ParticipantBatch::class);
    }


}
