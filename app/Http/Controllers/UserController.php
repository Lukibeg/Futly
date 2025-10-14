<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $authUser = Auth::user()->id;

        if ($authUser == $user->id) {
            return view('users.profile', compact('user'));
        } else {
            return view('users.showProfile', compact('user'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) {}

    public function updateProfile(Request $request, User $user)
    {
        $authUser = Auth::user()->id;

        $validated = $request->validate([
            'birthdate' => 'date',
            'position' => 'string|max:255',
            'about_me' => 'string',
            'strengths' => 'string',
            'weaknesses' => 'string',
            'preferred_foot' => 'string|max:255',
            'height' => 'numeric',
            'city' => 'string|max:255',
            'state' => 'string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,jpg,svg,png,webp|max:5096',
        ]);

        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        } else {
            $validated['profile_picture'] = null;
        }

        if ($authUser !== $user->id) {
            return redirect()->route('users.show', $authUser)->with('error', 'Você não possui permissão para realizar esta ação.');
        }

        try {
            $user = User::find($user->id);
            $user->update($validated);
            return redirect()->route('users.show', $user->id)->with('success', 'Perfil atualizado com sucesso');
        } catch (\Exception $e) {
            return redirect()->route('users.show', $user->id)->with('error', 'Erro ao atualizar perfil: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //         
    }
}
