<?php

namespace App\Http\Controllers;

use App\producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = producto::paginate(5);
        return view('welcome', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/modal_nuevo_producto');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validasi = $this->verificacion($request);
            if ($validasi['status'] == 'success') {
                $referencia          = $request->referencia;
                $nombre_de_producto  = $request->nombre_de_producto;
                $observaciones       = $request->observaciones;
                $precio              = $request->precio;
                $impuesto            = $request->impuesto;
                $cantidad            = $request->cantidad;
                $estado              = $request->estado;

                $nombreFoto = $this->_salvar_imagenproducto($request, $nombre_de_producto);

                producto::insert(array(
                    'referencia'            => $referencia,
                    'nombre_de_producto'    => $nombre_de_producto,
                    'observaciones'         => $observaciones,
                    'precio'                => $precio,
                    'impuesto'              => $impuesto,
                    'cantidad'              => $cantidad,
                    'estado'                => $estado,
                    'imagen'                => Storage::url($nombreFoto)
                ));
                return response()->json(['Producto creado' => 'Success!'], 201);
            } else {
                return response()->json(['¡Ups! Lo siento, debe llenar todos los datos' => 'Error!'], 400);
            }
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(['¡Ups! Lo siento,error general' => 'Error!'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\producto  $producto
     * @return \Illuminate\Http\Response
     */
    private function show(Request $request, $id)
    {
        $producto = producto::find($id);
        $producto->referencia          = $request->referencia;
        $producto->nombre_de_producto  = $request->nombre_de_producto;
        $producto->observaciones       = $request->observaciones;
        $producto->precio              = $request->precio;
        $producto->impuesto            = $request->impuesto;
        $producto->cantidad            = $request->cantidad;
        $producto->estado              = $request->estado;

        $this->_eliminar_imagen_producto($producto->imagen);

        $nombreFoto = $this->_salvar_imagenproducto($request, $producto->nombre_de_producto);
        $producto->imagen              = Storage::url($nombreFoto);
        $producto->save();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $producto = producto::find($request->id);
        return view('/modal_editar_producto', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $validasi = $this->verificacionActualizar($request);
            if ($validasi['status'] == 'success') {
                $this->show($request, $request->id);
                return response()->json(['Producto actualiado' => 'Success!'], 201);
            } else {
                return response()->json(['¡Ups! Lo siento, debe llenar todos los datos' => 'Error!'], 400);
            }
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(['¡Ups! Lo siento,error general' => 'Error!'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $idProduct = $request->id;
        if (!empty($idProduct)) {
            $producto = producto::findOrFail($idProduct);
            $imagen = $producto->imagen;
            if (!empty($imagen)) {
                $this->_eliminar_imagen_producto($imagen);
            }
            $producto->delete();
            return response()->json('delete');
        } else {
            return response('error', 404);
        }
    }
    /**
     * Validate info for new product
     */
    private static function verificacion(Request $request)
    {
        $return = array();
        $rules = array(
            'referencia'                => 'required|unique:productos|max:255',
            'nombre_de_producto'        => 'required',
            'observaciones'             => 'required',
            'precio'                    => 'numeric|min:0|nullable',
            'impuesto'                  => 'numeric|min:0|max:20|nullable',
            'cantidad'                  => 'numeric|min:0|nullable',
            'imagen'                    => 'required|max:200',
        );
        $messages = array(
            'required'  => 'Este campo debe ser completado.',
            'integer'   => 'La columna debe contener números.'
        );

        $validator  = Validator::make($request->all(), $rules, $messages);

        if (!$validator->fails()) {
            $return['status'] = 'success';
        } else {
            $return['status'] = 'error';
            $return['message'] = $validator->messages();
        }

        return $return;
    }

    private static function _salvar_imagenproducto(Request $request, $nombre_de_producto)
    {
        $imagen              = $request->file('imagen');
        $original            = md5($imagen->getClientOriginalName());
        $extension           = $imagen->getClientOriginalExtension();
        $nombreFoto          = $nombre_de_producto . '_' . $original . '.' . $extension;
        Storage::disk('public')->put($nombreFoto, File::get($imagen));
        return $nombreFoto;
    }
    private static function _eliminar_imagen_producto($imagen)
    {
        if (Storage::exists($imagen)) {
            Storage::delete($imagen);
        }
    }

    private static function verificacionActualizar(Request $request)
    {
        $return = array();
        $rules = array(
            'referencia'                => 'required|max:255',
            'nombre_de_producto'        => 'required',
            'observaciones'             => 'required',
            'precio'                    => 'numeric|min:0|nullable',
            'impuesto'                  => 'numeric|min:0|max:20|nullable',
            'cantidad'                  => 'numeric|min:0|nullable',
            'imagen'                    => 'required|max:200',
        );
        $messages = array(
            'required'  => 'Este campo debe ser completado.',
            'integer'   => 'La columna debe contener números.'
        );

        $validator  = Validator::make($request->all(), $rules, $messages);

        if (!$validator->fails()) {
            $return['status'] = 'success';
        } else {
            $return['status'] = 'error';
            $return['message'] = $validator->messages();
        }

        return $return;
    }
}