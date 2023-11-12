<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('front.account.login');
    }
    public function register(){
        return view('front.account.register');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->passes()) {

            if (Auth::attempt([
                'email' => $request->email,
                'password' => $request->password
            ], $request->get('remember'))){
            return redirect()->route('dashboard.index');
                } else {
                    return redirect()->route('account.login')
                    ->withInput($request->only('email'))
                    ->with('error', 'Either Email/Password is incorrect');
                }

            } else {
            return redirect()->route('account.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }

    public function processRegister(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
        
                event(new Registered($user));
                return redirect()->route('account.profile');
}
public function update_user(){
    return view('front.users.edit');
}
public function logout(){
    Auth::logout();
    return redirect()->route('account.login')
    ->with('success', 'you successfully logged out!');
}

public function update(UpdateUserRequest $request, User $user)
{

//        if ($validatedData['email'] != $user->email) {
//            $validatedData['email_verified_at'] = null;
//        }

    $user->update($request->except('photo'));

    /**
     * Handle upload image with Storage.
     */
    if($request->hasFile('photo')){

        // Delete Old Photo
        if($user->photo){
            unlink(public_path('storage/profile/') . $user->photo);
        }

        // Prepare New Photo
        $file = $request->file('photo');
        $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();

        // Store an image to Storage
        $file->storeAs('profile/', $fileName, 'public');

        // Save DB
        $user->update([
            'photo' => $fileName
        ]);
    }

    return redirect()
        ->route('users.index')
        ->with('success', 'User has been updated!');
}

public function updatePassword(Request $request, String $username)
{
    # Validation
    $validated = $request->validate([
        'password' => 'required_with:password_confirmation|min:6',
        'password_confirmation' => 'same:password|min:6',
    ]);

    # Update the new Password
    User::where('username', $username)->update([
        'password' => Hash::make($validated['password'])
    ]);

    return redirect()
        ->route('users.index')
        ->with('success', 'User has been updated!');
}
}