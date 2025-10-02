<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\{Arr};
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class ClientContact extends Model
{
    use SoftDeletes;
    use Notifiable;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'client_id',
        'sequence'
    ];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => Arr::join([$this->firstname, $this->lastname], ' '),
        );
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('orderBySequence', function ($query) {
            $query->orderBy('sequence');
        });
    }
}
