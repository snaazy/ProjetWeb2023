<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');

        $query = User::query();

        if ($search) {
            $query->where('nom', 'LIKE', "%{$search}%")
                ->orWhere('prenom', 'LIKE', "%{$search}%")
                ->orWhere('login', 'LIKE', "%{$search}%");
        }

        if ($type) {
            $query->where('type', $type);
        }

        $users = $query->paginate(10);

        return view('admin.users.index', ['users' => $users]);
    }
}
