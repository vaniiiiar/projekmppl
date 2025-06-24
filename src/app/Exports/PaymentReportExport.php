<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PaymentReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Payment::with([
            'order.user',
            'order.product'
        ])
        ->where('status', 'completed')
        ->when($this->startDate, fn($q) => $q->where('created_at', '>=', $this->startDate))
        ->when($this->endDate, fn($q) => $q->where('created_at', '<=', $this->endDate))
        ->latest('created_at')
        ->get();
    }

     public function map($payment): array
    {
        $order = $payment->order;
        
        // Format ordered products
        $products = $order->orderItems->map(function ($item) {
            return sprintf(
                "%s (Rp %s)",
                $item->product->name,
                number_format($item->price)
            );
        })->implode("\n");

        return [
            $order->id,
            $order->user->name ?? 'N/A',
            $order->product->name ?? 'N/A',
            $payment->method ?? 'N/A',
            $order->total_price ?? 'N/A',
            $payment->created_at->format('d/m/Y H:i'),
        ];
    }



        protected function formatPaymentMethod($method)
    {
        $formatted = str_replace('_', ' ', $method);
        
        return match(strtolower($method)) {
            'va' => 'VA',
            'dana' => 'Dana',
            'gopay' => 'Gopay',
            default => ucfirst($formatted)
        };
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Customer Name',
            'Products Ordered',
            'Payment Method',
            'Total Price',
            'Payment Date',
        ];
    }


       public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '3490DC']
                ]
            ],
            'A:G' => ['alignment' => ['wrapText' => true]],
            'E' => ['alignment' => ['horizontal' => 'right']],
            'D' => ['alignment' => ['wrapText' => true]]
        ];
    }
}