<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\UserRegistrationMail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Filtros
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('access_level') && $request->access_level != '') {
            $query->where('access_level', $request->access_level);
        }

        if ($request->has('approved') && $request->approved != '') {
            $query->where('approved', $request->approved);
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Ordenação
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'last_login':
                $query->orderBy('last_login', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $users = $query->paginate(10);

        // Estatísticas
        $totalUsuarios = User::count();
        $totalAprovados = User::where('approved', 1)->count();
        $totalNaoAprovados = User::where('approved', 0)->count();
        $totalAdministradores = User::where('access_level', 2)->count();
        $totalSuperAdmin = User::where('access_level', 3)->count();

        $accessLevels = [
            1 => 'Usuário',
            2 => 'Administrador',
            3 => 'Super Admin'
        ];

        return view('users.index', compact(
            'users',
            'accessLevels',
            'totalUsuarios',
            'totalAprovados',
            'totalNaoAprovados',
            'totalAdministradores',
            'totalSuperAdmin'
        ));
    }

    public function create()
    {
        $accessLevels = [
            1 => 'Usuário',
            2 => 'Administrador',
            3 => 'Super Admin'
        ];

        return view('users.create', compact('accessLevels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'access_level' => 'required|integer',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'approved' => 'boolean'
        ]);

        // Gerar senha aleatória
        $password = Str::random(10);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'access_level' => $request->access_level,
            'password' => Hash::make($password),
            'approved' => $request->approved ?? 0,
        ];

        // Upload da foto
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('users', 'public');
            $userData['photo'] = $photoPath;
        }

        $user = User::create($userData);

        // Enviar email com dados de login
        try {
            Mail::to($user->email)->send(new UserRegistrationMail($user, $password));
            $emailStatus = 'Email de boas-vindas enviado.';
        } catch (\Exception $e) {
            $emailStatus = 'Usuário criado, mas email não pôde ser enviado.';
        }

        return redirect()->route('users.index')
            ->with('success', 'Usuário criado com sucesso! ' . $emailStatus);
    }

    public function edit(User $user)
    {
        $accessLevels = [
            1 => 'Usuário',
            2 => 'Administrador',
            3 => 'Super Admin'
        ];

        return view('users.edit', compact('user', 'accessLevels'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'access_level' => 'required|integer',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'approved' => 'boolean',
            'password' => 'nullable|min:6|confirmed'
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'access_level' => $request->access_level,
            'approved' => $request->approved ?? 0,
        ];

        // Upload da nova foto
        if ($request->hasFile('photo')) {
            // Deletar foto antiga se existir
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $photoPath = $request->file('photo')->store('users', 'public');
            $updateData['photo'] = $photoPath;
        }

        // Remover foto se solicitado
        if ($request->has('remove_photo') && $user->photo) {
            Storage::disk('public')->delete($user->photo);
            $updateData['photo'] = null;
        }

        // Atualizar senha se fornecida
        if ($request->password) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
        // Não permitir deletar o próprio usuário
        if ($user->id === session('user.id')) {
            return redirect()->back()
                ->with('error', 'Você não pode deletar seu próprio usuário.');
        }

        // Deletar foto se existir
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuário deletado com sucesso!');
    }

    public function toggleApproval(User $user)
    {
        $user->update([
            'approved' => !$user->approved,
        ]);

        $status = $user->approved ? 'aprovado' : 'reprovado';

        return redirect()->back()
            ->with('success', "Usuário {$status} com sucesso!");
    }

    // Relatório de acessos
    public function accessReport(Request $request)
    {
        $query = User::where('login_count', '>', 0);

        if ($request->has('date_from') && $request->date_from != '') {
            $query->where('last_login', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->where('last_login', '<=', $request->date_to . ' 23:59:59');
        }

        if ($request->has('access_level') && $request->access_level != '') {
            $query->where('access_level', $request->access_level);
        }

        $users = $query->orderBy('last_login', 'desc')->paginate(15);

        // Estatísticas
        $totalAcessos = User::sum('login_count');
        $usuariosAtivos = User::where('last_login', '>=', now()->subDays(30))->count();
        $totalUsuarios = User::count();
        $mediaAcessos = $totalUsuarios > 0 ? $totalAcessos / $totalUsuarios : 0;
        $ultimoAcesso = User::max('last_login');

        return view('users.access-report', compact(
            'users',
            'totalAcessos',
            'usuariosAtivos',
            'mediaAcessos',
            'ultimoAcesso'
        ));
    }
}
