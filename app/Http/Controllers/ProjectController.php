<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
  // Mostrar todos los proyectos
  public function index()
  {
    $proyectos = Project::with(['user', 'participants'])
      ->latest()
      ->paginate(10);

    return view('proyectos.index', compact('proyectos'));
  }

  // Mostrar formulario de creación
  public function create()
  {
    return view('proyectos.create');
  }

  // Guardar un proyecto nuevo
  public function store(Request $request)
  {
    $datos = $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'required|string',
      'due_date' => 'nullable|date',
      'status' => 'required|in:pending,in_progress,completed',
    ]);

    // El usuario autenticado será el creador
    $request->user()->projects()->create($datos);

    return redirect()->route('proyectos.index')
      ->with('success', 'Proyecto creado correctamente.');
  }

  // Mostrar un proyecto concreto
  public function show(Project $proyecto)
  {
    $proyecto->load(['user', 'participants']);

    $usuariosDisponibles = User::whereNotIn(
      'id',
      $proyecto->participants->pluck('id')
    )
      ->where('id', '!=', $proyecto->user_id)
      ->get();

    return view('proyectos.show', compact(
      'proyecto',
      'usuariosDisponibles'
    ));
  }

  public function addParticipant(Request $request, Project $proyecto)
  {

    // Comprobar que el usuario autenticado es el creador
    abort_unless($proyecto->user_id === $request->user()->id, 403);

    $datos = $request->validate([
      'user_id' => 'required|exists:users,id',
    ]);

    $proyecto->participants()->attach($datos['user_id'], [
      'role' => 'developer',
      'contribution_hours' => 0,
    ]);

    return back()->with('success', 'Participante añadido correctamente.');
  }

  public function myProjects()
  {
    $usuario = auth()->user();

    $proyectos = Project::with(['user', 'participants'])
      ->where('user_id', $usuario->id)
      ->orWhereHas('participants', function ($query) use ($usuario) {
        $query->where('users.id', $usuario->id);
      })
      ->latest()
      ->paginate(10);

    return view('proyectos.index', [
      'proyectos' => $proyectos,
      'titulo' => 'Mis proyectos'
    ]);
  }

  // Mostrar formulario de edición
  public function edit(Request $request, Project $proyecto)
  {
    // Solo el creador puede editar el proyecto
    abort_unless($proyecto->user_id === $request->user()->id, 403);

    return view('proyectos.edit', compact('proyecto'));
  }

  // Actualizar un proyecto
  public function update(Request $request, Project $proyecto)
  {
    // Solo el creador puede actualizarlo
    abort_unless($proyecto->user_id === $request->user()->id, 403);

    $datos = $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'required|string',
      'due_date' => 'nullable|date',
      'status' => 'required|in:pending,in_progress,completed',
    ]);

    $proyecto->update($datos);

    return redirect()->route('proyectos.index')
      ->with('success', 'Proyecto actualizado correctamente.');
  }

  // Eliminar un proyecto
  public function destroy(Request $request, Project $proyecto)
  {
    // Solo el creador puede eliminarlo
    abort_unless($proyecto->user_id === $request->user()->id, 403);

    $proyecto->delete();

    return redirect()->route('proyectos.index')
      ->with('success', 'Proyecto eliminado correctamente.');
  }
}
