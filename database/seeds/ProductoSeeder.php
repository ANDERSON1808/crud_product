<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('productos')->insert([
            'id'                    => 1,
            'referencia'            => 'ABCD',
            'nombre_de_producto'    => 'camisa azul',
            'observaciones'         => 'camisa hermosa para hombre',
            'precio'                => 25.000,
            'impuesto'              => 15,
            'cantidad'              => 10,
            'imagen'                => "/storage/camisa_b47df5b92702a4b74f1ec558606e16a1.jpeg"
        ]);
    }
}