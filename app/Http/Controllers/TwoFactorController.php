<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class TwoFactorController extends Controller
{
    /**
     * Exibe a página de validação do 2FA.
     */
    public function index()
    {
        $user = Auth::user();

        // Se o usuário não tem 2FA ativado, vai direto pro dashboard
        if (!$user->google2fa_secret) {
            session(['2fa_passed' => true]);
            return redirect()->route('dashboard');
        }

        return view('2fa.validate');
    }

    /**
     * Valida o código 2FA digitado pelo usuário.
     */
    public function store(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|numeric',
        ]);

        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        $secret = Crypt::decrypt($user->google2fa_secret);

        $valid = $google2fa->verifyKey($secret, $request->one_time_password);

        if ($valid) {
            session(['2fa_passed' => true]);
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['one_time_password' => 'Código inválido. Tente novamente.']);
    }

    /**
     * Exibe a página para ativar o 2FA.
     */
    public function enable(Request $request)
    {
        $google2fa = app('pragmarx.google2fa');
        $user = Auth::user();

        $secret = $google2fa->generateSecretKey();
        $user->google2fa_secret = Crypt::encrypt($secret);
        $user->save();

        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secret
        );

        return view('2fa.enable', [
            'QR_Image' => $QR_Image,
            'secret'   => $secret,
        ]);
    }

    /**
     * Desativa o 2FA do usuário.
     */
    public function disable()
    {
        $user = Auth::user();
        $user->google2fa_secret = null;
        $user->save();

        return redirect()->route('dashboard')->with('success', '2FA desabilitado com sucesso!');
    }
}
