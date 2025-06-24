<?php

namespace App\Filament\Customer\Resources\OrderResource\Pages;

use App\Filament\Customer\Resources\OrderResource;
use App\Models\Order;
use App\Models\Payment;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class PaymentOrder extends Page implements HasForms
{
    use InteractsWithForms;
    use WithFileUploads;

    protected static string $resource = OrderResource::class;
    protected static string $view = 'filament.customer.resources.order-resource.pages.payment-order';

    public Order $order;
    public ?array $data = [];
    public array $paymentDetails = [];

    public array $paymentMethods = [
        'va' => [
            'name' => 'Virtual Account',
            'instructions' => 'Transfer ke Virtual Account berikut:',
            'account_info' => 'No. VA: 8888801234567890 (Bank ABC)',
            'fields' => []
        ],
        'dana' => [
            'name' => 'DANA',
            'instructions' => 'Transfer ke DANA berikut:',
            'account_info' => 'No. DANA: 081234567890 (DANA Merchant)',
            'fields' => [
                'phone_number' => [
                    'type' => 'text',
                    'label' => 'Nomor Telepon DANA',
                    'rules' => 'required|numeric|digits_between:10,14'
                ]
            ]
        ],
        'gopay' => [
            'name' => 'GoPay',
            'instructions' => 'Transfer ke GoPay berikut:',
            'account_info' => 'No. GoPay: 081234567891 (GoPay Merchant)',
            'fields' => [
                'phone_number' => [
                    'type' => 'text',
                    'label' => 'Nomor Telepon GoPay',
                    'rules' => 'required|numeric|digits_between:10,14'
                ]
            ]
        ]
    ];

    public function mount($record): void
    {
        $this->order = Order::findOrFail($record);
        
        if ($this->order->subtotal == 0) {
            $this->order->subtotal = $this->order->product->price;
            $this->order->tax = $this->order->product->price * 0.05;
            $this->order->total_price = $this->order->subtotal + $this->order->tax;
            $this->order->save();
        }
        
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'va' => 'Virtual Account',
                        'dana' => 'DANA',
                        'gopay' => 'GoPay',
                    ])
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state) {
                        $this->paymentDetails = $this->paymentMethods[$state] ?? [];
                    }),
                
                // Dynamic fields based on payment method
                ...$this->getDynamicFields(),
                
                FileUpload::make('payment_proof')
                    ->label('Bukti Pembayaran')
                    ->directory('payment-proofs')
                    ->image()
                    ->maxSize(2048)
                    ->required()
                    ->downloadable()
                    ->openable(),
            ])
            ->statePath('data');
    }

    protected function getDynamicFields(): array
    {
        $fields = [];
        
        foreach ($this->paymentMethods as $methodKey => $method) {
            foreach ($method['fields'] as $fieldKey => $field) {
                $fields[] = TextInput::make("{$methodKey}_$fieldKey")
                    ->label($field['label'])
                    ->rules($field['rules'])
                    ->visible(fn ($get) => $get('payment_method') === $methodKey);
            }
        }
        
        return $fields;
    }

    public function submitPayment(): void
    {
        $data = $this->form->getState();
        $method = $data['payment_method'];
        
        try {
            // Generate unique VA number if VA method is selected
            $transactionId = match($method) {
                'va' => 'VA' . time() . Str::random(4),
                'dana' => 'DANA' . time(),
                'gopay' => 'GOPAY' . time(),
                default => 'PYMT' . time()
            };

            // Create payment record
            $payment = Payment::create([
                'order_id' => $this->order->id,
                'amount' => $this->order->total_price,
                'method' => $method,
                'status' => 'pending',
                'transaction_id' => $transactionId,
            ]);

            // Save payment proof
            $payment->update(['payment_proof' => $data['payment_proof']]);

            // Update order status
            $this->order->update([
                'status' => 'pending',
                'transaction_status' => 'pending',
            ]);

            Notification::make()
                ->title('Pembayaran Diproses')
                ->body("Silakan lakukan transfer sesuai instruksi {$this->paymentMethods[$method]['name']}")
                ->success()
                ->send();

           // $this->redirect(OrderResource::getUrl('view', ['record' => $this->order->id]));
        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal Memproses Pembayaran')
                ->body($e->getMessage())
                ->danger()
                ->send();
                
            report($e);
        }
    }

    protected function getViewData(): array
    {
        return [
            'order' => $this->order,
            'paymentMethods' => $this->paymentMethods,
            'payment' => $this->order->payment,
        ];
    }
}