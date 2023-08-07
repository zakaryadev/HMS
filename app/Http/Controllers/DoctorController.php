<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Position;
use App\Models\Sex;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        $sexes = Sex::all();
        $positions = Position::all();
        return view('admin.doctors.index', [
            'doctors' => $doctors,
            'sexes' => $sexes,
            'positions' => $positions
        ]);
    }

    public function edit(Doctor $doctor)
    {
        $sexes = Sex::all();
        $positions = Position::all();
        return view('admin.doctors.edit', [
            'doctor' => $doctor,
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
        $user->assignRole('doctor');
        Doctor::create([
            'user_id' => $user->id,
            'position_id' => $request->position_id,
            'doctors_percent' => $request->doctors_percent
        ]);
        return redirect()->route('admin.doctors_index');
    }
    public function update(Request $request, Doctor $doctor)
    {
        $validated_user = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'sur_name' => 'required|string',
            'date_birth' => 'required|date',
            'phone_number' => 'required|max:9',
            'login' => 'required',
            'password' => 'required|min:8|max:16',
            'confirm_password' => 'required|same:password',
            'sex_id' => 'required'
        ]);
        $user = User::find($doctor->user_id);
        $doctor->update([
            'position_id' => $request->position_id,
            'doctors_percent' => $request->doctors_percent
        ]);
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
        return redirect()->route('admin.doctors_index');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('admin.doctors_index');
    }
}
