<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\User;

/**
 * Class EntradaController
 * @package App\Http\Controllers
 */
class EntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    $entradas = Entrada::paginate(10); 

    return view('entries', compact('entradas'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $entrada = new Entrada();
        $categorias = Categoria::all();
        return view('entrada.create', compact('entrada', 'categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

            
        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'required',
            'categoria_id' => 'required',
        ], [
            'titulo.required' => 'El campo título es obligatorio.',
            'descripcion.required' => 'El campo contenido es obligatorio.',
            'categoria_id.required' => 'Debes seleccionar una categoría.',
        ]);

        $entrada = new Entrada();
        
        $entrada->titulo = $request->input('titulo');
        $entrada->descripcion = $request->input('descripcion');
        $entrada->categoria_id = $request->input('categoria_id');
        $entrada->usuario_id = $request->input('usuario_id');
        $entrada->fecha = "2024-02-02";

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombre_original = $imagen->getClientOriginalName();
            $extension = $imagen->getClientOriginalExtension();
            $nombre_imagen = time() . '_' . pathinfo($nombre_original, PATHINFO_FILENAME) . '.' . $extension;
            $imagen->move(public_path('assets'), $nombre_imagen);
            $entrada->imagen = $nombre_imagen;
        }        
        
        $entrada->save();

        return redirect()->route('entradas.index')->with('success', 'Entrada creada correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entrada = Entrada::find($id);

        return view('entrada.show', compact('entrada'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entrada = Entrada::find($id);

        return view('entrada.edit', compact('entrada'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Entrada $entrada
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entrada $entrada)
    {
        request()->validate(Entrada::$rules);
        $entrada->titulo = $request->input('titulo');
        $entrada->descripcion = $request->input('descripcion');
        $entrada->categoria_id = $request->input('categoria_id');
        $entrada->usuario_id = $request->input('usuario_id');
        $entrada->fecha = "2024-02-02";

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombre_original = $imagen->getClientOriginalName();
            $extension = $imagen->getClientOriginalExtension();
            $nombre_imagen = time() . '_' . pathinfo($nombre_original, PATHINFO_FILENAME) . '.' . $extension;
            $imagen->move(public_path('assets'), $nombre_imagen);
            $entrada->imagen = $nombre_imagen;
        }        
        
        $entrada->save();

        $entrada->update($request->all());

        return redirect()->route('entradas.index')
            ->with('success', 'Entrada updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $entrada = Entrada::find($id)->delete();

        return redirect()->route('entradas.index')
            ->with('success', 'Entrada deleted successfully');
    }
}
