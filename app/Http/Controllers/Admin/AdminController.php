<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\InvoicesExport;
use App\Models\Cashier;
use App\Models\Doctor;
use App\Models\Order;
use App\Models\Patient;
use App\Models\Position;
use App\Models\Registrar;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function index()
    {
        $count_patients = Patient::count();
        $count_positions = Position::count();
        $count_services = Service::count();
        $count_doctors = Doctor::count();
        $count_cashiers = Cashier::count();
        $count_registrars = Registrar::count();
        return view('admin.index', [
            'count_patients' => $count_patients,
            'count_doctors' => $count_doctors,
            'count_cashiers' => $count_cashiers,
            'count_registrars' => $count_registrars,
            'count_services' => $count_services,
            'count_positions' => $count_positions,
        ]);
    }

    public function doctor()
    {
        $doctors = Doctor::all();
        $orders = Order::where('paid_status_id', 1)->where('doctor_id', '!=', NULL)->get();
        $paper_money = Order::where('paid_status_id', 1)->where('payment_method_id', 1)->where('doctor_id', '!=', NULL)->sum('price');
        $card = Order::where('paid_status_id', 1)->where('payment_method_id', 2)->where('doctor_id', '!=', NULL)->sum('price');
        return view('admin.analyse', [
            'doctors' => $doctors,
            'doctor_id' => false,
            'orders' => $orders,
            'paper_money' => $paper_money,
            'card' => $card,
            'doctors_money' => false
        ]);
    }

    public function filter(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'doctor_id' => 'required'
        ]);
        $end_date = Carbon::parse($request->end_date)->addDays(1)->toDateString();
        if ($request->doctor_id != 0) {
            $doctors = Doctor::all();
            $doctor = Doctor::findOrFail($request->doctor_id);
            $orders = Order::where('paid_status_id', 1)->where('doctor_id', $request->doctor_id)->whereBetween('created_at', [$request->start_date, $end_date])->get();
            $paper_money = Order::where('paid_status_id', 1)->where('doctor_id', $request->doctor_id)->whereBetween('created_at', [$request->start_date, $end_date])->where('payment_method_id', 1)->sum('price');
            $card = Order::where('paid_status_id', 1)->where('doctor_id', $request->doctor_id)->whereBetween('created_at', [$request->start_date, $end_date])->where('payment_method_id', 2)->sum('price');
            $doctors_money = (($paper_money + $card) * $doctor->doctors_percent) / 100;
            return view('admin.analyse', [
                'doctors' => $doctors,
                'doctor' => $doctor,
                'doctor_id' => $request->doctor_id,
                'orders' => $orders,
                'paper_money' => $paper_money,
                'card' => $card,
                'doctors_money' => $doctors_money,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);
        } else {
            $doctors = Doctor::all();
            $orders = Order::where('paid_status_id', 1)->where('doctor_id', '!=', NULL)->whereBetween('created_at', [$request->start_date, $end_date])->get();
            $paper_money = Order::where('paid_status_id', 1)->where('payment_method_id', 1)->sum('price');
            $card = Order::where('paid_status_id', 1)->where('payment_method_id', 2)->sum('price');
            return view('admin.analyse', [
                'doctors' => $doctors,
                'doctor_id' => false,
                'orders' => $orders,
                'paper_money' => $paper_money,
                'card' => $card,
                'doctors_money' => false,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);
        }
    }

    public function export(Request $request)
    {
        if ($request->start_date && $request->end_date) {
            $end_date = Carbon::parse($request->end_date)->addDays(1)->toDateString();
            $orders = Order::where('paid_status_id', 1)->where('doctor_id', $request->doctor_id ?? '!=', NULL)->whereBetween('created_at', [$request->start_date, $end_date])->get();
            $paper_money = Order::where('paid_status_id', 1)->where('doctor_id', $request->doctor_id ?? '!=', NULL)->whereBetween('created_at', [$request->start_date, $end_date])->where('payment_method_id', 1)->sum('price');
            $card = Order::where('paid_status_id', 1)->where('doctor_id', $request->doctor_id ?? '!=', NULL)->whereBetween('created_at', [$request->start_date, $end_date])->where('payment_method_id', 2)->sum('price');
        } else {
            $orders = Order::where('paid_status_id', 1)->where('doctor_id', $request->doctor_id ?? '!=', NULL)->get();
            $paper_money = Order::where('paid_status_id', 1)->where('doctor_id', $request->doctor_id ?? '!=', NULL)->where('payment_method_id', 1)->sum('price');
            $card = Order::where('paid_status_id', 1)->where('doctor_id', $request->doctor_id ?? '!=', NULL)->where('payment_method_id', 2)->sum('price');
        }
        $doctor = Doctor::find($request->doctor_id);
        if ($doctor) {
            $doctors_money = (($paper_money + $card) * $doctor->doctors_percent) / 100;
        }
        return Excel::download(new InvoicesExport($orders, $request->doctor_id, $paper_money, $card, $doctors_money ?? null), 'invoices.xlsx');
    }
}
