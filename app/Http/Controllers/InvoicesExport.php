<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;

class InvoicesExport implements FromView, WithColumnWidths, WithStyles, WithBackgroundColor
{
    protected $orders;
    protected $doctor_id;
    protected $paper_money;
    protected $card;
    protected $doctors_money;

    public function __construct($orders, $doctor_id, $paper_money, $card, $doctors_money)
    {
        $this->orders = $orders;
        $this->doctor_id = $doctor_id ?? null;
        $this->paper_money = $paper_money;
        $this->card = $card;
        $this->doctors_money = $doctors_money ?? 0;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 30,
            'C' => 30,
            'D' => 30,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 20,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
            $this->orders->count() + 2 => ['font' => ['bold' => true]],
        ];
    }
    public function backgroundColor()
    {
        return 'fafafa';

        return new Color(Color::COLOR_BLUE);

        return [
            'fillType'   => Fill::FILL_GRADIENT_LINEAR,
            'startColor' => ['argb' => Color::COLOR_RED],
        ];
    }

    public function view(): View
    {
        return view('cash.export', [
            'orders' => $this->orders,
            'doctor_id' => $this->doctor_id,
            'paper_money' => $this->paper_money,
            'card' => $this->card,
            'doctors_money' => $this->doctors_money ?? 0,
        ]);
    }
}
