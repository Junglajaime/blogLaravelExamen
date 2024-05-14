<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarea;
use App\Models\Categoria;

class TareaController extends Controller
{
    public function index()
    {
        $tareas = Tarea::paginate(10);

        return view('tarea.index', compact('tareas'));
    }

    public function create()
    {
        $tarea = new Tarea();
        $categorias = Categoria::all();
        return view('tarea.create', compact('tarea', 'categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'required',
            'cat_id' => 'required',
            'fecha' => 'required',
        ], [
            'titulo.required' => 'El campo título es obligatorio.',
            'descripcion.required' => 'El campo contenido es obligatorio.',
            'cat_id.required' => 'Debes seleccionar una categoría.',
            'fecha.required' => 'La fecha es obligatoria.',
        ]);

        $tarea = new Tarea();

        $tarea->titulo = $request->input('titulo');
        $tarea->descripcion = $request->input('descripcion');
        $tarea->cat_id = $request->input('cat_id');
        $tarea->fecha = $request->input('fecha');
        $tarea->prioridad = $request->input('prioridad');
        $tarea->lugar = $request->input('lugar');
        $tarea->estado = $request->input('estado');

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombre_original = $imagen->getClientOriginalName();
            $extension = $imagen->getClientOriginalExtension();
            $nombre_imagen = time() . '_' . pathinfo($nombre_original, PATHINFO_FILENAME) . '.' . $extension;
            $imagen->move(public_path('assets'), $nombre_imagen);
            $tarea->imagen = $nombre_imagen;
        }

        $tarea->save();

        return redirect()->route('tarea.index')->with('success', 'Tarea creada correctamente');
    }

    public function show($id)
    {
        $tarea = Tarea::findOrFail($id);
        return view('tarea.show', compact('tarea'));
    }

    public function edit($id)
    {
        $tarea = Tarea::findOrFail($id);
        $categorias = Categoria::all();
        return view('tarea.edit', compact('tarea', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'required',
            'cat_id' => 'required',
            'fecha' => 'required',
        ], [
            'titulo.required' => 'El campo título es obligatorio.',
            'descripcion.required' => 'El campo contenido es obligatorio.',
            'cat_id.required' => 'Debes seleccionar una categoría.',
            'fecha.required' => 'La fecha es obligatoria.',
        ]);

        $tarea = Tarea::findOrFail($id);

        $tarea->titulo = $request->input('titulo');
        $tarea->descripcion = $request->input('descripcion');
        $tarea->cat_id = $request->input('cat_id');
        $tarea->fecha = $request->input('fecha');
        $tarea->prioridad = $request->input('prioridad');
        $tarea->lugar = $request->input('lugar');
        $tarea->estado = $request->input('estado');

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombre_original = $imagen->getClientOriginalName();
            $extension = $imagen->getClientOriginalExtension();
            $nombre_imagen = time() . '_' . pathinfo($nombre_original, PATHINFO_FILENAME) . '.' . $extension;
            $imagen->move(public_path('assets'), $nombre_imagen);
            $tarea->imagen = $nombre_imagen;
        }

        $tarea->save();

        return redirect()->route('tarea.index')->with('success', 'Tarea actualizada correctamente');
    }

    public function destroy($id)
    {
        $tarea = Tarea::findOrFail($id);
        $tarea->delete();
        return redirect()->route('tarea.index')->with('success', 'Tarea eliminada correctamente');
    }
}
