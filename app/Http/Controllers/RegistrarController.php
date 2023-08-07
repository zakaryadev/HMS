<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Registrar;
use App\Models\Sex;
use App\Models\User;
use Illuminate\Http\Request;

class RegistrarController extends Controller
{
    public function index()
    {
        $registrars = Registrar::all();
        $sexes = Sex::all();
        return view('admin.registrars.index', [
            'registrars' => $registrars,
            'sexes' => $sexes
        ]);
    }

    public function edit(Registrar $registrar)
    {
        $sexes = Sex::all();
        $positions = Position::all();
        return view('admin.registrars.edit', [
            'registrar' => $registrar,
            'positions' => $positions,
            'sexes' => $sexes
        ]);
    }

    public function store(Request $request)
    {
        $validated_user = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'sur_name' => 'required|string',
            'date_birth' => 'required|date',
            'phone_number' => 'required|min:9|max:9',
            'login' => 'required',
            'password' => 'required|min:8|max:16',
            'sex_id' => 'required',
        ]);
        $user = User::create([
            'first_name' => $validated_user['first_name'],
            'last_name' => $validated_user['last_name'],
            'sur_name' => $validated_user['sur_name'],
            'date_birth' => $validated_user['date_birth'],
            'phone_number' => $validated_user['phone_number'],
            'login' => $validated_user['login'],
            'password' => $validated_user['password'],
            'sex_id' => $validated_user['sex_id']
        ]);
        $user->assignRole('registrar');
        Registrar::create([
            'user_id' => $user->id,
        ]);
        return redirect()->route('admin.registrars_index');
    }

    public function update(Request $request, Registrar $registrar)
    {
        $validated_user = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'sur_name' => 'required|string',
            'date_birth' => 'required|date',
            'phone_number' => 'required|max:9',
            'login' => 'required',
            'password' => 'required|min:8|max:16',
            'sex_id' => 'required'
        ]);
        $user = User::find($registrar->user_id);
        $user->update([
            'first_name' => $validated_user['first_name'],
            'last_name' => $validated_user['last_name'],
            'sur_name' => $validated_user['sur_name'],
            'date_birth' => $validated_user['date_birth'],
            'phone_number' => $validated_user['phone_number'],
            'login' => $validated_user['login'],
            'password' => $validated_user['password'],
            'sex_id' => $validated_user['sex_id']
        ]);
        $user->save();
        return redirect()->route('admin.registrars_index');
    }

    public function destroy(Registrar $registrar)
    {
        $user = User::find($registrar->user_id);
        $user->delete();
        return redirect()->route('admin.registrars_index');
    }
}
