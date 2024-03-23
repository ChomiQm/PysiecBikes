<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserData;
use App\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected string $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data): \Illuminate\Validation\Validator
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'street_address' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:255'],
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $userRole = Role::where('name', 'User')->first();
        if (!$userRole) {
            $userRole = Role::create(['name' => 'User']);
        }
        $user->assignRole($userRole);

        UserData::create([
            'user_id' => $user->id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'country' => $data['country'],
            'state' => $data['state'],
            'city' => $data['city'],
            'street_address' => $data['street_address'],
            'postal_code' => $data['postal_code'],
        ]);

        Log::info('User registration successful.', $data);

        return $user;
    }

    /**
     * @throws ValidationException
     */
    public function register(Request $request): \Illuminate\Foundation\Application|Redirector|RedirectResponse|Application
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        return $this->registered($request, $user);
    }

    protected function registered(Request $request, $user): \Illuminate\Foundation\Application|Redirector|RedirectResponse|Application
    {
        // Przekierowanie użytkownika po pomyślnej rejestracji
        return redirect('/');
    }
}
