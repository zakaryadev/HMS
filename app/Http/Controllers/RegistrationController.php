<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaidStatus;
use App\Models\Patient;
use App\Models\Position;
use App\Models\Service;
use App\Models\Sex;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function index()
    {
        $patients = Patient::latest()->get();
        $sexes = Sex::all();
        return view('registration.index', [
            'patients' => $patients,
            'sexes' => $sexes
        ]);
    }

    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        $paid_statuses = PaidStatus::all();
        return view('registration.show', [
            'patient' => $patient,
            'paid_statuses' => $paid_statuses
        ]);
    }

    public function store(Request $request)
    {
        $register = Patient::create($request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'sur_name' => 'required',
            'date_birth' => 'required',
            'phone_number' => 'required|regex:/^\d{9}$/',
            'address' => 'required',
            'sex_id' => 'required'
        ]));
        return redirect()->route('registration.index');
    }

    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        $sexes = Sex::all();
        return view('registration.edit', [
            'patient' => $patient,
            'sexes' => $sexes
        ]);
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->update($request->all());
        return redirect()->route('registration.index');
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return redirect()->route('registration.index');
    }

    public function send_doc($id)
    {
        $patient = Patient::findOrFail($id);
        $services = Service::all();
        $positions = Position::all();
        return view('registration.send_doc', [
            'patient' => $patient,
            'services' => $services,
            'positions' => $positions
        ]);
    }

    public function send_doc_store(Request $request)
    {
        $total_price = 0;
        foreach ($request->directions as $direct) {
            $service = Service::findOrFail($direct);
            $total_price += $service->price;
            $order = Order::create([
                'patient_id' => $request->patient_id,
                'registrar_id' => auth()->user()->registrar->id,
                'service_id' => $direct,
                'price' => $service->price,
                'paid_status_id' => 2,
                'payment_method_id' => 1,
                'doctor_id' => null,
                'cashier_id' => null,
                'destination' => null
            ]);
        }

        return redirect()->route('registration.index')->with('success', 'Запись успешно добавлена!');
    }

    public function analyse()
    {
        // for statistics
        $oneDayAgo = Carbon::now()->subDays(1);
        $today = Carbon::now();
        $oneDayAgoPatientsCount = Patient::whereDate('created_at', $oneDayAgo)->count();
        $todayPatientsCount = Patient::whereDate('created_at', $today)->count();
        if ($oneDayAgoPatientsCount > 0) {
            if ($todayPatientsCount > $oneDayAgoPatientsCount) {
                $upPercent = ($todayPatientsCount - $oneDayAgoPatientsCount) / $oneDayAgoPatientsCount * 100;
            } else {
                $minusPercent = ($oneDayAgoPatientsCount - $todayPatientsCount) / $oneDayAgoPatientsCount * 100;
            }
        }
        // sevendays ago
        $total_patients = Patient::all()->count();
        $sevenDaysAgo = Carbon::now()->subDays(7);
        $patientsByDay = Patient::select(
            DB::raw('DATE(created_at) as register_date'),
            DB::raw('COUNT(*) as total_patients'),
        )
            ->where('created_at', '>=', $sevenDaysAgo)
            ->groupBy('register_date')
            ->orderBy('register_date', 'ASC')
            ->get();

        return view('registration.analyse', [
            'patientsByDay' => $patientsByDay ?? 0,
            'total_patients' => $total_patients ?? 0,
            'upPercent' => $upPercent ?? 0,
            'minusPercent' => $minusPercent ?? 0,
        ]);
    }
}
