<?php

namespace App\Filament\Customer\Resources\OrderResource\Pages;

use App\Filament\Customer\Resources\OrderResource;
use Filament\Resources\Pages\Page;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;


class PrintReceipt extends Page
{
    protected static string $resource = OrderResource::class;
    protected static string $view = 'filament.customer.resources.order-resource.pages.print-receipt';
    
    public Order $order;
    
    public function mount($record)
    {
        $this->order = Order::findOrFail($record);
    }

    public function getViewData(): array
    {
        return [
            'record' => $this->order,
        ];
    }
    
}