<?php

namespace App\Models;

use App\Enums\NotificationChannel;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationTemplate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'channel',
        'content',
        'subject',
        'client_id',
        'identifier',
        'available_placeholders'
    ];

    protected $casts = [
        'channel' => NotificationChannel::class,
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
