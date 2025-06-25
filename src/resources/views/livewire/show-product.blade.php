@php
  use App\Models\PageConfig;
  $config = PageConfig::first();

  use App\Models\Product;
  $products = Product::orderBy('id')->get();
@endphp

<main>
  <section class="section bg-coffee py-5" id="products">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="section-title pt-4 text-white">
            <p class="text-uppercase fw-bold mb-3">Our Collection</p>
            <h1 class="text-white">Featured Products</h1>
            <p>Explore our premium selection of products designed for quality and performance.</p>
          </div>
        </div>

        @foreach ($products as $product)
          <div class="col-lg-4 col-md-6 product-item mb-5">
            <div class="block border-0 rounded shadow-lg h-100 bg-dark text-white">
              @if ($product->image)
                <div class="overflow-hidden rounded-top" style="height: 250px;">
                  <img
                    loading="lazy"
                    decoding="async"
                    src="{{ asset('storage/' . $product->image) }}"
                    alt="{{ $product->name }}"
                    class="img-fluid w-100 h-100 transition-transform"
                    style="object-fit: cover;"
                    onmouseover="this.style.transform='scale(1.05)'"
                    onmouseout="this.style.transform='scale(1)'"
                  >
                </div>
              @else
                <div class="overflow-hidden rounded-top bg-secondary d-flex align-items-center justify-content-center" style="height: 250px;">
                  <span class="text-white">No Image</span>
                </div>
              @endif
              
              <div class="p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h3 class="mb-0 text-white">{{ $product->name }}</h3>
                  <span class="badge bg-{{ $product->is_available ? 'success' : 'danger' }}">
                    {{ $product->is_available ? 'Available' : 'Sold Out' }}
                  </span>
                </div>
                
                <p class="mb-3">{{ Str::limit($product->description, 100) }}</p>
                <div class="d-flex justify-content-between align-items-center">
                  <span class="h5 text-white">Rp. {{ number_format($product->price, 2) }}</span>
                </div>
              </div>
            </div>
          </div>
        @endforeach

      </div>
    </div>
  </section>

  <style>
    .bg-coffee {
      background-color: #4b2e2e !important;
    }
    .text-white {
      color: #ffffff !important;
    }
    .badge.bg-success {
      background-color: #10b981 !important;
    }
    .badge.bg-danger {
      background-color: #ef4444 !important;
    }
  </style>
</main>
