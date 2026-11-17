<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable([
  'user_id',
  'title',
  'description',
  'due_date',
  'status'
])]
class Project extends Model
{
  use HasFactory;

  // Relación 1:N: usuario que ha creado el proyecto
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  // Relación N:N: usuarios que participan en el proyecto
  public function participants(): BelongsToMany
  {
    return $this->belongsToMany(User::class)
      ->withPivot('role', 'contribution_hours');
  }

  protected function casts(): array
  {
    return [
      'due_date' => 'date',
    ];
  }
}

