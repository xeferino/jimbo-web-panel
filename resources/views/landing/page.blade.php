<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Jimbo Sorteos</title>
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
  {{-- <script src="https://checkout.culqi.com/js/v4"></script> --}}
    <!-- ======= Header ======= -->
  <header id="header" class="fixed-top  header-transparent ">
    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
        {{-- <h1><a href="index.html">Appland</a></h1> --}}
        <!-- Uncomment below if you prefer to use an image logo -->
        <a href="{{route('landing.home')}}"><img src="{{asset('landing/img/logo-texto.png')}}" alt="" class="img-fluid"></a>
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#features">Nosotros</a></li>
          <li><a class="nav-link scrollto" href="#gallery">Galer&iacute;a</a></li>
          {{-- <li><a class="nav-link scrollto" href="#raffles">Sorteos</a></li> --}}
          {{-- <li><a class="nav-link scrollto" href="#faq">F.A.Q</a></li> --}}
         {{--  <li><a class="nav-link scrollto" href="">T&eacute;rminos y Condiciones</a></li> --}}
          {{-- <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">Drop Down 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
            </ul>
          </li> --}}
          <li><a class="nav-link scrollto" href="#contact">Cont&aacute;ctanos</a></li>
          {{-- <li><a class="getstarted scrollto" href="#features">Get Started</a></li> --}}
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-5 pt-lg-0 order-2 order-lg-1" data-aos="fade-up">
          <div>
            <h1>Somos tu mejor opción para ganar</h1>
            <h2>Aquí encontrarás una variedad de sorteos, con los que podras ganas premios en efectivo y mucho mas...</h2>
            <a href="https://play.google.com/store/apps/details?id=com.jimbosorteos.app" target="blank" class="download-btn"><i class="bx bxl-play-store"></i> Google Play</a>
            {{-- <a href="#" class="download-btn"><i class="bx bxl-apple"></i> App Store</a> --}}
          </div>
        </div>
        <div class="col-lg-6 d-lg-flex flex-lg-column align-items-stretch order-1 order-lg-2 hero-img" data-aos="fade-up">
          <img src="{{asset('landing/img/jimbo.jpeg')}}" class="img-fluid" alt="" style="border-radius: 25px; border: 3px solid #ffc107;">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= App Features Section ======= -->
    <section id="features" class="features">
      <div class="container">

        <div class="section-title">
          <h2>Nosotros</h2>
          <p>Somos una empresa con presencia en Perú y Ecuador. Dedicada a los sorteos en linea a traves de nuetras App.</p>
        </div>

        <div class="row no-gutters">
          <div class="col-xl-7 d-flex align-items-stretch order-2 order-lg-1">
            <div class="content d-flex flex-column justify-content-center">
              <div class="row">
                <div class="col-md-6 icon-box" data-aos="fade-up">
                  <i class="bx bx-money"></i>
                  <h4>Premios en efectivo</h4>
                  <p>Gana dinero en efectivo con la compra de un boleto</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                  <i class="bx bx-cube-alt"></i>
                  <h4>Premios de productos</h4>
                  <p>Gana un TV Smart, as&iacute; como Smartphone con la compra de boletos</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                  <i class="bx bx-user-pin"></i>
                  <h4>Vendedores</h4>
                  <p>Forma parte de nuestra familia Jimbo, Podras aumentar tus ingresos; vendiendo nuestros productos y mucho mas.</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
                  <i class="bx bx-calendar"></i>
                  <h4>Sorteos</h4>
                  <p>Jimbo te trae un catalago de diferentes sorteos, con los cuales puedes aumentar tus ingresos.</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="400">
                  <i class="bx bx-credit-card-alt"></i>
                  <h4>Metodos de pago</h4>
                  <p>Jimbo te provee de pagar se una forma rapida y segura a traves de tu tarjeta de credito, con tus Jibs, entre otros.</p>
                </div>
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="500">
                  <i class="bx bx-diamond"></i>
                  <h4>Ganas Jibs</h4>
                  <p>Al utilizar nuestra APP, Con tu codigo Jimbo lo podras compartir y podras ganar Jibs con tus invitados, los cuales podras canjera por efectivo.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="image col-xl-5 d-flex align-items-stretch justify-content-center order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
            <img src="{{asset('landing/img/feature.jpg')}}" class="img-fluid" alt="" style="height: 500px; border-radius:25px; border: 3px solid #ffc107; margin-top: 40px;">
          </div>
        </div>

      </div>
    </section><!-- End App Features Section -->

    <!-- ======= Details Section ======= -->
   {{--  <section id="details" class="details">
      <div class="container">

        <div class="row content">
          <div class="col-md-4" data-aos="fade-right">
            <img src="{{asset('landing/img/details-1.png')}}" class="img-fluid" alt="">
          </div>
          <div class="col-md-8 pt-4" data-aos="fade-up">
            <h3>Voluptatem dignissimos provident quasi corporis voluptates sit assumenda.</h3>
            <p class="fst-italic">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
              magna aliqua.
            </p>
            <ul>
              <li><i class="bi bi-check"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
              <li><i class="bi bi-check"></i> Duis aute irure dolor in reprehenderit in voluptate velit.</li>
              <li><i class="bi bi-check"></i> Iure at voluptas aspernatur dignissimos doloribus repudiandae.</li>
              <li><i class="bi bi-check"></i> Est ipsa assumenda id facilis nesciunt placeat sed doloribus praesentium.</li>
            </ul>
            <p>
              Voluptas nisi in quia excepturi nihil voluptas nam et ut. Expedita omnis eum consequatur non. Sed in asperiores aut repellendus. Error quisquam ab maiores. Quibusdam sit in officia
            </p>
          </div>
        </div>

        <div class="row content">
          <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
            <img src="{{asset('landing/img/details-2.png')}}" class="img-fluid" alt="">
          </div>
          <div class="col-md-8 pt-5 order-2 order-md-1" data-aos="fade-up">
            <h3>Corporis temporibus maiores provident</h3>
            <p class="fst-italic">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
              magna aliqua.
            </p>
            <p>
              Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
              velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
              culpa qui officia deserunt mollit anim id est laborum
            </p>
            <p>
              Inventore id enim dolor dicta qui et magni molestiae. Mollitia optio officia illum ut cupiditate eos autem. Soluta dolorum repellendus repellat amet autem rerum illum in. Quibusdam occaecati est nisi esse. Saepe aut dignissimos distinctio id enim.
            </p>
          </div>
        </div>

        <div class="row content">
          <div class="col-md-4" data-aos="fade-right">
            <img src="{{asset('landing/img/details-3.png')}}" class="img-fluid" alt="">
          </div>
          <div class="col-md-8 pt-5" data-aos="fade-up">
            <h3>Sunt consequatur ad ut est nulla consectetur reiciendis animi voluptas</h3>
            <p>Cupiditate placeat cupiditate placeat est ipsam culpa. Delectus quia minima quod. Sunt saepe odit aut quia voluptatem hic voluptas dolor doloremque.</p>
            <ul>
              <li><i class="bi bi-check"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
              <li><i class="bi bi-check"></i> Duis aute irure dolor in reprehenderit in voluptate velit.</li>
              <li><i class="bi bi-check"></i> Facilis ut et voluptatem aperiam. Autem soluta ad fugiat.</li>
            </ul>
            <p>
              Qui consequatur temporibus. Enim et corporis sit sunt harum praesentium suscipit ut voluptatem. Et nihil magni debitis consequatur est.
            </p>
            <p>
              Suscipit enim et. Ut optio esse quidem quam reiciendis esse odit excepturi. Vel dolores rerum soluta explicabo vel fugiat eum non.
            </p>
          </div>
        </div>

        <div class="row content">
          <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
            <img src="{{asset('landing/img/details-4.png')}}" class="img-fluid" alt="">
          </div>
          <div class="col-md-8 pt-5 order-2 order-md-1" data-aos="fade-up">
            <h3>Quas et necessitatibus eaque impedit ipsum animi consequatur incidunt in</h3>
            <p class="fst-italic">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
              magna aliqua.
            </p>
            <p>
              Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
              velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
              culpa qui officia deserunt mollit anim id est laborum
            </p>
            <ul>
              <li><i class="bi bi-check"></i> Et praesentium laboriosam architecto nam .</li>
              <li><i class="bi bi-check"></i> Eius et voluptate. Enim earum tempore aliquid. Nobis et sunt consequatur. Aut repellat in numquam velit quo dignissimos et.</li>
              <li><i class="bi bi-check"></i> Facilis ut et voluptatem aperiam. Autem soluta ad fugiat.</li>
            </ul>
          </div>
        </div>

      </div>
    </section> --}}<!-- End Details Section -->

    <!-- ======= Gallery Section ======= -->
    <section id="gallery" class="gallery">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Galer&iacute;a</h2>
          <p></p>
        </div>

      </div>

      <div class="container-fluid" data-aos="fade-up">
        <div class="gallery-slider swiper">
          <div class="swiper-wrapper">
            <div class="swiper-slide"><a href="{{asset('landing/img/gallery/1.jpeg')}}" class="gallery-lightbox" data-gall="gallery-carousel"><img src="{{asset('landing/img/gallery/1.jpeg')}}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="{{asset('landing/img/gallery/2.jpeg')}}" class="gallery-lightbox" data-gall="gallery-carousel"><img src="{{asset('landing/img/gallery/2.jpeg')}}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="{{asset('landing/img/gallery/3.jpeg')}}" class="gallery-lightbox" data-gall="gallery-carousel"><img src="{{asset('landing/img/gallery/3.jpeg')}}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="{{asset('landing/img/gallery/4.jpeg')}}" class="gallery-lightbox" data-gall="gallery-carousel"><img src="{{asset('landing/img/gallery/4.jpeg')}}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="{{asset('landing/img/gallery/5.jpeg')}}" class="gallery-lightbox" data-gall="gallery-carousel"><img src="{{asset('landing/img/gallery/5.jpeg')}}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="{{asset('landing/img/gallery/6.jpeg')}}" class="gallery-lightbox" data-gall="gallery-carousel"><img src="{{asset('landing/img/gallery/6.jpeg')}}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="{{asset('landing/img/gallery/7.jpeg')}}" class="gallery-lightbox" data-gall="gallery-carousel"><img src="{{asset('landing/img/gallery/7.jpeg')}}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="{{asset('landing/img/gallery/8.jpeg')}}" class="gallery-lightbox" data-gall="gallery-carousel"><img src="{{asset('landing/img/gallery/8.jpeg')}}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="{{asset('landing/img/gallery/9.jpeg')}}" class="gallery-lightbox" data-gall="gallery-carousel"><img src="{{asset('landing/img/gallery/9.jpeg')}}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="{{asset('landing/img/gallery/10.jpeg')}}" class="gallery-lightbox" data-gall="gallery-carousel"><img src="{{asset('landing/img/gallery/10.jpeg')}}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="{{asset('landing/img/gallery/11.jpeg')}}" class="gallery-lightbox" data-gall="gallery-carousel"><img src="{{asset('landing/img/gallery/11.jpeg')}}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="{{asset('landing/img/gallery/12.jpeg')}}" class="gallery-lightbox" data-gall="gallery-carousel"><img src="{{asset('landing/img/gallery/12.jpeg')}}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="{{asset('landing/img/gallery/13.jpeg')}}" class="gallery-lightbox" data-gall="gallery-carousel"><img src="{{asset('landing/img/gallery/13.jpeg')}}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="{{asset('landing/img/gallery/14.jpeg')}}" class="gallery-lightbox" data-gall="gallery-carousel"><img src="{{asset('landing/img/gallery/14.jpeg')}}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="{{asset('landing/img/gallery/15.jpeg')}}" class="gallery-lightbox" data-gall="gallery-carousel"><img src="{{asset('landing/img/gallery/15.jpeg')}}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="{{asset('landing/img/gallery/16.jpeg')}}" class="gallery-lightbox" data-gall="gallery-carousel"><img src="{{asset('landing/img/gallery/16.jpeg')}}" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="{{asset('landing/img/gallery/17.jpeg')}}" class="gallery-lightbox" data-gall="gallery-carousel"><img src="{{asset('landing/img/gallery/17.jpeg')}}" class="img-fluid" alt=""></a></div>
          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section><!-- End Gallery Section -->
     {{--  <section id="raffles" class="contact">
        <div class="container" data-aos="fade-up">
          <div class="section-title">
            <h2>Sorteos</h2>
            <p>Participa y unete a nuestra familia Jimbo, es tu oportunidad de generar ingresos extras.</p>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="row">
                @foreach ($raffles as $raffle)
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6 info">
                        <img src="{{$raffle->logo}}" alt="">
                        <h4 class="mt-3">{{$raffle->title}} - {{$raffle->remaining_days}} Restantes</h4>
                        <p>{{$raffle->description}}</p>
                        @foreach ($raffle->Tickets as $ticket)
                            @if($ticket->promotion->price>=5)
                                <div style="
                                border: 1px #ff9800 solid;
                                border-radius: 30px;
                                padding: 3px;
                                cursor:pointer;
                                " class="mt-2 ticket"
                                data-price="{{$ticket->promotion->price*100}}"
                                data-raffle_id="{{$raffle->id}}"
                                data-promotion_id="{{$ticket->promotion->id}}"
                                data-ticket_id="{{$ticket->id}}"
                                >
                                    {{$ticket->promotion->name}}
                                </div>
                            @endif
                        @endforeach
                        <button class="btn btn-warning mt-2 btn_pagar btn-comprar_{{$raffle->id}}" disabled>Comprar Boleto</button>
                    </div>
                    <div class="col-lg-3"></div>
                @endforeach
              </div>
              {{ $raffles->links() }}
            </div>
          </div>
        </div>
      </section> --}}
    <!-- ======= Testimonials Section ======= -->
    {{-- <section id="testimonials" class="testimonials section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Testimonios</h2>
          <p>Nuestra familia eres T&Uacute;!</p>
        </div>

        <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="{{asset('landing/img/testimonials/testimonials-1.jpg')}}" class="testimonial-img" alt="">
                <h3>Saul Goodman</h3>
                <h4>Ceo &amp; Founder</h4>
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                  Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.
                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                </p>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="{{asset('landing/img/testimonials/testimonials-2.jpg')}}" class="testimonial-img" alt="">
                <h3>Sara Wilsson</h3>
                <h4>Designer</h4>
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                  Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.
                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                </p>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="{{asset('landing/img/testimonials/testimonials-3.jpg')}}" class="testimonial-img" alt="">
                <h3>Jena Karlis</h3>
                <h4>Store Owner</h4>
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                  Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.
                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                </p>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="{{asset('landing/img/testimonials/testimonials-4.jpg')}}" class="testimonial-img" alt="">
                <h3>Matt Brandon</h3>
                <h4>Freelancer</h4>
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                  Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.
                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                </p>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="{{asset('landing/img/testimonials/testimonials-5.jpg')}}" class="testimonial-img" alt="">
                <h3>John Larson</h3>
                <h4>Entrepreneur</h4>
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                  Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.
                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                </p>
              </div>
            </div>

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section> --}}<!-- End Testimonials Section -->

    <!-- ======= Pricing Section ======= -->
    {{-- <section id="pricing" class="pricing">
      <div class="container">

        <div class="section-title">
          <h2>Pricing</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

        <div class="row no-gutters">

          <div class="col-lg-4 box" data-aos="fade-right">
            <h3>Free</h3>
            <h4>$0<span>per month</span></h4>
            <ul>
              <li><i class="bx bx-check"></i> Quam adipiscing vitae proin</li>
              <li><i class="bx bx-check"></i> Nec feugiat nisl pretium</li>
              <li><i class="bx bx-check"></i> Nulla at volutpat diam uteera</li>
              <li class="na"><i class="bx bx-x"></i> <span>Pharetra massa massa ultricies</span></li>
              <li class="na"><i class="bx bx-x"></i> <span>Massa ultricies mi quis hendrerit</span></li>
            </ul>
            <a href="#" class="get-started-btn">Get Started</a>
          </div>

          <div class="col-lg-4 box featured" data-aos="fade-up">
            <h3>Business</h3>
            <h4>$29<span>per month</span></h4>
            <ul>
              <li><i class="bx bx-check"></i> Quam adipiscing vitae proin</li>
              <li><i class="bx bx-check"></i> Nec feugiat nisl pretium</li>
              <li><i class="bx bx-check"></i> Nulla at volutpat diam uteera</li>
              <li><i class="bx bx-check"></i> Pharetra massa massa ultricies</li>
              <li><i class="bx bx-check"></i> Massa ultricies mi quis hendrerit</li>
            </ul>
            <a href="#" class="get-started-btn">Get Started</a>
          </div>

          <div class="col-lg-4 box" data-aos="fade-left">
            <h3>Developer</h3>
            <h4>$49<span>per month</span></h4>
            <ul>
              <li><i class="bx bx-check"></i> Quam adipiscing vitae proin</li>
              <li><i class="bx bx-check"></i> Nec feugiat nisl pretium</li>
              <li><i class="bx bx-check"></i> Nulla at volutpat diam uteera</li>
              <li><i class="bx bx-check"></i> Pharetra massa massa ultricies</li>
              <li><i class="bx bx-check"></i> Massa ultricies mi quis hendrerit</li>
            </ul>
            <a href="#" class="get-started-btn">Get Started</a>
          </div>

        </div>

      </div>
    </section> --}}<!-- End Pricing Section -->

    <!-- ======= Frequently Asked Questions Section ======= -->
    {{-- <section id="faq" class="faq section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">

          <h2>Preguntas Frecuentes</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

        <div class="accordion-list">
          <ul>
            <li data-aos="fade-up">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse" data-bs-target="#accordion-list-1">Non consectetur a erat nam at lectus urna duis? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-1" class="collapse show" data-bs-parent=".accordion-list">
                <p>
                  Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="100">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-2" class="collapsed">Feugiat scelerisque varius morbi enim nunc? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-2" class="collapse" data-bs-parent=".accordion-list">
                <p>
                  Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="200">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-3" class="collapsed">Dolor sit amet consectetur adipiscing elit? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-3" class="collapse" data-bs-parent=".accordion-list">
                <p>
                  Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="300">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-4" class="collapsed">Tempus quam pellentesque nec nam aliquam sem et tortor consequat? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-4" class="collapse" data-bs-parent=".accordion-list">
                <p>
                  Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est. Purus gravida quis blandit turpis cursus in.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="400">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-5" class="collapsed">Tortor vitae purus faucibus ornare. Varius vel pharetra vel turpis nunc eget lorem dolor? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="accordion-list-5" class="collapse" data-bs-parent=".accordion-list">
                <p>
                  Laoreet sit amet cursus sit amet dictum sit amet justo. Mauris vitae ultricies leo integer malesuada nunc vel. Tincidunt eget nullam non nisi est sit amet. Turpis nunc eget lorem dolor sed. Ut venenatis tellus in metus vulputate eu scelerisque.
                </p>
              </div>
            </li>

          </ul>
        </div>

      </div>
    </section> --}}<!-- End Frequently Asked Questions Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Cont&aacute;tacnos</h2>
          <p>Quieres pertenecer a nuestra familia Jimbo, es tu oportunidad de generar ingresos extras.</p>
        </div>

        <div class="row">

          <div class="col-lg-6">
            <div class="row">
              <div class="col-lg-6 info">
                <i class="bx bx-map"></i>
                <h4>Direcci&oacute;n</h4>
                <p>Peru,<br>Thumbes, TC 535022</p>
              </div>
              <div class="col-lg-6 info">
                <i class="bx bx-phone"></i>
                <h4>Telefono</h4>
                <p>+51 947 697 494<br>+51 933 504 839</p>
              </div>
              <div class="col-lg-6 info">
                <i class="bx bx-envelope"></i>
                <h4>Email</h4>
                <p>admin@jimbosorteos.com<br>info@jimbosorteos.com</p>
              </div>
              <div class="col-lg-6 info">
                <i class="bx bx-time-five"></i>
                <h4>Horarios</h4>
                <p>Lun - Vie: 9AM a 5PM<br>Dom: 9AM a 1PM</p>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form" data-aos="fade-up">
              <div class="form-group">
                <input placeholder="Your Name" type="text" name="name" class="form-control" id="name" required>
              </div>
              <div class="form-group mt-3">
                <input placeholder="Your Email" type="email" class="form-control" name="email" id="email" required>
              </div>
              <div class="form-group mt-3">
                <input placeholder="Subject" type="text" class="form-control" name="subject" id="subject" required>
              </div>
              <div class="form-group mt-3">
                <textarea placeholder="Message" class="form-control" name="message" rows="5" required></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Enviar</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

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
              <li><i class="bx bx-chevron-right"></i> <a href="#hero">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#features">Nosotros</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="{{route('landing.faqs')}}" target="blank">Preguntas frecuentes</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="{{route('landing.terms_conditions')}}" target="blank">Terminos y condiciones</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="{{route('landing.privacy_policies')}}" target="blank">Politicas de privacidad</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="{{route('landing.rules_game')}}" target="blank">Reglas del juego</a></li>
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
              <a href="https://www.facebook.com/profile.php?id=100083867204382&mibextid=ZbWKwL" target="blank" class="facebook"><i class="bx bxl-facebook"></i></a>
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

