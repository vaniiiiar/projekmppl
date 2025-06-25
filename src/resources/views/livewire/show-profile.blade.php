@php
  use App\Models\PageConfig;
  $config = PageConfig::first();
@endphp

<main>
  <!-- Section: Banner Profil Singkat -->
  <section class="banner position-relative overflow-hidden">
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-lg-6 mb-5 mb-lg-0">
          <div class="block text-center text-lg-start pe-0 pe-xl-5">
            <h1 class="text-capitalize mb-4 text-white">
              Tentang Coffee Okan
            </h1>
            <p class="mb-4 text-white">
              Coffee Okan adalah perusahaan kopi asal Indonesia yang berdiri sejak tahun 2024. Kami menghadirkan cita rasa kopi premium dari biji kopi pilihan nusantara, disajikan dengan standar kualitas internasional untuk pecinta kopi sejati.
            </p>
            <a class="btn btn-primary" href="#company-details"> 
              Lihat Profil Lengkap <span class="ms-2 fas fa-arrow-right"></span>
            </a>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="ps-lg-5 text-center">
            <!-- Logo with white background container -->
            <div class="bg-white p-4 rounded-lg inline-block shadow-lg">
              <img loading="lazy" decoding="async"
                src="{{ asset('front/assets/okan.png') }}"
                alt="Coffee Okan Logo" 
                class="img-fluid"
                style="max-height: 300px; object-fit: contain;">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Section: Profil Perusahaan -->
  <section class="section pt-5" id="company-details">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="section-title pt-4">
            <p class="text-primary text-uppercase fw-bold mb-3">Profil Resmi</p>
            <h1 class="text-white">Identitas Perusahaan</h1>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="card border-0 shadow-sm h-100 bg-transparent text-white">
            <div class="card-body p-4">
              <div class="icon-box bg-primary-soft rounded-circle mb-4">
                <i class="fas fa-building text-primary"></i>
              </div>
              <h3 class="mb-3">Identitas Legal</h3>
              <ul class="list-unstyled">
                <li class="mb-2"><strong>Nama:</strong> Coffee Okan</li>
                <li class="mb-2"><strong>Berdiri:</strong> 2024</li>
                <li class="mb-2"><strong>NIB:</strong> 0123.456.789</li>
                <li><strong>NPWP:</strong> 01.234.567.8-912.345</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mt-4 mt-lg-0">
          <div class="card border-0 shadow-sm h-100 bg-transparent text-white">
            <div class="card-body p-4">
              <div class="icon-box bg-primary-soft rounded-circle mb-4">
                <i class="fas fa-map-marker-alt text-primary"></i>
              </div>
              <h3 class="mb-3">Kantor Pusat</h3>
              <address>
                Jl. Panongan Raya No. 123<br>
                Batam<br>
                Indonesia<br>
                <i class="fas fa-phone mt-2"></i> +62 123 4567 8910
              </address>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-5">
        <div class="col-lg-12">
          <div class="card border-0 shadow bg-transparent text-white">
            <div class="card-body p-5">
              <div class="row">
                <div class="col-lg-6">
                  <h2 class="mb-4">Struktur Manajemen</h2>
                  <div class="table-responsive">
                    <table class="table table-borderless text-white">
                      <tbody>
                        <tr>
                          <th width="40%">Direktur Utama</th>
                          <td>Vania Rahmawati</td>
                        </tr>
                        <tr>
                          <th>Wakil Direktur Utama</th>
                          <td>Andini Larasati</td>
                        </tr>
                        <tr>
                          <th>Manager</th>
                          <td>Ananda Michele</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-lg-6">
                  <h2 class="mb-4">Sertifikasi</h2>
                  <div class="d-flex flex-wrap gap-3">
                    <img src="{{ asset('front/assets/halal-cert.jpeg') }}" alt="Sertifikasi Halal" style="height: 80px;">
                    <img src="{{ asset('front/assets/organic-cert.jpeg') }}" alt="Sertifikasi Organik" style="height: 80px;">
                    <img src="{{ asset('front/assets/iso.jpg') }}" alt="Sertifikasi ISO" style="height: 80px;">
                  </div>
                  <p class="mt-3">Tersertifikasi penuh dengan standar kualitas internasional</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <style>
    .banner, .section, .container, .row, .card, .card-body {
      background-color: transparent !important;
    }
    .icon-box {
      width: 60px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    address {
      font-style: normal;
    }
    h1, h2, h3, p, a, span, th, td, address {
      color: white !important;
    }
    .btn-primary {
      background-color: #d97706;
      border-color: #d97706;
    }
    .btn-primary:hover {
      background-color: #b45309;
      border-color: #b45309;
    }
  </style>
</main>
