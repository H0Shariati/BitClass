<?php
defined('site') or die('ACCESS DENIED!');
require_once 'core/database.php';
require_once 'core/functions.php';

$errors=[];
$success=false;//متغیر برای نشان دادن موفقیت ثبت نام

if(isset($_POST['sub'])){
    $username=clean($_POST['username']);
    if(isset($username) && mb_strlen($username)<2){
        $errors['username']="نام کاربری باید حداقل 2 کاراکتر باشد";
    }
    $email=clean($_POST['email']);
    if(isset($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email']="ایمیل وارد شده نا معتبر می باشد";
    }
    $password=clean($_POST['password']);
    $confirm=clean($_POST['confirm']);
    if(isset($password) && mb_strlen($password)<8){
        $errors['password']="رمز عبور باید حداقل 8 کاراکتر باشد";
    }
    elseif($password !== $confirm){
        $errors['confirm']="مقدار رمز عبور با تکرار آن مطابقت ندارد";

    }


    if(!isset($_POST['agree'])){
        $errors['agree']="لطفاً با شرایط و قوانین موافقت کنید";

    }
    // در صورتی که هیچ اروری وجود نداشته باشد
    if (empty($errors)) {
        $success = true; // ثبت نام موفق
    }

}
if ($success) {
    $result_register1=$link->query("select * from users where username='$username'");
    if($result_register1->num_rows==0) {
        $result_register2=$link->query("select * from users where email='$email'");
            if($result_register2->num_rows==0) {
                $link->query("insert into users (username,password,email) values ('$username',md5('$password'),'$email')");
                $resultlogin=$link->query("select * from users where username='$username'");
                if($resultlogin->num_rows==1){
                    $rowuser=$resultlogin->fetch_assoc();
                    $_SESSION['username']=$username;
                    $_SESSION['from_register'] = true; // متغیر جدید برای شناسایی
                }
                header("location:index.php?page=login");
                echo "<div class='alert alert-success'>ثبت نام با موفقیت انجام شد، $username عزیز! خوش آمدید.</div>";
            }
            else{
                $errors['result_register2']="ایمیل وارد شده تکراری است";

            }

    }
    else{
        $errors['result_register1']="کاربری با نام کاربری شما از قبل وجود دارد ، لطفا نام کاربری دیگری وارد کنید";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <title>آکادمی بیت کلاس | ثبت نام</title>
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
    <script>

            // آرایه‌ای برای ذخیره خطاها
            const errors = [];

            <?php if (isset($errors['username'])) { ?>
            errors.push('<?php echo $errors['username']; ?>');
            <?php } ?>
            <?php if (isset($errors['result_register1'])) { ?>
            errors.push('<?php echo $errors['result_register1']; ?>');
            <?php } ?>
            <?php if (isset($errors['email'])) { ?>
            errors.push('<?php echo $errors['email']; ?>');
            <?php } ?>
            <?php if (isset($errors['result_register2'])) { ?>
            errors.push('<?php echo $errors['result_register2']; ?>');
            <?php } ?>
            <?php if (isset($errors['password'])) { ?>
            errors.push('<?php echo $errors['password']; ?>');
            <?php } ?>
            <?php if (isset($errors['confirm'])) { ?>
            errors.push('<?php echo $errors['confirm']; ?>');
            <?php } ?>
            <?php if (isset($errors['agree'])) { ?>
            errors.push('<?php echo $errors['agree']; ?>');
            <?php } ?>

            // تابع برای نمایش خطاها
            function showErrors(errors) {
            errors.forEach((error, index) => {
                setTimeout(() => {
                    toastr.error(error);
                }, index * 2000); // 2000 میلی‌ثانیه = 2 ثانیه تأخیر
            });
        }

            // اگر آرایه خطا پر باشد، نمایش داده شود
            if (errors.length > 0) {
            showErrors(errors);
        }

    </script>

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
                            <ul class="avatar-group mb-2 mb-sm-0">
                                <li class="avatar avatar-sm"><img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="avatar"></li>
                                <li class="avatar avatar-sm"><img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="avatar"></li>
                                <li class="avatar avatar-sm"><img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg" alt="avatar"></li>
                                <li class="avatar avatar-sm"><img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt="avatar"></li>
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
                            <div class="mb-4 text-end">
                                <span><a href="index.php"><i class="bi bi-house me-2"></i>بازگشت به صفحه اصلی</a></span>
                            </div>
                            <!-- Title -->
                            <h2 class="">ثبت نام</h2>

                            <!-- Form START -->
                            <form method="post"  novalidate>
                                <!-- username -->
                                <div class="mb-4">
                                    <label for="exampleInputEmail1" class="form-label">نام کاربری</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="bi bi-person-fill"></i></span>
                                        <input name="username" type="text" class="form-control border-0 bg-light rounded-end ps-1" placeholder="نام کاربری خود را اینجا وارد کنید ..." id="exampleInputEmail1" value="<?php if(isset($_POST['username'])){ echo $_POST['username'];} ?>">
                                    </div>
                                <!-- Email -->
                                <div class="mb-4">
                                    <label for="exampleInputEmail1" class="form-label">ایمیل</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="bi bi-envelope-fill"></i></span>
                                        <input name="email" type="email" class="form-control border-0 bg-light rounded-end ps-1" style="direction: rtl"  placeholder="ایمیل خود را اینجا وارد کنید ..." id="exampleInputEmail1" value="<?php if(isset($_POST['email'])){ echo $_POST['email'];} ?>">
                                    </div>
                                </div>
                                <!-- Password -->
                                <div class="mb-4">
                                    <label for="inputPassword5" class="form-label">رمز عبور *</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="fas fa-lock"></i></span>
                                        <input name="password" type="password" class="form-control border-0 bg-light rounded-end ps-1" placeholder=" رمز عبور خود را اینجا وارد کنید ..." id="inputPassword5" value="<?php if(isset($_POST['password'])){ echo $_POST['password'];} ?>">
                                    </div>
                                </div>
                                <!-- Confirm Password -->
                                <div class="mb-4">
                                    <label for="inputPassword6" class="form-label">تایید رمز عبور *</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="fas fa-lock"></i></span>
                                        <input name="confirm" type="password" class="form-control border-0 bg-light rounded-end ps-1" placeholder="  مجدد رمز عبور خود را اینجا وارد کنید ..." id="inputPassword6" value="<?php if(isset($_POST['confirm'])){ echo $_POST['confirm'];} ?>">
                                    </div>
                                </div>
                                <!-- Check box -->
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input name="agree" type="checkbox" class="form-check-input" id="checkbox-1" <?php if(isset($_POST['agree'])){ echo ' checked ';} ?>>
                                        <label class="form-check-label" for="checkbox-1">با ثبت نام <a href="#">شرایط و قوانین سایت</a> را خواهید پذیرفت.</label>
                                    </div>
                                </div>
                                <!-- Button -->
                                <div class="align-items-center mt-0">
                                    <div class="d-grid">
                                        <input type="submit" name="sub" class="btn btn-primary mb-0" value="ثبت نام">
                                    </div>
                                </div>
                            </form>
                            <!-- Form END -->



                            <!-- Sign up link -->
                            <div class="mt-4 text-center">
                                <span>آیا قبلا ثبت نام کرده اید؟<a href="index.php?page=login"> ورود</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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