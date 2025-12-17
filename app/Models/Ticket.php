<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'user_id',
        'agent_id',
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function agent(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany{
        return $this->belongsToMany(Category::class);
    }
}
