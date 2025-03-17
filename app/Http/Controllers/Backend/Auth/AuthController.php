<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller {
    // Tampilkan form login

    public function showLoginForm() {
        return view( 'auth.login' );
    }

    // Proses login

    public function login( Request $request ) {
        // Validasi input
        $credentials = $request->validate( [
            'login' => 'required|string', // Bisa email atau username
            'password' => 'required|string',
        ] );

        // Tentukan apakah input adalah email atau username
        $loginType = filter_var( $request->login, FILTER_VALIDATE_EMAIL ) ? 'email' : 'username';

        // Siapkan kredensial untuk autentikasi
        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        //Log::info( 'Attempting login with credentials: ', $credentials );
        // Coba autentikasi
        if ( Auth::attempt( $credentials ) ) {
            $request->session()->regenerate();
            return redirect()->intended( '/dashboard' );
        }

        //Log::warning( 'Login failed for credentials: ', $credentials );
        // Jika gagal, lempar error yang lebih spesifik
        throw ValidationException::withMessages( [
            'login' => [ 'The provided credentials do not match our records.' ],
        ] );
    }

    // Tampilkan form register

    public function showRegisterForm() {
        return view( 'auth.register' );
    }

    // Proses register

    public function register( Request $request ) {
        // Validasi input
        $data = $request->validate( [
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ] );

        // Buat pengguna baru
        $user = User::create( [
            'name' => $data[ 'name' ],
            'username' => $data[ 'username' ],
            'email' => $data[ 'email' ],
            'password' => Hash::make( $data[ 'password' ] ),
        ] );

        // Login otomatis setelah register
        Auth::login( $user );
        return redirect( '/dashboard' );
    }

    // Tampilkan form change password
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    // Proses change password
    public function changePassword( Request $request ) {
        $request->validate( [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ] );

        $user = Auth::user();

        if ( !Hash::check( $request->current_password, $user->password ) ) {
            return back()->withErrors( [ 'current_password' => 'Current password is incorrect' ] );
        }

        $user->password = Hash::make( $request->new_password );
        $user->save();

        return redirect( '/dashboard' )->with( 'success', 'Password changed successfully' );
    }

    // Tampilkan form forgot password

    public function showForgotPasswordForm() {
        return view( 'auth.forgot-password' );
    }

    // Proses forgot password

    public function forgotPassword( Request $request ) {
        $request->validate( [ 'email' => 'required|email' ] );

        $status = Password::sendResetLink(
            $request->only( 'email' )
        );

        return $status === Password::RESET_LINK_SENT
        ? back()->with( [ 'status' => __( $status ) ] )
        : back()->withErrors( [ 'email' => __( $status ) ] );
    }

    // Tampilkan form reset password

    public function showResetPasswordForm( Request $request, $token ) {
        return view( 'auth.reset-password', [ 'token' => $token, 'email' => $request->email ] );
    }

    // Proses reset password

    public function resetPassword( Request $request ) {
        $request->validate( [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ] );

        $status = Password::reset(
            $request->only( 'email', 'password', 'password_confirmation', 'token' ),

            function ( $user, $password ) {
                $user->forceFill( [
                    'password' => Hash::make( $password )
                ] )->setRememberToken( Str::random( 60 ) );

                $user->save();

                event( new PasswordReset( $user ) );
            }
        );

        return $status === Password::PASSWORD_RESET
        ? redirect()->route( 'login.form' )->with( 'status', __( $status ) )
        : back()->withErrors( [ 'email' => [ __( $status ) ] ] );
    }

    // Proses logout

    public function logout( Request $request ) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect( '/' );
    }
}
