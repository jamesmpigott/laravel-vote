<?php

namespace App\Models;

use App\Models\Option;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
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
}
