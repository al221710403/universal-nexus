<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        // dd($input['name']);
        Validator::make($input, [
            'username' => ['required', 'unique:users', 'max:100'],
            'name' => ['required', 'string', 'max:255'],
            'email' => $input['email'] ? ['string', 'email', 'max:255', 'unique:users'] : [],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $slug = $this->createSlug($input['name']);

        return User::create([
            'username' => $input['username'],
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'slug' => $slug,
        ]);
    }

    public function createSlug($name)
    {
        $slug = Str::slug($name);
        $slugExist = User::where('slug', $slug)->first();

        if ($slugExist) {
            $max = User::where('name', $name)->count();
            $max = $max == 0 ? 1 : $max + 1;
            return $slug . '-' . $max;
        } else {
            return $slug;
        }
    }
}
