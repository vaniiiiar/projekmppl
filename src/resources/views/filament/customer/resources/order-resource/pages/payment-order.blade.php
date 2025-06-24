<x-filament-panels::page>
    <div class="space-y-6">
        <h2 class="text-xl font-bold">Pembayaran Pesanan #{{ $order->id }}</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-medium text-lg mb-4">Ringkasan Pesanan</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span>Produk:</span>
                        <span class="font-medium">{{ $order->product->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Harga:</span>
                        <span>Rp {{ number_format($order->product->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Pajak (5%):</span>
                        <span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-gray-200 my-2"></div>
                    <div class="flex justify-between text-lg font-bold">
                        <span>Total:</span>
                        <span class="text-primary-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Payment Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-medium text-lg mb-4">Status Pembayaran</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Status Pesanan</p>
                        <p @class([
                            'font-medium',
                            'text-yellow-500' => $order->status === 'pending',
                            'text-green-500' => $order->status === 'acc',
                            'text-red-500' => $order->status === 'decline',
                        ])>
                            {{ strtoupper($order->status) }}
                        </p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Status Pembayaran</p>
                        <p @class([
                            'font-medium',
                            'text-yellow-500' => $order->transaction_status === 'pending',
                            'text-green-500' => $order->transaction_status === 'confirmed',
                        ])>
                            {{ strtoupper($order->transaction_status) }}
                        </p>
                    </div>
                    
                    @if($payment)
                        <div>
                            <p class="text-sm text-gray-500">Metode Pembayaran</p>
                            <p class="font-medium">{{ $paymentMethods[$payment->method]['name'] ?? $payment->method }}</p>
                        </div>
                        @if($payment->transaction_id)
                            <div>
                                <p class="text-sm text-gray-500">Nomor Transaksi</p>
                                <p class="font-medium">{{ $payment->transaction_id }}</p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Payment Form -->
        @if(!$payment || $payment->status === 'failed')
            <div class="bg-white rounded-lg shadow p-6 mt-6">
                <h3 class="font-medium text-lg mb-4">Pilih Metode Pembayaran</h3>
                
                <form wire:submit.prevent="submitPayment">
                    {{ $this->form }}
                    
                    <!-- Payment Instructions -->
                    @if($paymentDetails)
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium mb-2">{{ $paymentDetails['instructions'] }}</h4>
                            <div class="bg-white p-3 rounded border border-gray-200">
                                <p class="font-semibold">{{ $paymentDetails['account_info'] }}</p>
                                <p class="mt-2 text-sm text-gray-600">Jumlah Transfer: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>
                            
                            @if(($this->data['payment_method'] ?? null) === 'va')
                                <div class="mt-3 text-sm text-gray-600">
                                    <p>Virtual Account ini berlaku hingga 24 jam setelah pemesanan</p>
                                </div>
                            @endif
                            
                            @if(in_array($this->data['payment_method'] ?? null, ['dana', 'gopay']))
                                <div class="mt-3 text-sm text-gray-600">
                                    <p>Pastikan nomor telepon yang Anda masukkan sudah terdaftar di {{ $paymentDetails['name'] }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                    
                    <div class="flex justify-end mt-6">
                        <x-filament::button type="submit" class="bg-primary-600 hover:bg-primary-500">
                            <x-heroicon-s-credit-card class="w-5 h-5 mr-2" />
                            Konfirmasi Pembayaran
                        </x-filament::button>
                    </div>
                </form>
            </div>
        @endif
        
        <!-- Payment Status Messages -->
        @if($payment)
            @if($payment->status === 'pending')
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-heroicon-s-clock class="h-5 w-5 text-yellow-400" />
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Pembayaran Anda dengan {{ $paymentMethods[$payment->method]['name'] }} sedang diproses.
                                @if($payment->payment_proof)
                                    <a href="{{ asset('storage/'.$payment->payment_proof) }}" target="_blank" class="text-yellow-600 hover:underline ml-2">
                                        Lihat Bukti Transfer
                                    </a>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($payment->status === 'completed')
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mt-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-heroicon-s-check-circle class="h-5 w-5 text-green-400" />
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">
                                Pembayaran sebesar <span class="font-bold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span> 
                                dengan {{ $paymentMethods[$payment->method]['name'] }} telah berhasil pada {{ $payment->updated_at->format('d M Y H:i') }}.
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($payment->status === 'failed')
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mt-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-heroicon-s-x-circle class="h-5 w-5 text-red-400" />
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                Pembayaran dengan {{ $paymentMethods[$payment->method]['name'] }} gagal. Silakan coba metode pembayaran lain.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
</x-filament-panels::page>