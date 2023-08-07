<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use App\Models\Position;
use App\Models\Sex;
use App\Models\User;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index()
    {
        $cashiers = Cashier::all();
        $sexes = Sex::all();
        return view('admin.cashiers.index', [
            'cashiers' => $cashiers,
            'sexes' => $sexes
        ]);
    }

    public function edit(Cashier $cashier)
    {
        $sexes = Sex::all();
        $positions = Position::all();
        return view('admin.cashiers.edit', [
            'cashier' => $cashier,
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
        $user->assignRole('cashier');
        Cashier::create([
            'user_id' => $user->id,
        ]);
        return redirect()->route('admin.cashiers_index');
    }

    public function update(Request $request, Cashier $cashier)
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
        $user = User::find($cashier->user_id);
        $cashier->update([
            'position_id' => $request->position_id
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
        return redirect()->route('admin.cashiers_index');
    }

    public function destroy(Cashier $cashier)
    {
        $user = User::find($cashier->user_id);
        $user->delete();
        return redirect()->route('admin.cashiers_index');
    }
}
