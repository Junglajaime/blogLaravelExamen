<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use App\Models\Entrada;
use App\Models\User;

class PDFController extends Controller
{
    public function generarPDF(Request $request)
    {
        $userId = $request->session()->get('user_id');

        $usuario = User::find($userId);

        if ($usuario && $usuario->rol === 'admin') {
            $entradas = Entrada::all();
        } elseif ($usuario) {
            $entradas = Entrada::where('usuario_id', $userId)->get();
        } else {
            abort(404, 'Usuario no encontrado');
        }
        
        $html = view('entradas.pdf', compact('entradas'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('entradas.pdf');
    }
}
