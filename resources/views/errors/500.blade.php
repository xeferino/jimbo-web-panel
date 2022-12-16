<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Jimbo Sorteos - Error 500, Internal Server</title>
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
  <style>
    .button {
        margin-top: 37px;
        outline: 0;
        height: 56px;
        letter-spacing: .8px;
        line-height: 50px;
        font-size: 22px;
        text-align: center;
        border-radius: 28px;
        font-family: HelveticaNeueW01-45Ligh;
        cursor: pointer;
        border: 2px solid #ff9800;
        background-color: #fff;
        color: #ff9800;
        box-sizing: border-box;
        transition-property: color,background-color;
        transition-duration: .2s;
        padding: 0 20px;
    }
    .button:hover {
        margin-top: 37px;
        outline: 0;
        height: 56px;
        letter-spacing: .8px;
        line-height: 50px;
        font-size: 22px;
        text-align: center;
        border-radius: 28px;
        font-family: HelveticaNeueW01-45Ligh;
        cursor: pointer;
        border: 2px solid #ff9800;
        background-color: #ff9800;
        color: #fff;
        box-sizing: border-box;
        transition-property: color,background-color;
        transition-duration: .2s;
        padding: 0 20px;
    }
  </style>
  <!-- =======================================================
  * Template Name: Appland - v4.9.1
  * Template URL: https://bootstrapmade.com/free-bootstrap-app-landing-page-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
  <main id="main">
    <!-- ======= App Features Section ======= -->
    <section id="features" class="features">
      <div class="container">

        <div class="section-title">
            <a href="{{route('landing.home')}}"><img src="{{asset('landing/img/logo-texto.png')}}" alt="" width="50%" class="img-fluid"></a>
          <div class="text-center">
            <p style="font-size: 120px; color: #ff9800;">500</p>
            <p style="font-size: 30px; color: #272727;"><b> Internal Server Error </b></p>
            <p style="font-size: 30px; color: #272727;"> <a href="{{route('landing.home')}}" class="btn button">Volver a Home</a> </p>
          </div>
        </div>
      </div>
    </section><!-- End App Features Section -->
</main><!-- End #main -->

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
