<?php

namespace Database\Seeders;

use App\Classes\FuncionesController;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void{


        app()['cache']->forget('spatie.permission.cache');

        $F = new FuncionesController();
        $ip   = 'root_init';//$_SERVER['REMOTE_ADDR'];
        $host = 'root_init';//gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $idemp = 1;

        $P1 = Permission::create(['name' => 'all']);
        $P2 = Permission::create(['name' => 'crear']);
        $P3 = Permission::create(['name' => 'guardar']);
        $P4 = Permission::create(['name' => 'editar']);
        $P5 = Permission::create(['name' => 'modificar']);
        $P6 = Permission::create(['name' => 'eliminar']);
        $P7 = Permission::create(['name' => 'consultar']);
        $P8 = Permission::create(['name' => 'imprimir']);
        $P9 = Permission::create(['name' => 'asignar']);
        $P10 = Permission::create(['name' => 'desasignar']);
        $P11 = Permission::create(['name' => 'sysop']);

        $role_admin = Role::create([
            'name' => 'Administrator',
            'descripcion' => 'Administrator',
            'abreviatura' => 'ADM',
            'guard_name' => 'web',
        ]);
        $role_admin->permissions()->attach($P1);

        $role_sysop = Role::create([
            'name' => 'SysOp',
            'descripcion' => 'System Operator',
            'abreviatura' => 'SysOp',
            'guard_name' => 'web',
        ]);
        $role_sysop->permissions()->attach($P11);

        $role_invitado = Role::create([
            'name' => 'Invitado',
            'descripcion' => 'Invitado',
            'abreviatura' => 'INV',
            'guard_name' => 'web',
        ]);
        $role_invitado->permissions()->attach($P7);

        $user = new User();
        $user->nombre = 'Administrador';
        $user->username = 'Admin';
        $user->email = 'sentauro@gmail.com';
        $user->password = bcrypt('secret');
        $user->genero = 1;
        $user->empresa_id = $idemp;
        $user->ip = $ip;
        $user->host = $host;
        $user->email_verified_at = now();
        $user->save();
        $user->roles()->attach($role_admin);
        $user->permissions()->attach($P1);
        $user->user_adress()->create();
        $user->user_data_extend()->create();
        $F->validImage($user,'profile','profile/');

        $user = new User();
        $user->nombre = 'System Operator';
        $user->username = 'SysOp';
        $user->email = 'sysop@example.com';
        $user->password = bcrypt('sysop');
        $user->empresa_id = $idemp;
        $user->ip = $ip;
        $user->host = $host;
        $user->email_verified_at = now();
        $user->save();
        $user->roles()->attach($role_sysop);
        $user->permissions()->attach($P11);
        $user->user_adress()->create();
        $user->user_data_extend()->create();
        $F->validImage($user,'profile','profile/');

        $user = new User();
        $user->nombre = 'Invitado';
        $user->username = 'Invitado';
        $user->email = 'invitado@example.com';
        $user->password = bcrypt('Invitado');
        $user->empresa_id = $idemp;
        $user->ip = $ip;
        $user->host = $host;
        $user->email_verified_at = now();
        $user->save();
        $user->roles()->attach($role_invitado);
        $user->permissions()->attach($P7);
        $user->user_adress()->create();
        $user->user_data_extend()->create();
        $F->validImage($user,'profile','profile/');


        Role::create(['name'=>'ALUMNO','descripcion'=>'ALUMNO','abreviatura'=>'ALU','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'PADRE','descripcion'=>'PADRE','abreviatura'=>'PAD','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'MADRE','descripcion'=>'MADRE','abreviatura'=>'MAD','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'TUTOR','descripcion'=>'TUTOR','abreviatura'=>'TUR','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'PROFESOR','descripcion'=>'PROFESOR','abreviatura'=>'PROF','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'DIRECTOR','descripcion'=>'DIRECTOR','abreviatura'=>'DIR','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'COORDINADOR','descripcion'=>'COORDINADOR','abreviatura'=>'COORD','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'EXALUMNO','descripcion'=>'EXALUMNO','abreviatura'=>'EXAL','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'ADMINISTRATIVO','descripcion'=>'ADMINISTRATIVO','abreviatura'=>'ADM1','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'CAJERO','descripcion'=>'CAJERO','abreviatura'=>'CAJ','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'SUPERVISOR_CAJA','descripcion'=>'SUPERVISOR_CAJA','abreviatura'=>'SUPCAJA','guard_name'=>'web'])->permissions()->attach($P7);



    }


}
