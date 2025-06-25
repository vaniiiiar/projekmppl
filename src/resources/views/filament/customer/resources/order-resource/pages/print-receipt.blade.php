<x-filament::page>
    @php
        $order = $this->order;
        $coffeeShopName = "Okan Coffee Shop";
        $coffeeShopAddress = "Jl. Panongan Raya No. 123, Batam";
        $coffeeShopPhone = "(+62) 123 4567 8910";
    @endphp

    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-900 p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 print:border-none text-gray-800 dark:text-gray-200">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold">{{ $coffeeShopName }}</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $coffeeShopAddress }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $coffeeShopPhone }}</p>
            <p class="text-sm mt-2 text-gray-500 dark:text-gray-400">No. Transaksi: <span class="font-semibold">#{{ $order->id }}</span></p>
            <p class="text-sm text-gray-400 dark:text-gray-500">
                Tanggal Cetak: {{ now()->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }}
            </p>
        </div>

        <div class="space-y-4 text-sm">
            <div class="border-b pb-3 border-gray-200 dark:border-gray-700">
                <h2 class="text-base font-semibold mb-2">Detail Pesanan</h2>

                <div class="flex justify-between border-b py-2 border-gray-200 dark:border-gray-700">
                    <span>Tipe Pesanan:</span>
                    <span>{{ $order->order_type === 'dine_in' ? 'Makan di Tempat' : 'Bawa Pulang' }}</span>
                </div>

                @if($order->order_type === 'dine_in' && $order->table_number)
                    <div class="flex justify-between border-b py-2 border-gray-200 dark:border-gray-700">
                        <span>Nomor Meja:</span>
                        <span>{{ $order->table_number }}</span>
                    </div>
                @endif

                <div class="flex justify-between border-b py-2 border-gray-200 dark:border-gray-700">
                    <span>Produk:</span>
                    <span>{{ $order->product->name }}</span>
                </div>

                @if($order->product->description)
                    <div class="flex justify-between border-b py-2 border-gray-200 dark:border-gray-700">
                        <span>Catatan:</span>
                        <span>{{ $order->product->description }}</span>
                    </div>
                @endif

                <div class="flex justify-between border-b py-2 border-gray-200 dark:border-gray-700">
                    <span>Jumlah:</span>
                    <span>1</span>
                </div>
            </div>

            <div class="border-b pb-3 border-gray-200 dark:border-gray-700">
                <h2 class="text-base font-semibold mb-2">Biaya</h2>
                <div class="flex justify-between border-b py-2 border-gray-200 dark:border-gray-700">
                    <span>Harga Satuan:</span>
                    <span>Rp {{ number_format($order->product->price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between border-b py-2 border-gray-200 dark:border-gray-700">
                    <span>Subtotal:</span>
                    <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between border-b py-2 border-gray-200 dark:border-gray-700">
                    <span>Pajak (5%):</span>
                    <span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-bold text-lg pt-2 border-t border-gray-300 dark:border-gray-600">
                    <span>Total Bayar:</span>
                    <span class="text-blue-600 dark:text-blue-400">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2 text-sm">
                <div>
                    <h3 class="font-semibold">Status Pesanan</h3>
                    <p class="{{ $order->status === 'acc' ? 'text-green-600 font-bold' : ($order->status === 'decline' ? 'text-red-600 font-bold' : 'text-gray-500') }}">
                        @if($order->status === 'acc')
                            Diterima
                        @elseif($order->status === 'decline')
                            Ditolak
                        @else
                            Menunggu
                        @endif
                    </p>
                </div>
                <div>
                    <h3 class="font-semibold">Status Pembayaran</h3>
                    <p class="{{ $order->transaction_status === 'confirmed' ? 'text-green-600 font-bold' : 'text-gray-500' }}">
                        {{ $order->transaction_status === 'confirmed' ? 'Terkonfirmasi' : 'Menunggu' }}
                    </p>
                </div>
            </div>

            @if($order->payment_proof && $order->transaction_status === 'pending')
                <p class="text-xs italic text-gray-500 mt-2">
                    * Bukti pembayaran telah diunggah, menunggu konfirmasi.
                </p>
            @endif

            <div class="text-center text-xs mt-6 border-t pt-4 border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400">
                <p>Terima kasih telah berkunjung ke {{ $coffeeShopName }}.</p>
                <p>Struk ini berlaku sebagai bukti pembayaran resmi.</p>
            </div>
        </div>

        <div class="text-center mt-8 print:hidden">
            <button onclick="window.print()" class="px-5 py-2 bg-blue-600 text-black dark:text-white font-semibold rounded-md hover:bg-blue-700 transition">
                Cetak Struk
            </button>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden !important;
            }
            .max-w-4xl, .max-w-4xl * {
                visibility: visible !important;
            }
            .max-w-4xl {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                margin: 0 !important;
                background: white !important;
                color: black !important;
            }
            button {
                display: none !important;
            }
            .text-gray-500, .text-gray-400, .text-gray-700, .text-gray-800,
            .text-blue-600, .bg-blue-600,
            .text-green-600, .text-red-600 {
                color: black !important;
                background: white !important;
            }
            .border-gray-200 {
                border-color: #e5e7eb !important;
            }
        }
    </style>
</x-filament::page>
