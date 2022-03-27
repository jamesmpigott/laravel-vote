<?php

namespace App\Models;

use App\Models\Option;
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
}
