<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Sex;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        $sexes = Sex::all();
        return view('admin.patients.index', [
            'patients' => $patients,
            'sexes' => $sexes
        ]);
    }

    public function show(Patient $patient)
    {
        return view('admin.patients.show', [
            'patient' => $patient
        ]);
    }

    public function edit(Patient $patient)
    {
        $sexes = Sex::all();
        return view('admin.patients.edit', [
            'patient' => $patient,
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
            'address' => 'required|string',
            'sex_id' => 'required',
        ]);
        $patient = Patient::create([
            'first_name' => $validated_user['first_name'],
            'last_name' => $validated_user['last_name'],
            'sur_name' => $validated_user['sur_name'],
            'date_birth' => $validated_user['date_birth'],
            'phone_number' => $validated_user['phone_number'],
            'address' => $validated_user['address'],
            'sex_id' => $validated_user['sex_id']
        ]);

        return redirect()->route('admin.patients_index');
    }

    public function update(Request $request, Patient $patient)
    {
        $validated_user = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'sur_name' => 'required|string',
            'date_birth' => 'required|date',
            'phone_number' => 'required|max:9',
            'address' => 'required|string',
            'sex_id' => 'required'
        ]);
        $patient->update([
            'first_name' => $validated_user['first_name'],
            'last_name' => $validated_user['last_name'],
            'sur_name' => $validated_user['sur_name'],
            'date_birth' => $validated_user['date_birth'],
            'phone_number' => $validated_user['phone_number'],
            'address' => $validated_user['address'],
            'sex_id' => $validated_user['sex_id']
        ]);
        return redirect()->route('admin.patients_index');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('admin.patients_index');
    }
}
