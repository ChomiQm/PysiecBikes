<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserData;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
class RegisterController extends Controller
{
    use RegistersUsers;
    protected string $redirectTo = '/home';
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
        // Utworzenie użytkownika
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Przypisanie roli "User" nowo utworzonemu użytkownikowi
        $userRole = Role::where('name', 'User')->first();
        if ($userRole) {
            $user->assignRole($userRole);
        } else {
            // Możesz chcieć rzucać wyjątkiem lub logować, że rola nie istnieje
            // throw new \Exception('Role "User" does not exist.');
            logger()->warning('Role "User" does not exist.');
        }

        // Dodaj dane do `UserData` po utworzeniu użytkownika
        // Zakładając, że przekazujesz resztę danych użytkownika w $data
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

        return $user;
    }
}
