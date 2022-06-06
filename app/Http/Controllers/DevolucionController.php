<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Compras;
use App\Models\Clientes;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class DevolucionController extends Controller
{
    public function getDevolucion(Request $request)
    {
        

        if ($request->get('filtro') == null) { //Todas las busquedas
            $query= trim($request->get('search'));            
            $stock = Stock::join('compras', 'compras.id', '=', 'stock.compra_id')
            ->join('estados', 'estados.id', '=', 'stock.estado_id')
            ->select('stock.*','compras.serial as serial', 'compras.lote as lote', 'estados.estado as estados')
            ->where('compras.serial','LIKE', '%' . $query . '%')
            // ->get();
            ->paginate(10);

            return view('devolucion/list', [
                'stock' => $stock,
                'search' => $query
            ]);
        }  else
                if ($request->get('filtro') == 1) { //Más recientes
                    $stock = Stock::join('compras', 'compras.id', '=', 'stock.compra_id')
                    ->join('estados', 'estados.id', '=', 'stock.estado_id')
                    ->select('stock.*','compras.serial as serial', 'compras.lote as lote', 'estados.estado as estados')
                    ->orderby('stock.created_at', 'asc')                
                    // ->get();
                    ->paginate(10);


                    return view('devolucion/list', [
                        'stock' => $stock
                    ]);
        } else
                if ($request->get('filtro') == 2) { // Más antiguos
                    $stock = Stock::join('compras', 'compras.id', '=', 'stock.compra_id')
                    ->join('estados', 'estados.id', '=', 'stock.estado_id')
                    ->select('stock.*','compras.serial as serial', 'compras.lote as lote', 'estados.estado as estados')
                    ->orderby('stock.created_at', 'desc')                
                    // ->get();
                    ->paginate(10);

                    return view('devolucion/list', [
                        'stock' => $stock
                    ]);
        } 
        
    }
    public function fechaVista(Request $request){
        $start = Carbon::parse($request->get('fecha_inicial'));
        $end = Carbon::parse($request->get('fecha_final'));
        $stock = Stock::join('compras', 'compras.id', '=', 'stock.compra_id')
        ->join('estados', 'estados.id', '=', 'stock.estado_id')
        ->select('stock.*','compras.serial as serial', 'compras.lote as lote', 'estados.estado as estados')
        ->whereDate('stock.created_at','<=',$end)
        ->whereDate('stock.created_at','>=',$start)
        ->get();

        return view('devolucion/listfiltro', [
            'stock' => $stock
        ]);
    }
}
