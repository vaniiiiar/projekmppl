<?php

namespace App\Filament\Customer\Resources\OrderResource\Pages;

use App\Filament\Customer\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
    
    protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('payment', ['record' => $this->record->id]);
}
    
    protected function afterCreate(): void
    {
        // Set status awal
        // $this->record->update([
        //     'status' => 'pending',
        //     'transaction_status' => 'unpaid',
        // ]);
    }
}