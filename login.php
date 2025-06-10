<?php
defined('site') or die('ACCESS DENIED!');
require_once 'core/database.php';
require_once 'core/functions.php';

$message="";
if(isset($_POST['sub'])) {
    $resultlogin = $link->query("select * from users where email='" . addslashes($_POST['email']) . "' and password='" . md5($_POST['password']) . "'");
    if ($resultlogin->num_rows == 1) {
        $rowuser = $resultlogin->fetch_assoc();
        $_SESSION['login'] = $rowuser['id'];
        $_SESSION['username'] = $rowuser['username'];
        $_SESSION['email'] = $rowuser['email'];
        $_SESSION['role'] = $rowuser['role'];
        $_SESSION['alert_login'] = true;

        header("location:index.php");
    } else {
        $errors['login'] = '<script>toastr.error("ایمیل یا رمز عبور صحیح نمی باشد");</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <title>آکادمی بیت کلاس | ورود</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="">
    <meta name="description" content="آکادمی بیت کلاس">
    <link rel="shortcut icon" href="assets/images/logo-icon.png">

    <link rel="stylesheet" type="text/css" href="assets/vendor/font-awesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/tiny-slider/tiny-slider.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/glightbox/css/glightbox.css">

    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    <!--alert error-->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <style>
        /* سایز کلی باکس پیام */
        .toast {
            width: 450px !important;
        }
    </style>
</head>
<body>

<main>
    <section class="p-0 d-flex align-items-center position-relative overflow-hidden">

        <div class="container-fluid">
            <div class="row">
                <!-- left -->
                <div class="col-12 col-lg-6 d-md-flex align-items-center justify-content-center bg-primary bg-opacity-10 vh-lg-100">
                    <div class="p-3 p-lg-5">
                        <!-- Title -->
                        <div class="text-center">
                            <h2 class="fw-bold fs-3">به آکادمی بیت کلاس خوش آمدید</h2>
                            <p class="mb-0 h6 fw-light">بیایید امروز چیز جدیدی یاد بگیریم!</p>
                        </div>
                        <!-- SVG Image -->
                        <img src="assets/images/element/02.svg" class="mt-5" alt="">
                        <!-- Info -->
                        <div class="d-sm-flex mt-5 align-items-center justify-content-center">
                            <!-- Avatar group -->
                            <ul class="avatar-group mb-2 mb-sm-0">
                                <li class="avatar avatar-sm">
                                    <img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="avatar">
                                </li>
                                <li class="avatar avatar-sm">
                                    <img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="avatar">
                                </li>
                                <li class="avatar avatar-sm">
                                    <img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg" alt="avatar">
                                </li>
                                <li class="avatar avatar-sm">
                                    <img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt="avatar">
                                </li>
                            </ul>
                            <!-- Content -->
                            <p class="mb-0 h6 fw-light ms-0 ms-sm-3"> بیش از 100 دانشجو به ما پیوستند، حالا نوبت شماست.</p>
                        </div>
                    </div>
                </div>

                <!-- Right -->
                <div class="col-12 col-lg-6 m-auto">
                    <div class="row my-5">

                        <div class="col-sm-10 col-xl-8 m-auto">
                            <div class="mb-4 text-end ">
                                <span><a href="index.php"><i class="bi bi-house me-2"></i>بازگشت به صفحه اصلی</a></span>
                            </div>
                            <?php


                            if (isset($_SESSION['from_register'])) {
                                $name = $_SESSION['username'];
                                ?>
                                <script>
                                    toastr.success('<?php echo 'ثبت نام با موفقیت انجام شد، '.$name.' عزیز! خوش آمدید.' ?>');
                                </script>
                                <?php
                                // بعد از نمایش پیام، متغیر را حذف کنید
                                unset($_SESSION['from_register']);
                            }
                            ?>

                            <!-- Title -->
                            <h1 class="fs-4">ورود به حساب کاربری</h1>

                            <!-- Form START -->
                            <form method="post">
                                <?php


                                if(isset($errors['login'])){
                                    echo $errors['login'];
                                }
                                ?>

                                <!-- Email -->
                                <div class="mb-4" >
                                    <label for="exampleInputEmail1" class="form-label">ایمیل *</label>
                                    <div  class="input-group input-group-lg">
                                        <span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="bi bi-envelope-fill"></i></span>
                                        <input name="email" type="email" class="form-control border-0 bg-light rounded-end ps-1" style="direction: rtl" placeholder="ایمیل خود را اینجا وارد کنید ..." id="exampleInputEmail1">
                                    </div>
                                </div>
                                <!-- Password -->
                                <div class="mb-4">
                                    <label for="inputPassword5" class="form-label">رمز عبور *</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="fas fa-lock"></i></span>
                                        <input name="password" type="password" class="form-control border-0 bg-light rounded-end ps-1" placeholder=" رمز عبور خود را اینجا وارد کنید ..." id="inputPassword5">
                                    </div>

                                </div>
                                <!-- Check box -->
                                <div class="mb-4 d-flex justify-content-between mb-4">

                                    <div class="text-primary-hover">
                                        <a href="index.php?page=forget_password" class="text-secondary">
                                            <u>رمز خود را فراموش کرده اید؟</u>
                                        </a>
                                    </div>
                                </div>
                                <!-- Button -->
                                <div class="align-items-center mt-0">
                                    <div class="d-grid">
                                        <input type="submit" name="sub" class="btn btn-primary mb-0" value="ورود">
                                    </div>
                                </div>
                            </form>
                            <!-- Form END -->

                            <!-- Social buttons and divider -->


                            <!-- Sign up link -->
                            <div class="mt-4 text-center">
                                <span>حساب کاربری ندارید؟ <a href="index.php?page=register">ثبت نام</a></span>
                            </div>


                        </div>
                    </div> <!-- Row END -->
                </div>
            </div> <!-- Row END -->
        </div>
    </section>
</main>

<!-- Back to top -->
<div class="back-top"><i class="bi bi-arrow-up-short position-absolute top-50 start-50 translate-middle"></i></div>

<!-- Bootstrap JS -->
<script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<!-- Template Functions -->
<script src="assets/js/functions.js"></script>

</body>
</html>