<section class="mb-n9 position-relative z-index-9">
    <div class="container">
        <div class="row">
            <div class="col-11 col-md-10 mx-auto">
                <div class="bg-warning rounded-3 shadow p-3 p-sm-4 position-relative overflow-hidden">
                    <!-- SVG decoration -->
                    <figure class="position-absolute top-100 start-100 translate-middle mt-n6 ms-n5">
                        <svg width="211px" height="211px">
                            <path class="fill-white opacity-4" d="M210.030,105.011 C210.030,163.014 163.010,210.029 105.012,210.029 C47.013,210.029 -0.005,163.014 -0.005,105.011 C-0.005,47.015 47.013,-0.004 105.012,-0.004 C163.010,-0.004 210.030,47.015 210.030,105.011 Z"></path>
                        </svg>
                    </figure>
                    <!-- SVG decoration -->
                    <figure class="position-absolute top-100 start-0 translate-middle mt-n6 ms-5">
                        <svg width="141px" height="141px">
                            <path class="fill-white opacity-4" d="M140.520,70.258 C140.520,109.064 109.062,140.519 70.258,140.519 C31.454,140.519 -0.004,109.064 -0.004,70.258 C-0.004,31.455 31.454,-0.003 70.258,-0.003 C109.062,-0.003 140.520,31.455 140.520,70.258 Z"></path>
                        </svg>
                    </figure>
                    <!-- SVG decoration -->
                    <figure class="position-absolute top-0 start-50 mt-4 ms-n9">
                        <svg width="41px" height="41px">
                            <path class="fill-white opacity-4" d="M40.531,20.265 C40.531,31.458 31.457,40.531 20.265,40.531 C9.072,40.531 -0.001,31.458 -0.001,20.265 C-0.001,9.073 9.072,-0.001 20.265,-0.001 C31.457,-0.001 40.531,9.073 40.531,20.265 Z"></path>
                        </svg>
                    </figure>

                    <!-- Icon logos START -->
                    <div class="p-2 bg-white shadow rounded-3 rotate-74 position-absolute top-0 start-0 ms-3 mt-5 d-none d-sm-block">
                        <img src="assets/images/client/science.svg" class="h-40px" alt="Icon">
                    </div>
                    <div class="p-1 bg-white shadow rounded-3 rotate-74 position-absolute top-0 end-0 mt-5 me-5 d-none d-sm-block">
                        <img src="assets/images/client/angular.svg" class="h-30px" alt="Icon">
                    </div>
                    <div 	class="p-2 bg-white shadow rounded-3 rotate-130 position-absolute bottom-0 start-50 ms-5 mb-2 d-none d-lg-block">
                        <img src="assets/images/client/figma.svg" class="h-20px" alt="Icon">
                    </div>
                    <!-- Icon logos END -->

                    <div class="row">
                        <div class="col-md-8 mx-auto text-center py-5 position-relative">
                            <!-- Title -->
                            <h2>برای دریافت جدیدترین به‌روزرسانی‌های دوره، در خبرنامه ما عضو شوید.</h2>
                            <!-- Form -->
                            <form class="row align-items-center justify-content-center mt-3">
                                <div class="col-lg-8">
                                    <div class="bg-body shadow rounded-pill p-2">
                                        <div class="input-group">
                                            <input class="form-control border-0 me-1" type="email" placeholder="ایمیل">
                                            <button type="button" class="btn btn-blue mb-0 rounded-pill">عضویت</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> <!-- Row END -->
                </div>
            </div>
        </div> <!-- Row END -->
    </div>
</section>

<footer class="pt-0 bg-blue rounded-4 position-relative mx-2 mx-md-4 mb-3">
    <!-- SVG decoration for curve -->
    <figure class="mb-0">
        <svg class="fill-body rotate-180" width="100%" height="150" viewBox="0 0 500 150" preserveAspectRatio="none">
            <path d="M0,150 L0,40 Q250,150 500,40 L580,150 Z"></path>
        </svg>
    </figure>

    <div class="container">
        <?php
        $result_footer=$link->query("SELECT * FROM site_information where id=2");
        $row_footer=$result_footer->fetch_assoc();
        ?>
        <div class="row mx-auto">
            <div class="col-lg-6 mx-auto text-center my-5">
                <!-- Logo -->
                <img class="mx-auto h-40px" src="assets/images/logo-light.svg" alt="logo">
                <p class="mt-3 text-white"><?php echo $row_footer['footer_about'];?></p>
                <!-- Links -->
                <!-- Social media button -->
                <ul class="list-inline mt-3 mb-0">
                    <li class="list-inline-item">
                        <a class="btn btn-white btn-sm shadow px-2 text-facebook" href="<?php echo $row_footer['facebook'];?>">
                            <i class="fab fa-fw fa-facebook-f"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="btn btn-white btn-sm shadow px-2 text-instagram" href="<?php echo $row_footer['instagram'];?>">
                            <i class="fab fa-fw fa-instagram"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="btn btn-white btn-sm shadow px-2 text-twitter" href="<?php echo $row_footer['twitter'];?>">
                            <i class="fab fa-fw fa-twitter"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="btn btn-white btn-sm shadow px-2 text-linkedin" href="<?php echo $row_footer['linkdin'];?>">
                            <i class="fab fa-fw fa-linkedin-in"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="btn btn-white btn-sm shadow px-2 text-twitter" href="<?php echo $row_footer['telegram'];?>">
                            <i class="fab fa-fw fa-telegram"></i>
                        </a>
                    </li>
                </ul>
                <!-- Bottom footer link -->
                <div class="mt-3 text-white">کلیه حقوق مادی و معنوی سایت برای آکادمی بیت کلاس محفوظ است.</div>
            </div>
        </div>
    </div>
</footer>

<div class="back-top"><i class="bi bi-arrow-up-short position-absolute top-50 start-50 translate-middle"></i></div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- Bootstrap JS -->
<script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<!-- Vendors -->
<script src="assets/vendor/tiny-slider/tiny-slider-rtl.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.js"></script>
<script src="assets/vendor/purecounterjs/dist/purecounter_vanilla.js"></script>


<!-- Template Functions -->
<script src="assets/js/functions.js"></script>

</body>
</html>