<?php

namespace App\Models;

use App\Models\Poll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'poll_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'poll_id'
    ];
    
    /**
     * get the poll for this option
     */
    public function poll() {
        return $this->belongsTo(Poll::class);
    }

    /**
     * Get the votes for this option
     */
    public function votes() {
        return $this->hasMany(Vote::class);
    }
}
