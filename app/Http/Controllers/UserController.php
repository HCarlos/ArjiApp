<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/Index', [
            'users' => User::paginate()
        ]);
    }

    public function alumnosIndex()
    {
        return Inertia::render('Users/Alumnos/AlumnosIndex', [
            'users' => User::paginate()
        ]);
    }


}
