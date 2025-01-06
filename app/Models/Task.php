<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title', 'description', 'status', 'completed_at', 'user_id', 'completed'
    ];

    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime:d/m/Y H:i',
            'created_at'   => 'datetime:d/m/Y',
            'updated_at'   => 'datetime:d/m/Y',
            'completed'    => 'boolean',
        ]; 
    }
}
