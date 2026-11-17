<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectUserSeeder extends Seeder
{
  public function run(): void
  {
    $users = User::all();

    $projects = Project::all();

    foreach ($projects as $project) {
      $participants = $users
        ->where('id', '!=', $project->user_id)
        ->random(2);

      foreach ($participants as $participant) {
        $project->participants()->attach($participant->id, [
          'role' => fake()->randomElement([
            'developer',
            'designer',
            'manager'
          ]),
          'contribution_hours' => fake()->numberBetween(1, 40)
        ]);
      }
    }
  }
}
