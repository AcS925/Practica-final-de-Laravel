<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
  public function run(): void
  {
    $users = User::all();

    foreach ($users as $user) {
      Project::factory()
        ->count(fake()->numberBetween(1, 3))
        ->for($user)
        ->create();
    }
  }
}
