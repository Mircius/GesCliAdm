<?php

use Illuminate\Database\Seeder;
use App\Cliente;
use App\Venta;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clientes')->delete();
        DB::table('ventas')->delete();
            
        //CREACIÓN DE CLIENTES
        for ($i=0; $i < 30; $i++) {
            DB::table('clientes')->insert([
                'Nombre' => str_random(15),
                'Direccion' => str_random(15),
                'provincia' => str_random(20),
                'Localidad' => str_random(15),
                'CIF/NIF' => self::getNIF(),
                'Email' => "usuario@localhost.com",
                'Telefono' => rand(),
                'CP' => rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9),
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ]);
        }
        
        //CREACIÓN DE VENTAS

        $estados = ['Validado','Sin validar','En espera'];
        
        for($i=0; $i < 30; $i++){
            DB::table('ventas')->insert([
                'Descripcion' => str_random(30),
                'Estado' => $estados[rand(0,2)],
                'id_cliente' => rand(1,30),
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ]);
        }
    }

    function getNIF(){
        $number = mt_rand(10000000, 99999999);

        return($number.self::LetraNIF($number));
        
    }
    function LetraNIF($dni) { 
        return $letraNif= substr ("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1); 
    } 
}