<input type="hidden" name="raffle_id" id="raffle_id">
<input type="hidden" name="promotion_id" id="promotion_id">
<input type="hidden" name="ticket_id" id="ticket_id">
<input type="hidden" name="price" id="price">
<input type="hidden" name="email" id="email">
<input type="hidden" name="token_id" id="token_id">

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('landing/vendor/aos/aos.js')}}"></script>
  <script src="{{ asset('landing/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/jquery-ui/jquery-ui.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/popper.js/popper.min.js') }}"></script>
  <!-- Sweet Alert -->
  <script src="{{ asset('assets/js/sweetalert/sweetalert.min.js') }}"></script>
  <script src="{{ asset('assets/js/axios.js') }}"></script>
  <script src="{{ asset('landing/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{ asset('landing/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{ asset('landing/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('landing/js/main.js')}}"></script>
  <script>
    Culqi.publicKey = 'pk_test_f4383204e49dc6b3';

    $('.ticket').on('click', function(){
        var raffle = $(this).data('raffle_id');
        $(this).addClass('ticket-select');
        $(this).siblings().removeClass('ticket-select');
        $('.btn-comprar_'+raffle).prop("disabled", false);

        $('#raffle_id').val($(this).data('raffle_id'));
        $('#promotion_id').val($(this).data('promotion_id'));
        $('#ticket_id').val($(this).data('ticket_id'));
        $('#price').val($(this).data('price'));

        Culqi.settings({
            title: 'Jimbo',
            currency: 'USD',  // Este parámetro es requerido para realizar pagos yape
            amount: $(this).data('price'),  // Este parámetro es requerido para realizar pagos yape
            order: '' // Este parámetro es requerido para realizar pagos con pagoEfectivo, billeteras y Cuotéalo
        });
    });

    $('.btn_pagar').on('click', function(e){
        Culqi.open();
        e.preventDefault();
    });

    Culqi.options({
      style: {
        logo: 'https://www.jimbosorteos.com/landing/img/logo-icon.png',
        bannerColor: '#ff9800', // hexadecimal
        buttonBackground: '#ff9800', // hexadecimal
        menuColor: '', // hexadecimal
        linksColor: '', // hexadecimal
        buttonText: '', // texto que tomará el botón
        buttonTextColor: '#f3f9800', // hexadecimal
        priceColor: '#ff9800' // hexadecimal
      }
    });

    function culqi() {
        if (Culqi.token) {
            // ¡Objeto Token creado exitosamente!
            var token = Culqi.token.id;
            var email = Culqi.token.email;
            //En esta linea de codigo debemos enviar el "Culqi.token.id"
            //hacia tu servidor con Ajax
            var raffle_id = $('#raffle_id').val();
            var promotion_id = $('#promotion_id').val();
            var ticket_id = $('#ticket_id').val();
            var price = $('#price').val();
            var token_id = $('#token_id').val(token);
            var correo = $('#email').val(email);

            console.log('Se ha creado un Token: ', token);
            console.log('raffle_id : ', raffle_id);
            console.log('promotion_id : ', promotion_id);
            console.log('ticket_id : ', ticket_id);
            console.log('price : ', price);
            console.log('email : ', email);
            localStorage.setItem('token_local', token);
            localStorage.setItem('local_gollo', 'culqi');
            const token_local = localStorage.getItem('token_local');
            const local_gollo = localStorage.getItem('local_gollo');

            console.log('Se ha creado un Token local: ', token_local);


            /*var token = Culqi.token.id;
      var email_culqi = Culqi.token.email;
      $("#token_id").val(token);
      $("#email_culqi").val(email_culqi);*/

            Culqi.close();

            axios.post("{{route('landing.pay')}}", {
                data:{
                        'raffle_id': raffle_id,
                        'promotion_id' : promotion_id,
                        'ticket_id': ticket_id,
                        'price': price,
                        'email': correo,
                        'token_id': token_local,
                        'local_gollo': local_gollo
                    }
            }).then(response => {
                console.log('success : ', response.data);

            }).catch(error => {
                console.log('Error : ',Culqi.error);
            });
        } else {
            // Mostramos JSON de objeto error en consola
            console.log('Error : ',Culqi.error);
        }
    };
  </script>
</body>

</html>
