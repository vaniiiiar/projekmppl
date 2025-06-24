@php
  use App\Models\PageConfig;
  $about = PageConfig::first();
@endphp

<main>
  <section class="banner bg-amber-800 position-relative overflow-hidden"> <!-- Changed bg-tertiary to bg-amber-800 -->
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-lg-6 mb-5 mb-lg-0">
          <div class="block text-center text-lg-start pe-0 pe-xl-5">
            <h1 class="text-capitalize mb-4 text-white">Tentang Kami</h1> <!-- Added text-white -->
            <p class="mb-4 text-white">{{ $about->description ?? 'Temukan cerita kami dan apa yang membuat kami berbeda' }}</p> <!-- Added text-white -->
            <a href="#about-content" class="btn btn-primary">
              Pelajari Lebih Lanjut <span style="font-size: 14px;" class="ms-2 fas fa-arrow-right"></span>
            </a>
          </div>
        </div>
       <div class="col-lg-6">
  <div class="ps-lg-5 text-center">
    @if($about?->image)
      <!-- White background container for the logo -->
      <div class="bg-white p-4 rounded-lg d-inline-block shadow">
        <img loading="lazy" decoding="async"
          src="{{ asset('storage/' . $about->image) }}"
          alt="Logo Okan" 
          class="img-fluid"
          style="max-height: 300px; width: auto; object-fit: contain;">
      </div>
    @else
      <div class="bg-white p-4 rounded-lg d-inline-block shadow">
        <img loading="lazy" decoding="async"
          src="https://via.placeholder.com/300x150?text=Okan+Logo"
          alt="Logo Okan" 
          class="img-fluid"
          style="max-height: 300px; width: auto; object-fit: contain;">
      </div>
    @endif
  </div>
</div>
  </section>

<section class="section" id="about-content">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="section-title pt-4">
            <p class="text-primary text-uppercase fw-bold mb-3">Cerita Kami</p>
            <h1 class="text-white">Siapa Kami</h1>
            <p class="text-white">Pelajari sejarah perusahaan, nilai-nilai, dan tim di balik kesuksesan kami.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
              <div class="icon-box bg-primary-soft rounded-circle mb-4">
                <i class="fas fa-history text-primary fs-3"></i>
              </div>
              <h3 class="mb-3">Sejarah Kami</h3>
              <p class="mb-0">{{ $about->history ?? 'Didirikan dengan visi untuk merevolusi industri, kami telah tumbuh secara stabil selama bertahun-tahun.' }}</p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
              <div class="icon-box bg-primary-soft rounded-circle mb-4">
                <i class="fas fa-bullseye text-primary fs-3"></i>
              </div>
              <h3 class="mb-3">Misi Kami</h3>
              <p class="mb-0">{{ $about->mission ?? 'Memberikan produk dan layanan luar biasa yang melebihi harapan pelanggan.' }}</p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mt-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
              <div class="icon-box bg-primary-soft rounded-circle mb-4">
                <i class="fas fa-eye text-primary fs-3"></i>
              </div>
              <h3 class="mb-3">Visi Kami</h3>
              <p class="mb-0">{{ $about->vision ?? 'Menjadi pemimpin global di industri kami melalui inovasi dan keunggulan.' }}</p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mt-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
              <div class="icon-box bg-primary-soft rounded-circle mb-4">
                <i class="fas fa-users text-primary fs-3"></i>
              </div>
              <h3 class="mb-3">Tim Kami</h3>
              <p class="mb-0">{{ $about->team_description ?? 'Kelompok profesional yang beragam yang berdedikasi untuk memberikan hasil terbaik.' }}</p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mt-4">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
              <div class="icon-box bg-primary-soft rounded-circle mb-4">
                <i class="fas fa-medal text-primary fs-3"></i>
              </div>
              <h3 class="mb-3">Nilai Kami</h3>
              <p class="mb-0">{{ $about->values ?? 'Integritas, inovasi, dan fokus pada pelanggan mendorong segala yang kami lakukan.' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <style>
    .icon-box {
      width: 60px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
  </style>

</main>