<?php

namespace App\Models;

use App\Models\Vote;
use App\Models\Option;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug'
    ];

    /**
     * Get the options for this poll
     */
    public function options() {
        return $this->hasMany(Option::class);
    }

    /**
     * Get the votes for this poll
     */
    public function votes() {
        return $this->hasMany(Vote::class);
    }

    /**
     * Get route key for model - for route model binding
     * @return string
     */
    public function getRouteKeyName() {
        return 'slug';
    }
}
