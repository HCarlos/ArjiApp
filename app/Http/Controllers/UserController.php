<?php

namespace App\Http\Controllers;

use App\Classes\FuncionesController;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request): \Inertia\Response
    {

        $filters =$request->input('search');

        if ($filters) {
            $F           = new FuncionesController();
            $filters      = strtolower($filters);
            $filters      = $F->str_sanitizer($filters);
            $tsString     = $F->string_to_tsQuery( strtoupper($filters),' & ');

            $users = User::all()
                ->with('user_adress')
                ->with('user_data_extend')
                ->search( $tsString )
                ->orderBy('id', 'desc')
                ->paginate();

            return Inertia::render('Users/Index', [
                'users' => $users,
                'totalAlumnos' => User::count(),
            ]);
        }
        $user = User::query()
            ->with('user_adress')
            ->with('user_data_extend')
            ->orderBy('id', 'desc')
            ->paginate(500);


        return Inertia::render('Users/Index', [
            'users' => $user,
            'totalAlumnos' => User::count(),
        ]);

    }

    public function store(UserRequest $request){

//        $validated = $request->validated();

//        $user = User::create([
//            ...$validated,
//            'password' => Hash::make($validated['password']),
//            'domicilio' => $validated['domicilio']
//        ]);

        $User = $request->managed(null);

        return redirect()->back()->with('success', 'Usuario creado exitosamente');
    }

    public function update(UserRequest $request, User $user){

//        dd($request->all());


//        $validated = $request->validated();

//        $updateData = [
//            ...$validated
//        ];
//
//        if (!empty($validated['password'])) {
//            $updateData['password'] = Hash::make($validated['password']);
//        }
//
//        $user->update($updateData);

        $User = $request->managed($user);

        return redirect()->back()->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy(User $user){

        $user->delete();

        return redirect()->back()->with('success', 'Usuario eliminado exitosamente');

    }

    public function alumnosIndex()
    {
        return Inertia::render('Users/Alumnos/AlumnosIndex', [
            'users' => User::paginate(250)
        ]);
    }


}
