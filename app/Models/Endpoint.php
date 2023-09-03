<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Endpoint extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'endpoint',
        'frequency',
        'next_check',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function checks(): HasMany
    {
        return $this->hasMany(Check::class);
    }

    public function check(): HasOne
    {
        return $this->hasOne(Check::class)->latest();
    }

    public function url(): string
    {
        return $this->site->url . $this->endpoint;
    }

    protected function endpoint(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => !str_starts_with($value, '/') ? '/' . $value : $value,
        );
    }

    protected function nextCheck(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => Carbon::make($value)->format('d/m/Y H\hi'),
        );
    }

    public function getStatusColor(int $weight = 400): string
    {
        $latestCheck = $this->check;
        if (!$latestCheck) {
            return 'white';
        } elseif ($latestCheck->isSuccess()) {
            return 'green-' . $weight;
        } else {
            return 'red-' . $weight;
        }
    }
}
