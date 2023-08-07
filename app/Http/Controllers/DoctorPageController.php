<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;

class DoctorPageController extends Controller
{
  public function index()
  {
    $doctor_orders_count = Service::where('position_id', auth()->user()->doctor->position_id)->get()->count();
    $doctor_patients_count = Order::where('doctor_id', auth()->user()->doctor->id)->count();
    return view('doctor.index', [
      'doctor_patients_count' => $doctor_patients_count,
      'doctor_orders_count' => $doctor_orders_count,
    ]);
  }

  public function orders()
  {
    $statuses = [1, 4];
    $matchingOrders = [];
    $doctorId = auth()->user()->doctor->id;
    $orders = Order::where('doctor_id', $doctorId)
      ->orWhereNull('doctor_id')
      ->whereIn('paid_status_id', $statuses)
      ->get();
    foreach ($orders as $order) {
      if ($order->service->position_id == auth()->user()->doctor->position_id) {
        $matchingOrders[] = $order;
      }
    }
    return view('doctor.orders', [
      'orders' => $matchingOrders,
    ]);
  }

  public function show(Order $order)
  {
    return view('doctor.show', [
      'order' => $order,
    ]);
  }

  public function edit(Order $order)
  {
    return view('doctor.edit', [
      'order' => $order,
    ]);
  }

  public function update(Request $request, $queue)
  {
    $order = Order::find($queue);
    $order->update([
      'doctor_id' => auth()->user()->doctor->id,
      'destination' => $request->destination,
    ]);

    return redirect()->route('doctor.orders');
  }

  public function destroy(Order $order)
  {
    $order->delete();
    return redirect()->route('doctor.patients');
  }

  public function analyse()
  {
    $orders = Order::where('doctor_id', auth()->user()->doctor->id)->get();
    return view('doctor.analyse', [
      'orders' => $orders,
    ]);
  }
}
