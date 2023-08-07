<?php

namespace App\Http\Controllers;

use App\Models\Debts;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\PaymentMethods;
use App\Models\Doctor;
use App\Models\HybridPaids;
use App\Models\Order;
use Carbon\Carbon;
use DateTime;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class CashboxController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        $payment_methods = PaymentMethods::all();
        return view('cash.index', [
            'orders' => $orders,
            'payment_methods' => $payment_methods
        ]);
    }

    public function confirmation(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->paid_status_id = 1;
        $order->payment_method_id = $request->payment_method_id;
        if ($request->payment_method_id == 3) {
            HybridPaids::create([
                'order_id' => $order->id,
                'payment_method_id' => 1,
                'amount' => $request->amount1
            ]);
            HybridPaids::create([
                'order_id' => $order->id,
                'payment_method_id' => 2,
                'amount' => $request->amount2
            ]);
        }
        $order->cashier_id = auth()->user()->cashier->id;
        $order->save();
        $patient = $order->patient;
        $orders = [$order];
        $total_price = 0;
        foreach ($orders as $order) {
            $total_price += $order->price;
        }
        $pdf = PDF::loadView('cash.invoice', [
            'orders' => $orders,
            'patient' => $patient,
            'total_price' => $total_price
        ]);

        return $pdf->stream('invoice.pdf');
    }

    public function invoice(Request $request, $id)
    {
        $currentDate = Carbon::now()->toDateString();
        if ((new DateTime($request->created_at))->format('Y-m-d') == $currentDate) {
            $orders = Order::where('id', $id)->where('paid_status_id', 1)->whereDate('created_at', $currentDate)->get();
            $total_price = 0;
            foreach ($orders as $order) {
                $total_price += $order->price;
            }
            $patient = $orders[0]->patient;
            $pdf = PDF::loadView('cash.invoice', [
                'orders' => $orders,
                'patient' => $patient,
                'total_price' => $total_price
            ]);

            return $pdf->stream('invoice.pdf');
        } else {
            $orders = Order::where('id', $id)->where('paid_status_id', 1)->whereDate('created_at', (new DateTime($request->created_at))->format('Y-m-d'))->get();
            $total_price = 0;
            foreach ($orders as $order) {
                $total_price += $order->price;
            }
            $patient = $orders[0]->patient;
            $pdf = PDF::loadView('cash.invoice', [
                'orders' => $orders,
                'patient' => $patient,
                'total_price' => $total_price
            ]);
            return $pdf->stream('invoice.pdf');
        }
    }

    public function return($id)
    {
        $order = Order::findOrFail($id);
        $order->paid_status_id = 3;
        $order->hybrid_paids()->delete();
        $order->debts()->delete();
        $order->save();
        return redirect()->route('cash.index');
    }

    public function analyse()
    {
        $sevenDaysAgo = Carbon::now()->subDays(7);
        $total_sum = Order::where('created_at', '>=', $sevenDaysAgo)->where('paid_status_id', 1)->sum('price');
        $returned_sum = Order::where('created_at', '>=', $sevenDaysAgo)->where('paid_status_id', 3)->sum('price');
        $ordersByDay = Order::select(
            DB::raw('DATE(created_at) as order_date'),
            DB::raw('COUNT(*) as total_orders'),
            DB::raw('SUM(price) as total_amount_received')
        )
            ->where('created_at', '>=', $sevenDaysAgo)
            ->where('paid_status_id', 1)
            ->groupBy('order_date')
            ->orderBy('order_date', 'ASC')
            ->get();
        $canceledOrdersByDay = Order::select(
            DB::raw('DATE(created_at) as order_date'),
            DB::raw('COUNT(*) as total_orders'),
            DB::raw('SUM(price) as total_amount_received')
        )
            ->where('created_at', '>=', $sevenDaysAgo)
            ->where('paid_status_id', 3)
            ->groupBy('order_date')
            ->orderBy('order_date', 'ASC')
            ->get();
        return view('cash.analyse', [
            'ordersByDay' => $ordersByDay,
            'total_sum' => $total_sum,
            'returned_sum' => $returned_sum,
            'canceledOrdersByDay' => $canceledOrdersByDay,
        ]);
    }

    public function doctor()
    {
        $doctors = Doctor::all();
        $orders = Order::whereIn('paid_status_id', [1, 4])
            ->where('doctor_id', '!=', NULL)
            ->get();
        $paper_money = Order::where('paid_status_id', 1)
            ->where('payment_method_id', 1)
            ->where('doctor_id', '!=', NULL)
            ->sum('price');
        $card = Order::where('paid_status_id', 1)
            ->where('payment_method_id', 2)
            ->where('doctor_id', '!=', NULL)
            ->sum('price');
        // hybride
        $hybrid_padided_orders = HybridPaids::all();
        $hybrid_paper_money = 0;
        $hybrid_card = 0;
        foreach ($hybrid_padided_orders as $hybrid_padided_order) {
            if ($hybrid_padided_order->order->doctor_id != NULL) {
                if ($hybrid_padided_order->payment_method_id == 1) {
                    $hybrid_paper_money += $hybrid_padided_order->amount;
                } elseif ($hybrid_padided_order->payment_method_id == 2) {
                    $hybrid_card += $hybrid_padided_order->amount;
                }
            }
        }
        // debts
        $debts = Debts::all();
        $debts_paper_money = 0;
        $debts_card = 0;
        foreach ($debts as $debt) {
            if ($debt->order->doctor_id != NULL) {
                if ($debt->payment_method_id == 1) {
                    $debts_paper_money += $debt->paid_amount;
                } elseif ($debt->payment_method_id == 2) {
                    $debts_card += $debt->paid_amount;
                }
            }
        }
        // dd($debts_paper_money);
        return view('cash.show', [
            'doctors' => $doctors,
            'doctor_id' => false,
            'orders' => $orders,
            'paper_money' => $paper_money + $hybrid_paper_money + $debts_paper_money,
            'card' => $card + $hybrid_card + $debts_card,
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
            $orders = Order::whereIn('paid_status_id', [1, 4])->where('doctor_id', $request->doctor_id)->whereBetween('created_at', [$request->start_date, $end_date])->get();
            $paper_money = Order::where('paid_status_id', 1)->where('doctor_id', $request->doctor_id)->whereBetween('created_at', [$request->start_date, $end_date])->where('payment_method_id', 1)->sum('price');
            $card = Order::where('paid_status_id', 1)->where('doctor_id', $request->doctor_id)->whereBetween('created_at', [$request->start_date, $end_date])->where('payment_method_id', 2)->sum('price');
            // hybride
            $hybrid_paper_money = 0;
            $hybrid_card = 0;
            foreach ($orders as $order) {
                $hybrid_padided_orders = HybridPaids::where('order_id', $order->id)->get();
                foreach ($hybrid_padided_orders as $hybrid_padided_order) {
                    if ($hybrid_padided_order->payment_method_id == 1) {
                        $hybrid_paper_money += $hybrid_padided_order->amount;
                    } elseif ($hybrid_padided_order->payment_method_id == 2) {
                        $hybrid_card += $hybrid_padided_order->amount;
                    }
                }
            }
            // DEBTS
            $debts_paper_money = 0;
            $debts_card = 0;
            foreach ($orders as $order) {
                $debt_paided_orders = Debts::where('order_id', $order->id)->get();
                foreach ($debt_paided_orders as $debt_paided_order) {
                    if ($debt_paided_order->payment_method_id == 1) {
                        $debts_paper_money += $debt_paided_order->paid_amount;
                    } elseif ($debt_paided_order->payment_method_id == 2) {
                        $debts_card += $debt_paided_order->paid_amount;
                    }
                }
            }
            $doctors_money = (($paper_money + $hybrid_paper_money + $card + $hybrid_card + $debts_paper_money + $debts_card) * $doctor->doctors_percent) / 100;

            return view('cash.show', [
                'doctors' => $doctors,
                'doctor' => $doctor,
                'doctor_id' => $request->doctor_id,
                'orders' => $orders,
                'paper_money' => $paper_money + $hybrid_paper_money + $debts_paper_money,
                'card' => $card + $hybrid_card + $debts_card,
                'doctors_money' => $doctors_money ?? false,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);
        } else {
            $doctors = Doctor::all();
            $orders = Order::whereIn('paid_status_id', [1, 4])->where('doctor_id', '!=', NULL)->whereBetween('created_at', [$request->start_date, $end_date])->get();
            $paper_money = Order::where('paid_status_id', 1)->where('payment_method_id', 1)->sum('price');
            $card = Order::where('paid_status_id', 1)->where('payment_method_id', 2)->sum('price');
            // hybride
            $hybrid_paper_money = 0;
            $hybrid_card = 0;
            foreach ($orders as $order) {
                $hybrid_padided_orders = HybridPaids::where('order_id', $order->id)->whereBetween('created_at', [$request->start_date, $end_date])->get();
                foreach ($hybrid_padided_orders as $hybrid_padided_order) {
                    if ($hybrid_padided_order->payment_method_id == 1) {
                        $hybrid_paper_money += $hybrid_padided_order->amount;
                    } elseif ($hybrid_padided_order->payment_method_id == 2) {
                        $hybrid_card += $hybrid_padided_order->amount;
                    }
                }
            }
            // DEBTS
            $debts_paper_money = 0;
            $debts_card = 0;
            foreach ($orders as $order) {
                $debt_paided_orders = Debts::where('order_id', $order->id)->whereBetween('created_at', [$request->start_date, $end_date])->get();
                foreach ($debt_paided_orders as $debt_paided_order) {
                    if ($debt_paided_order->payment_method_id == 1) {
                        $debts_paper_money += $debt_paided_order->paid_amount;
                    } elseif ($debt_paided_order->payment_method_id == 2) {
                        $debts_card += $debt_paided_order->paid_amount;
                    }
                }
            }
            return view('cash.show', [
                'doctors' => $doctors,
                'doctor_id' => false,
                'orders' => $orders,
                'paper_money' => $paper_money + $hybrid_paper_money + $debts_paper_money,
                'card' => $card + $hybrid_card + $debts_card,
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
            $orders = Order::whereIn('paid_status_id', [1, 4])->where('doctor_id', $request->doctor_id ?? '!=', NULL)->whereBetween('created_at', [$request->start_date, $end_date])->get();
            $paper_money = Order::where('paid_status_id', 1)->where('doctor_id', $request->doctor_id ?? '!=', NULL)->whereBetween('created_at', [$request->start_date, $end_date])->where('payment_method_id', 1)->sum('price');
            $card = Order::where('paid_status_id', 1)->where('doctor_id', $request->doctor_id ?? '!=', NULL)->whereBetween('created_at', [$request->start_date, $end_date])->where('payment_method_id', 2)->sum('price');
            // hybride
            $hybrid_paper_money = 0;
            $hybrid_card = 0;
            foreach ($orders as $order) {
                $hybrid_padided_orders = HybridPaids::where('order_id', $order->id)->whereBetween('created_at', [$request->start_date, $end_date])->get();
                foreach ($hybrid_padided_orders as $hybrid_padided_order) {
                    if ($hybrid_padided_order->payment_method_id == 1) {
                        $hybrid_paper_money += $hybrid_padided_order->amount;
                    } elseif ($hybrid_padided_order->payment_method_id == 2) {
                        $hybrid_card += $hybrid_padided_order->amount;
                    }
                }
            }
            // DEBTS
            $debts_paper_money = 0;
            $debts_card = 0;
            foreach ($orders as $order) {
                $debt_paided_orders = Debts::where('order_id', $order->id)->whereBetween('created_at', [$request->start_date, $end_date])->get();
                foreach ($debt_paided_orders as $debt_paided_order) {
                    if ($debt_paided_order->payment_method_id == 1) {
                        $debts_paper_money += $debt_paided_order->paid_amount;
                    } elseif ($debt_paided_order->payment_method_id == 2) {
                        $debts_card += $debt_paided_order->paid_amount;
                    }
                }
            }
        } else {
            $orders = Order::whereIn('paid_status_id', [1, 4])->where('doctor_id', $request->doctor_id ?? '!=', NULL)->get();
            $paper_money = Order::where('paid_status_id', 1)->where('doctor_id', $request->doctor_id ?? '!=', NULL)->where('payment_method_id', 1)->sum('price');
            $card = Order::where('paid_status_id', 1)->where('doctor_id', $request->doctor_id ?? '!=', NULL)->where('payment_method_id', 2)->sum('price');
            // hybride
            $hybrid_paper_money = 0;
            $hybrid_card = 0;
            foreach ($orders as $order) {
                $hybrid_padided_orders = HybridPaids::where('order_id', $order->id)->get();
                foreach ($hybrid_padided_orders as $hybrid_padided_order) {
                    if ($hybrid_padided_order->payment_method_id == 1) {
                        $hybrid_paper_money += $hybrid_padided_order->amount;
                    } elseif ($hybrid_padided_order->payment_method_id == 2) {
                        $hybrid_card += $hybrid_padided_order->amount;
                    }
                }
            }
            // DEBTS
            $debts_paper_money = 0;
            $debts_card = 0;
            foreach ($orders as $order) {
                $debt_paided_orders = Debts::where('order_id', $order->id)->get();
                foreach ($debt_paided_orders as $debt_paided_order) {
                    if ($debt_paided_order->payment_method_id == 1) {
                        $debts_paper_money += $debt_paided_order->paid_amount;
                    } elseif ($debt_paided_order->payment_method_id == 2) {
                        $debts_card += $debt_paided_order->paid_amount;
                    }
                }
            }
        }
        $doctor = Doctor::find($request->doctor_id);
        if ($doctor) {
            $doctors_money = (($paper_money + $hybrid_paper_money + $card + $hybrid_card + $debts_paper_money + $debts_card) * $doctor->doctors_percent) / 100;
        }
        return Excel::download(new InvoicesExport(
            $orders,
            $request->doctor_id,
            $paper_money + $hybrid_paper_money + $debts_paper_money,
            $card + $hybrid_card + $debts_card,
            $doctors_money ?? null
        ), 'invoices.xlsx');
    }

    public function debts()
    {
        $doctors = Doctor::all();
        $orders = Order::whereIn('paid_status_id', [2, 4])->get();
        $payment_methods = PaymentMethods::all();
        return view('cash.debts', [
            'doctors' => $doctors,
            'orders' => $orders,
            'payment_methods' => $payment_methods
        ]);
    }

    public function debts_confirmation(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        if (count($order->debts) == 0) {
            $new_debt = Debts::create([
                'order_id' => $request->order_id,
                'payment_method_id' => $request->payment_method_id,
                'paid_amount' => $request->amount,
                'owed_amount' => $order->price - $request->amount,
            ]);
            $order->update([
                'paid_status_id' => 4,
                'payment_method_id' => $request->payment_method_id,
                'cashier_id' => auth()->user()->cashier->id,
            ]);
        }
        if (count($order->debts) == 1) {
            $debt = Debts::where('order_id', $request->order_id)->first();
            $new_debt = Debts::create([
                'order_id' => $request->order_id,
                'payment_method_id' => $request->payment_method_id,
                'paid_amount' => $request->amount,
                'owed_amount' =>  $debt->owed_amount - $debt->amount - $request->amount,
            ]);
            if ($new_debt->owed_amount == 0) {
                $order->update([
                    'paid_status_id' => 4,
                ]);
            }
            $order->update([
                'paid_status_id' => 2,
                'payment_method_id' => $request->payment_method_id == $debt->payment_method_id ? $request->payment_method_id : 3,
                'cashier_id' => auth()->user()->cashier->id,
            ]);
        }
        return redirect()->route('cash.debts');
    }
}
