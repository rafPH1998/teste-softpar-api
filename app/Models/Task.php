<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

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

    public function user(): BelongsTo
    { 
        return $this->belongsTo(User::class)->select('id', 'name', 'email');
    }

    public function getTasks(array $filters = [])
    {
        $tasks = Task::with('user');

        $tasks->when(isset($filters['status']), function ($query) use ($filters) {
            $query->where('status', $filters['status']);
        });
        
        $tasks->when(isset($filters['date_start']), function ($query) use ($filters) {
            $query->whereDate('created_at', '>=', $filters['date_start']);
        });

        $tasks->when(isset($filters['date_end']), function ($query) use ($filters) {
            $query->whereDate('created_at', '<=', $filters['date_end']);
        });

        $tasks->when(isset($filters['order_by']), function ($query) use ($filters) {
            $orderField = $filters['order_by'] === 'title' ? 'title' : 'created_at'; 
            $orderDirection = $filters['order'] ?? 'asc'; 
            $query->orderBy($orderField, $orderDirection);
        });

        return $tasks->get();
    }

}
