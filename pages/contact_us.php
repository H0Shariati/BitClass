<?php
defined('site') or die('ACCESS DENIED!');
require_once 'includes/header.php';

$result_information=$link->query("SELECT * FROM site_information where id=2");
$info=$result_information->fetch_assoc();
?>
<section class="pt-5 pb-0" style="background-image:url(assets/images/element/map.svg); background-position: center left; background-size: cover;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-xl-6 text-center mx-auto">
                <!-- Title -->
                <h6 class="text-primary">تماس با ما</h6>
                <h1 class="mb-4 fs-4">ما برای کمک اینجا هستیم!</h1>
            </div>
        </div>

        <!-- Contact info box -->
        <div class="row g-4 g-md-5 mt-0 mt-lg-3">
            <!-- Box item -->
            <div class="col-lg-4 mt-lg-0">
                <div class="card card-body shadow py-5 text-center h-100">
                    <!-- Title -->
                    <h5 class="mb-3 fw-normal">آدرس دفتر مرکزی</h5>
                    <ul class="list-inline mb-0">
                        <!-- Address -->
                        <li class="list-item mb-3 h6 fw-light">
                            <a href="#"> <i class="fas fa-fw fa-map-marker-alt me-2 mt-1"></i><?php echo $info['address'] ; ?></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Box item -->
            <div class="col-lg-4 mt-lg-0">
                <div class="card card-body shadow py-5 text-center h-100">
                    <!-- Title -->
                    <h5 class="mb-3 fw-normal">تلفن پشتیبانی</h5>
                    <ul class="list-inline mb-0">
                        <!-- Phone number -->
                        <li class="list-item mb-3 h6 fw-light">
                            <a href="#"> <i class="fas fa-fw fa-phone-alt me-2"></i><?php echo $info['phone'] ; ?> </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Box item -->
            <div class="col-lg-4 mt-lg-0">
                <div class="card card-body shadow py-5 text-center h-100">
                    <!-- Title -->
                    <h5 class="mb-3 fw-normal">ایمیل پشتیبانی</h5>
                    <ul class="list-inline mb-0">
                        <!-- Email id -->
                        <li class="list-item mb-0 h6 fw-light">
                            <a href="#"> <i class="far fa-fw fa-envelope me-2"></i><?php echo $info['email'] ; ?> </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>
<section >
    <div class="container">
        <div class="row g-4 g-lg-0 align-items-center">

            <div class="col-md-6 align-items-center text-center">
                <!-- Image -->
                <img src="assets/images/element/contact.svg" class="h-400px" alt="">

                <!-- Social media button -->
                <div class="d-sm-flex align-items-center justify-content-center mt-2 mt-sm-4">
                    <h5 class="mb-0">ما را دنبال کنید:</h5>
                    <ul class="list-inline mb-0 ms-sm-2">
                        <li class="list-inline-item"> <a class="fs-5 me-1 text-facebook" href="<?php echo $info['facebook'] ; ?>"><i class="fab fa-fw fa-facebook-square"></i></a> </li>
                        <li class="list-inline-item"> <a class="fs-5 me-1 text-instagram" href="<?php echo $info['instagram'] ; ?>"><i class="fab fa-fw fa-instagram"></i></a> </li>
                        <li class="list-inline-item"> <a class="fs-5 me-1 text-twitter" href="<?php echo $info['twitter'] ; ?>"><i class="fab fa-fw fa-twitter"></i></a> </li>
                        <li class="list-inline-item"> <a class="fs-5 me-1 text-linkedin" href="<?php echo $info['linkdin'] ; ?>"><i class="fab fa-fw fa-linkedin-in"></i></a> </li>
                        <li class="list-inline-item"> <a class="fs-5 me-1 text-twitter" href="<?php echo $info['telegram'] ; ?>"><i class="fab fa-fw fa-telegram"></i></a> </li>

                    </ul>
                </div>
            </div>

            <!-- Contact form START -->
            <div class="col-md-6">
                <!-- Title -->
                <h2 class="mt-4 mt-md-0 fs-4">با ما در ارتباط باشید</h2>
                <p>برای درخواست نمایندگی لطفا با بخش فروش شرکت تماس بگیرید یا فرم را پر کنید سپس همکاران ما با شما تماس خواهند گرفت.</p>

                <form>
                    <!-- Name -->
                    <div class="mb-4 bg-light-input">
                        <label for="yourName" class="form-label">نام و نام خانوادگی *</label>
                        <input type="text" class="form-control form-control-lg" id="yourName">
                    </div>
                    <!-- Email -->
                    <div class="mb-4 bg-light-input">
                        <label for="emailInput" class="form-label">ایمیل *</label>
                        <input type="email" class="form-control form-control-lg" id="emailInput">
                    </div>
                    <!-- Message -->
                    <div class="mb-4 bg-light-input">
                        <label for="textareaBox" class="form-label">متن درخواست *</label>
                        <textarea class="form-control" id="textareaBox" rows="4"></textarea>
                    </div>
                    <!-- Button -->
                    <div class="d-grid">
                        <button class="btn btn-lg btn-primary mb-0" type="button">ارسال</button>
                    </div>
                </form>
            </div>
            <!-- Contact form END -->
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row g-4 g-md-5 col-10 mx-auto">
            <!-- Main content START -->
            <div class="col-lg-12">
                <!-- Title -->
                <h3 class="mb-4 fs-5">سوالات متداول</h3>

                <!-- FAQ START -->
                <div class="accordion accordion-icon accordion-bg-light" id="accordionExample2">
                    <?php
                    $result_faqs=$link->query("SELECT * FROM faqs");
                    while ($faq=$result_faqs->fetch_assoc()) {?>
                        <!-- Item -->
                        <div class="accordion-item mb-3">
                            <h6 class="accordion-header font-base" id="heading-2">
                                <button class="accordion-button fw-bold rounded d-inline-block collapsed d-block pe-5" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                                    <?php echo $faq['question'] ; ?>
                                </button>
                            </h6>
                            <!-- Body -->
                            <div id="collapse-2" class="accordion-collapse collapse" aria-labelledby="heading-2" data-bs-parent="#accordionExample2">
                                <div class="accordion-body mt-3">
                                    <?php echo $faq['answer'] ; ?>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                    ?>


                </div>
                <!-- FAQ END -->
            </div>
            <!-- Main content END -->
        </div><!-- Row END -->

    </div>
</section>
<?php
require_once 'includes/footer.php';
?>