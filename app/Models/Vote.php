<?php

namespace App\Models;

use App\Models\Poll;
use App\Models\Option;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [

    ];

    protected $casts = [
        'email' => 'encrypted'
    ];

    /**
     * Get the poll for this vote
     */
    public function poll() {
        return $this->belongsTo(Poll::class);
    }

    /**
     * Get the option for this vote
     */
    public function option() {
        return $this->belongsTo(Option::class);
    }

}
