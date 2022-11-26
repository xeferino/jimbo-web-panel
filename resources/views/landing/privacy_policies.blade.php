<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Jimbo Sorteos - Terminos y Condiciones</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('landing/img/logo-icon.png')}}" rel="icon">
  <link href="{{ asset('landing/img/logo-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('landing/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{ asset('landing/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('landing/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ asset('landing/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{ asset('landing/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{ asset('landing/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('landing/css/style.css')}}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Appland - v4.9.1
  * Template URL: https://bootstrapmade.com/free-bootstrap-app-landing-page-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top  header-transparent ">
    <div class="container breadcrumbs-inner d-flex align-items-center justify-content-between">

      <div class="logo">
        <a href="{{route('landing.home')}}"><img src="{{asset('landing/img/logo-texto.png')}}" alt="" class="img-fluid"></a>
      </div>
      <ol>
        <li><a href="{{route('landing.home')}}">Home</a></li>
        <li>Politicas de Privacidad</li>
      </ol>
    </div>
  </header><!-- End Header -->

  <main id="main">
       <!-- ======= Frequently Asked Questions Section ======= -->
       <section id="faq" class="faq section-bg">
        <div class="container" data-aos="fade-up">
            {!!$privacy_policies!!}
        </div>
      </section>
     <!-- End Frequently Asked Questions Section -->
  </main><!-- End #main -->


  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-newsletter">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <h4>Suscr&iacute;bete</h4>
            <p>Recibe boletines y promociones de nuestros productos</p>
            <form action="" method="post">
              <input type="email" name="email"><input type="submit" value="Subscribe">
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-4 col-md-4 footer-contact">
            <h3>Jimbo Sorteos</h3>
            <p>
              Thumbes, TC 535022. Peru <br><br>
              <strong>Telefono:</strong> +1 5589 55488 +51 947 697 494<br>
              <strong>Email:</strong> info@jimbosorteos.com<br>
            </p>
          </div>

          <div class="col-lg-4 col-md-4 footer-links">
            <h4>Enlaces</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="{{route('landing.home')}}">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#features">Nosotros</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#faq">Preguntas frecuentes</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="{{route('landing.terms_conditions')}}">Terminos y condiciones</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="{{route('landing.privacy_policies')}}">Politicas de privacidad</a></li>
            </ul>
          </div>

          {{-- <div class="col-lg-3 col-md-6 footer-links">
            <h4>Nuestros Servicios</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Sorteos de prodcu</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
            </ul>
          </div> --}}

          <div class="col-lg-4 col-md-4 footer-links">
            <h4>Redes Socilaes</h4>
           {{--  <p>Cras fermentum odio eu feugiat lide par naso tierra videa magna derita valies</p> --}}
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
              <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
              <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="container py-4">
      <div class="copyright">
        &copy; Copyright <strong><span>Jimbo Sorteos {{date('Y')}}</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/free-bootstrap-app-landing-page-template/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('landing/vendor/aos/aos.js')}}"></script>
  <script src="{{ asset('landing/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('landing/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{ asset('landing/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{ asset('landing/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('landing/js/main.js')}}"></script>

</body>

</html>
