<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarea;
use App\Models\Categoria;
use Dompdf\Dompdf;

class TareaController extends Controller
{
    public function index(Request $request)
{
    $query = Tarea::query();

    // Verificar si se ha seleccionado una categoría para filtrar
    if ($request->has('categoria_id')) {
        $query->where('cat_id', $request->categoria_id);
    }

    // Verificar si se ha seleccionado una fecha para filtrar
    if ($request->has('fecha')) {
        $fecha = $request->fecha;
        $query->whereDate('fecha', $fecha);
    }

    // Verificar si se ha seleccionado un estado para filtrar
    if ($request->has('estado')) {
        $estado = $request->estado;
        $query->where('estado', $estado);
    }

    $tareas = $query->paginate(10);

    // Obtener todas las categorías para el combobox de filtrado
    $categorias = Categoria::all();

    return view('tarea.index', compact('tareas', 'categorias'));
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
        'titulo' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'cat_id' => 'required|exists:categorias,id',
        'fecha' => 'required|date',
        'prioridad' => 'required|string', // Cambiado a string para aceptar 'alta', 'media', 'baja'
        'lugar' => 'nullable|string|max:255', // Campo lugar ahora es opcional
        'estado' => 'required|string|in:pendiente,en progreso,completada', // Asegurando que estado sea uno de los valores especificados
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Campo imagen ahora es opcional y con validación de tipo y tamaño
    ]);

    // Mapear la prioridad a un valor numérico antes de almacenarla en la base de datos
    switch ($request->prioridad) {
        case 'alta':
            $prioridad = 1;
            break;
        case 'media':
            $prioridad = 2;
            break;
        case 'baja':
            $prioridad = 3;
            break;
        default:
            $prioridad = null;
    }

   

    $tarea = new Tarea();

    $tarea->titulo = $request->input('titulo');
    $tarea->descripcion = $request->input('descripcion');
    $tarea->cat_id = $request->input('cat_id');
    $tarea->fecha = $request->input('fecha');
    $tarea->prioridad = $prioridad; // Almacenar la prioridad mapeada
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

       

    public function pdf()
    {
        // Obtener los datos necesarios para el PDF (en este caso, las tareas)
        $tareas = Tarea::all();

        // Crear una instancia de Dompdf
        $dompdf = new Dompdf();

        // Renderizar la vista en HTML
        $html = view('pdf', compact('tareas'))->render();

        // Cargar el HTML en Dompdf
        $dompdf->loadHtml($html);

        // Opcional: ajustar las opciones de Dompdf (por ejemplo, tamaño de papel y orientación)
        $dompdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $dompdf->render();

        // Descargar el PDF en lugar de mostrarlo en el navegador
        return $dompdf->stream('listado_de_tareas.pdf');
    }


}
