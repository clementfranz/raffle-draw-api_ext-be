<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CloudSync extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * You can adjust this list based on what fields are safe for mass assignment.
     */
    protected $fillable = [
        'api_url',
        'source',
        'destination',
        'type',
        'payload',
        'method_type',
        'status',
        'retry_count',
        'error_message',
        'priority',
        'reference_id',
        'content_type',
        'triggered_by',
        'is_test',
        'next_retry_at',
        'headers',
        'response_body',
        'duration',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'payload' => 'array',
        'headers' => 'array',
        'response_body' => 'array',
        'is_test' => 'boolean',
        'next_retry_at' => 'datetime',
        'retry_count' => 'integer',
        'duration' => 'integer',
    ];
}
