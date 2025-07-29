<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Service Details - TSLHK</title>
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/" rel="preconnect">
  <link href="https://fonts.gstatic.com/" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;family=Inter:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body class="service-details-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center me-auto">
        <img src="{{ asset('assets/img/logo.png') }}" style="width: 100px; height: 100px;" alt="">
        <h1 class="sitename">TSLHK</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('dashboard') }}#hero">Home</a></li>
          <li><a href="{{ route('dashboard') }}#about">About Us</a></li>
          <li><a href="{{ route('dashboard') }}#services">Our Grading</a></li>
          <li><a href="{{ route('dashboard') }}#portfolio">Products</a></li>
          <li><a href="{{ route('dashboard') }}#team">Why Choose Us</a></li>
          <li><a href="{{ route('dashboard') }}#contact">Contact Us</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a href="https://wa.me/916352961396" target="_blank" style="
        display: inline-block;
        width: 35px;
        height: 35px;
        background-color: #25D366;
        border-radius: 50%;
        text-align: center;
        line-height: 35px;
        margin-left: 15px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
      ">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" style="width: 18px; height: 18px; vertical-align: middle;">
      </a>

    </div>
  </header>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url({{ asset('assets/img/page-title-bg.webp') }});">
      <div class="container position-relative">
        <h1>Service Details</h1>
        <p>Discover our comprehensive range of professional grading and quality assurance services.</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="current">Service Details</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Service Details Section -->
    <section id="service-details" class="service-details section">

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="services-list">
              <a href="#" class="active">Quality Grading</a>
              <a href="#">Certification Services</a>
              <a href="#">Testing & Analysis</a>
              <a href="#">Documentation</a>
              <a href="#">Consultation</a>
            </div>

            <h4>Professional Quality Assurance</h4>
            <p>Our expert team provides comprehensive quality grading services with international standards compliance. We ensure accuracy, reliability, and timely delivery for all your grading requirements.</p>
          </div>

          <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
            <img src="{{ asset('assets/img/services.jpg') }}" alt="" class="img-fluid services-img">
            <h3>Comprehensive Grading Services with International Standards</h3>
            <p>
              TSLHK offers a complete range of grading services designed to meet the highest quality standards. 
              Our experienced professionals utilize advanced methodologies and state-of-the-art equipment to ensure 
              accurate and reliable results for all your grading needs.
            </p>
            <ul>
              <li><i class="bi bi-check-circle"></i> <span>International standard compliance and certification.</span></li>
              <li><i class="bi bi-check-circle"></i> <span>Advanced testing methodologies and equipment.</span></li>
              <li><i class="bi bi-check-circle"></i> <span>Comprehensive documentation and reporting.</span></li>
            </ul>
            <p>
              Our grading services cover a wide range of industries and applications, ensuring that your products 
              meet the required specifications and quality standards. We provide detailed analysis reports with 
              clear recommendations for improvement.
            </p>
            <p>
              With years of experience in the industry, our team understands the unique challenges and requirements 
              of different sectors. We work closely with our clients to develop customized grading solutions that 
              address their specific needs and objectives. Our commitment to excellence and attention to detail 
              ensures that every project receives the highest level of professional service.
            </p>
          </div>

        </div>

      </div>

    </section><!-- /Service Details Section -->

  </main>

  <footer id="footer" class="footer dark-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
            <span class="sitename">TSLHK</span>
          </a>
          <div class="footer-contact pt-3">
            <p>TSLHK Office</p>
            <p>Mumbai, Maharashtra, India</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+91 6352961396</span></p>
            <p><strong>Email:</strong> <span>info@tslhk.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href="#"><i class="bi bi-twitter-x"></i></a>
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('dashboard') }}">Home</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('dashboard') }}#about">About us</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('dashboard') }}#services">Services</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Terms of service</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Privacy policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Quality Grading</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Certification</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Testing Services</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Consultation</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Documentation</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12 footer-newsletter">
          <h4>Contact Us</h4>
          <p>Have questions about our services? Send us a message!</p>
          @include('_partials.contact-form')
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">TSLHK</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        Designed by <a href="#">TSLHK Team</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

</body>
</html> 