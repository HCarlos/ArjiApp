<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BulkUserRolesController extends Controller
{
    public function edit(){

        $users = User::query()
            ->orderBy('ap_paterno')
            ->orderBy('ap_materno')
            ->orderBy('nombre')
            ->get()
            ->toArray();


        $allDatas = Role::query()->select('id', 'name as data')->get()->toArray();

        return Inertia::render('Users/Asignaciones/BulkUserEntitiesAssignment', [
            'users' => $users,
            'allDatas' => $allDatas,
            'assignedDatasByUser' => $this->getUserRolesList(),
            'addUrl' => '/bulk-roles/assign-partial',
            'removeUrl' => '/bulk-roles/remove-partial',
            'tableName' => 'Roles',
        ]);

    }


    /**
     * Asigna (parcialmente) datas a un usuario, sin quitar datas previos.
     */
    public function assignPartial(Request $request){

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'datas'   => 'required|array',
            'datas.*' => 'exists:roles,id',
        ]);

        $user = User::findOrFail($validated['user_id']);
        $user->roles()->syncWithoutDetaching($validated['datas']);

//        dd( $this->getUserRolesList() );

        return response()->json([
            'message' => 'Roles removidos correctamente',
            'data' => $this->getUserRolesList(),
        ], 200);


    }

    /**
     * Remueve (parcialmente) datas de un usuario.
     */
    public function removePartial(Request $request){

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'datas'   => 'required|array',
            'datas.*' => 'exists:roles,id',
        ]);

//        dd($validated['datas']);

        $user = User::findOrFail($validated['user_id']);
        $datasToDetach = array_map('intval', $validated['datas']);
        $user->roles()->detach($datasToDetach);

//        dd( $this->getUserRolesList() );

        // Sin redirect, simplemente JSON:
        return response()->json([
            'message' => 'Roles removidos correctamente',
            'data' => $this->getUserRolesList(),
        ], 200);

    }


    public function getUserRolesList(){
        $users = User::with('roles:id,name')->get(['id']);
        $assignedDatasByUser = [];

        foreach ($users as $user) {
            // Asegurar que cada item tenga 'id' no 'data_id'
            $assignedDatasByUser[$user->id] = $user->roles->map(function ($role) {
                return ['id' => $role->id, 'name' => $role->name];
            })->toArray();
        }

        return $assignedDatasByUser;
    }

}
