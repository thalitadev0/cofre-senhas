<?php

namespace App\Http\Controllers;

use App\Models\Password;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;

class PasswordController extends Controller
{
    use AuthorizesRequests;

    /**
     * Lista todas as senhas do usuário autenticado.
     */
    public function index()
    {
        $passwords = Password::where('user_id', Auth::id())->get();
        return view('passwords.index', compact('passwords'));
    }

    /**
     * Exibe o formulário de criação de nova senha.
     */
    public function create()
    {
        return view('passwords.create');
    }

    /**
     * Salva uma nova senha no banco de dados.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'url'      => 'nullable|url',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:4',
        ]);

        Password::create([
            'user_id'            => Auth::id(),
            'title'              => $request->title,
            'url'                => $request->url,
            'username'           => $request->username,
            'password_encrypted' => Crypt::encryptString($request->password),
        ]);

        return redirect()->route('passwords.index')->with('success', 'Senha salva com sucesso!');
    }

    /**
     * Exibe os detalhes de uma senha descriptografada.
     */
    public function show(Password $password)
    {
        $this->authorize('view', $password);
        return view('passwords.show', compact('password'));
    }

    /**
     * Exibe o formulário de edição de uma senha.
     */
    public function edit(Password $password)
    {
        $this->authorize('update', $password);
        return view('passwords.edit', compact('password'));
    }

    /**
     * Atualiza uma senha existente.
     */
    public function update(Request $request, Password $password)
    {
        $this->authorize('update', $password);

        $request->validate([
            'title'    => 'required|string|max:255',
            'url'      => 'nullable|url',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:4|max:255',
        ]);

        $password->update([
            'title'              => $request->title,
            'url'                => $request->url,
            'username'           => $request->username,
            'password_encrypted' => Crypt::encryptString($request->password),
        ]);

        return redirect()->route('passwords.index')->with('success', 'Senha atualizada com sucesso!');
    }

    /**
     * Remove uma senha.
     */
    public function destroy(Password $password)
    {
        $this->authorize('delete', $password);
        $password->delete();
        return redirect()->route('passwords.index')->with('success', 'Senha deletada com sucesso!');
    }

    /**
     * Exporta todas as senhas do usuário em arquivo cifrado.
     */
    public function export()
    {
        $passwords = Auth::user()->passwords()->get()->map(function ($item) {
            return [
                'title'    => $item->title,
                'url'      => $item->url,
                'username' => $item->username,
                'password' => Crypt::decryptString($item->password_encrypted),
            ];
        });

        $json      = json_encode($passwords, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $encrypted = Crypt::encryptString($json);

        return Response::make($encrypted, 200, [
            'Content-Type'        => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="cofre-backup-' . now()->format('Y-m-d') . '.enc"',
        ]);
    }
}
