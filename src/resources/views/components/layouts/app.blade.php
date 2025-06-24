<!DOCTYPE html>
<html lang="en-us">
<head>
    @include('components.partials.head')
    @livewireStyles
</head>
<body>
    @include('components.partials.nav')

    {{-- Slot konten --}}
    {{ $slot }}



    @livewireScripts
    
    
</body>
@include('components.partials.script')
</html>


    home-blade
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Caffe Okan - Specialty coffee with Indonesian heritage" />
        <meta name="author" content="" />
        <title>Caffe Okan - Premium Coffee Experience</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />

        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet" />
        
        <!-- Font Awesome for social icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('home-blade/css/styles.css') }}" rel="stylesheet" />
        
        <style>
            .social-icons {
                display: flex;
                justify-content: center;
                gap: 15px;
                margin-top: 20px;
            }
            .social-icons a {
                color: #f4623a;
                font-size: 1.5rem;
                transition: all 0.3s;
            }
            .social-icons a:hover {
                color: #c34e2e;
                transform: translateY(-3px);
            }
            .intro-text {
                background-color: rgba(47, 23, 15, 0.85);
            }
            .btn-primary {
                background-color: #f4623a;
                border-color: #f4623a;
            }
            .btn-primary:hover {
                background-color: #c34e2e;
                border-color: #c34e2e;
            }
        </style>
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
            <div class="container">
                <a class="navbar-brand text-uppercase fw-bold d-lg-none" href="index.html">Caffe Okan</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                </div>
            </div>
        </nav>

        <section class="page-section clearfix">
            <div class="container">
                <div class="intro">
                    <img class="intro-img img-fluid mb-3 mb-lg-0 rounded" src="{{ asset('assets/img/intro.jpg') }}" alt="Caffe Okan interior with coffee bar" />
                  <div class="intro-text left-0 text-center bg-faded p-5 rounded">
    <h2 class="section-heading mb-4 text-white">
        <span class="section-heading-upper text-white">Indonesian Coffee Heritage</span>
        <span class="section-heading-lower text-white">Caffe Okan</span>
    </h2>
    <p class="mb-3 text-white">At Caffe Okan, we bring you...</p>
    <p class="mb-3" style="color: white;">At Caffe Okan, we bring you the finest Indonesian coffee beans, carefully selected from the volcanic highlands of Java, Sumatra, and Bali. Our skilled baristas craft each cup with precision, honoring both traditional Indonesian brewing methods and modern coffee artistry.</p>
                        
                        <div class="social-icons">
                            <a href="https://www.instagram.com/caffeokan" target="_blank"><i class="fab fa-instagram"></i></a>
                            <a href="https://www.facebook.com/caffeokan" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://twitter.com/caffeokan" target="_blank"><i class="fab fa-twitter"></i></a>
                            <a href="https://wa.me/6281234567890" target="_blank"><i class="fab fa-whatsapp"></i></a>
                        </div>
                        
                        <div class="intro-button mx-auto mt-4">
                            <a class="btn btn-primary btn-xl" href="#!">Visit Us Today!</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="page-section cta">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 mx-auto">
                        <div class="cta-inner bg-faded text-center rounded">
                            <h2 class="section-heading mb-4">
                                <span class="section-heading-upper">Our Coffee Philosophy</span>
                                <span class="section-heading-lower">The Okan Way</span>
                            </h2>
                            <p class="mb-0">We're passionate about creating an authentic coffee experience that bridges Indonesian tradition with contemporary café culture. From single-origin pour overs to our signature "Kopi Okan" blend, each offering tells a story of Indonesia's rich coffee heritage. Our commitment extends beyond the cup - we work directly with smallholder farmers to ensure sustainable practices and fair compensation.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="footer text-faded text-center py-5">
            <div class="container">
                <div class="social-icons mb-3">
                    <a href="https://www.instagram.com/caffeokan" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/caffeokan" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com/caffeokan" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="https://wa.me/6281234567890" target="_blank"><i class="fab fa-whatsapp"></i></a>
                </div>
                <p class="m-0 small">&copy; Caffe Okan 2023. All Rights Reserved.</p>
                <p class="m-0 small mt-2">Jl. Coffee Heritage No. 123, Bandung, Indonesia</p>
            </div>
        </footer>

            @include('components.partials.bottom')

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('js/scripts.js') }}"></script>
    </body>
    </html>

