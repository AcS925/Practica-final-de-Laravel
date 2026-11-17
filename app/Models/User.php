<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
  /** @use HasFactory<UserFactory> */
  use HasFactory, Notifiable;

  // Relación 1:N: proyectos creados por el usuario
  public function projects(): HasMany
  {
    return $this->hasMany(Project::class);
  }

  // Relación N:N: proyectos en los que participa
  public function participatingProjects(): BelongsToMany
  {
    return $this->belongsToMany(Project::class)
      ->withPivot('role', 'contribution_hours');
  }

  /**
   * Get the attributes that should be cast.
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }
}
