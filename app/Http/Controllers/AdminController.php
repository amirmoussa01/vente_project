<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Formulaire de login
    public function loginForm()
    {
        return view('admin.login');
    }

    // Traitement du login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            session(['admin_id' => $admin->id]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['login' => 'Identifiants invalides']);
    }

    // Dashboard (juste un lien vers la gestion)
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Déconnexion
    public function logout()
    {
        session()->forget('admin_id');
        return redirect()->route('admin.login');
    }

    // Liste des admins
    public function index()
    {
        $this->authorizeAdmin();
        $admins = Admin::all();
        return view('admin.index', compact('admins'));
    }

    // Ajouter un admin
    public function create()
    {
        $this->authorizeAdmin();
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'username' => 'required|unique:admins',
            'password' => 'required|min:4|confirmed',
        ]);

        Admin::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admins.index')->with('success', 'Admin ajouté.');
    }

    // Modifier un admin
    public function edit(Admin $admin)
    {
        $this->authorizeAdmin();
        return view('admin.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $this->authorizeAdmin();

        $request->validate([
            'username' => 'required|unique:admins,username,' . $admin->id,
            'password' => 'nullable|min:4|confirmed',
        ]);

        $admin->username = $request->username;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admins.index')->with('success', 'Admin modifié.');
    }

    // Supprimer un admin
    public function destroy(Admin $admin)
    {
        $this->authorizeAdmin();
        $admin->delete();
        return back()->with('success', 'Admin supprimé.');
    }

    private function authorizeAdmin()
    {
        if (!session('admin_id')) {
            abort(403);
        }
    }
}

