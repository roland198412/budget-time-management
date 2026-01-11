<?php

namespace App\Models;

use App\Enums\{NotificationChannel, NotificationTemplateType};
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
        'available_placeholders',
        'template_type'
    ];

    protected $casts = [
        'channel' => NotificationChannel::class,
        'template_type' => NotificationTemplateType::class,
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
