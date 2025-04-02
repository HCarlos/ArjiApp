<?php

namespace Database\Seeders;

use App\Classes\FuncionesController;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ImportUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{


        @ini_set( 'upload_max_size' , '32768M' );
        @ini_set( 'post_max_size', '32768M');
        @ini_set( 'max_execution_time', '256000000' );
        @ini_set('memory_limit', '-1');

        $F = new FuncionesController();

        /* ************************************************************************************************
                //SUBIMOS DEPENDENCIAS
        ************************************************************************************************** */
//        $file = 'public/csv/_viAlumnos.csv';
        $file = 'public/csv/_viPersonas.csv';
        $json_data = file_get_contents($file);
        $json_data = preg_split( "/\n/", $json_data );

        for ($x = 1, $xMax = count($json_data); $x < $xMax; $x++){
            try{

                $dupla = preg_split("/\t/", $json_data[$x], -1, PREG_SPLIT_NO_EMPTY);
                $arr = str_getcsv($dupla[0]);

//                dd($arr);

                $username = strtolower(trim($arr[31]));
                $password = bcrypt($username);
                $email = $username."@mail.com";
                $nombre = strtoupper(trim($arr[3]));
                $ap_paterno = strtoupper(trim($arr[2]));
                $ap_materno = strtoupper(trim($arr[1]));
                $curp = strtoupper(trim($arr[11]));
                $emails = strtolower(trim($arr[9]));
                $celulares = strtoupper(trim($arr[7]).", ".trim($arr[8]));
                $telefonos = strtoupper(trim($arr[5]).", ".trim($arr[6]));
                if (substr(trim($arr[13]), 0, 4) == "0000" || $arr[13] == "") {
                    $fecha_nacimiento = null;
                }else{
                    $fecha_nacimiento = Carbon::parse(trim($arr[13]))->format('Y-m-d');
                }
                $genero = (int) trim($arr[15]);

                $user = User::create([
                'username'=>$username,
                'email'=>$email,
                'password'=>$password,
                'nombre'=>$nombre,
                'ap_paterno'=>$ap_paterno,
                'ap_materno'=>$ap_materno,
                'curp'=>$curp,
                'emails'=>$emails,
                'celulares'=>$celulares,
                'telefonos'=>$telefonos,
                'fecha_nacimiento'=>$fecha_nacimiento,
                'genero'=>$genero,
                ]);

                //para alumnos
//                $user->roles()->attach(4);

                // para padres
                if ( $genero === 1) {
                    $user->roles()->attach(5);
                }else{
                    $user->roles()->attach(6);
                }

                $user->permisos()->attach(7);

                $user->user_adress()->create();
                $user->user_data_extend()->create();
                $F->validImage($user,'profile','profile/');


            }catch (QueryException $e){
                Log::alert("Error en :: ".$username." - ".$e->getMessage());
                continue;
            }catch (Exception $e){
                Log::alert("Error en ".$username." - ".$e->getMessage());
                continue;
//                exit;
            }
        }



    }



}
