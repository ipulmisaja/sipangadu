<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JKD\SSO\Client\Provider\Keycloak;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    private $provider;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        $tempUri = App::environment() === 'local'
                    ? config('services.bps.callback_url_local')
                    : config('services.bps.callback_url_production');


        $this->provider = new Keycloak([
            'authServerUrl' => 'https://sso.bps.go.id',
            'realm'         => 'pegawai-bps',
            'clientId'      => config('services.bps.client_id'),
            'clientSecret'  => config('services.bps.client_secret'),
            'redirectUri'   => $tempUri
        ]);
    }

    public function sso(Request $request)
    {
        if (!$request->input('code')) {
            $authUrl = $this->provider->getAuthorizationUrl();

            $request->session()->put('oauth2state', $this->provider->getState());
            $request->session()->save();

            header('Location: ' . $authUrl);
            exit;
        } elseif (empty($request->input('state')) || $request->input('state') !== $request->session()->get('oauth2state')) {
            $request->session()->forget('oauth2state');
            $request->session()->save();
            exit;
        } else {
            try {
                $token = $this->provider->getAccessToken('authorization_code', [
                    'code' => $request->input('code')
                ]);

                 // Gunakan token ini untuk berinteraksi dengan API di sisi pengguna
                $request->session()->put('bps_access_token', $token->getToken());
                $request->session()->save();
            } catch (Exception $e) {
                return abort(400, $e->getMessage());
            }

            // Opsional: Setelah mendapatkan token, anda dapat melihat data profil pengguna
            try {
                $data = $this->provider->getResourceOwner($token);

                $user = Pengguna::where('bps_id', $data->getNip())->first();

                if(!empty($user)) {
                    try {
                        DB::beginTransaction();

                        $user->update([
                            'nama'    => $data->getName(),
                            'email'   => $data->getEmail(),
                            'nip_id'  => $data->getNipBaru(),
                            'jabatan' => $data->getJabatan(),
                            'foto'    => $data->getUrlFoto(),
                        ]);

                        DB::commit();
                    } catch(Exception $e) {
                        DB::rollBack();

                        return abort(403, $e->getMessage());
                    }

                    if(Auth::loginUsingId($user->id)) return $this->sendLoginResponse($request);
                } else {
                    return abort(403, 'Anda tidak mempunyai akses untuk aplikasi ini.');
                }
            } catch (Exception $e) {
                return abort(401, $e->getMessage());
            }
        }
    }
}
