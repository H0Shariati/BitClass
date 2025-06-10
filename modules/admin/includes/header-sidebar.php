<?php
defined('site') or die('ACCESS DENIED!');
require_once 'core/database.php';
require_once 'core/functions.php';
if(isset($_SESSION['login']) && $_SESSION['role']!=1){
    die('ACCESS DENIED!');
}
else{
    echo '<a href="index.php?page=login">لطفا ابتدا وارد شوید!</a>';
}

$section = isset($_GET['section']) ? $_GET['section'] : 'default';

?>
<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <title>آکادمی بیت کلاس</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="">
    <meta name="description" content="آکادمی بیت کلاس">
    <link rel="shortcut icon" href="../assets/images/logo-icon.png">

    <link rel="stylesheet" type="text/css" href="assets/vendor/font-awesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/apexcharts/css/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/overlay-scrollbar/css/overlayscrollbars.min.css">


    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.min.js"></script>

    <!--alert error-->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "positionClass": "toast-top-center",
            "progressBar": true,
            "timeOut": "4000", // زمان نمایش پیام (به میلی‌ثانیه)
        }
    </script>
    <style>
        /* سایز کلی باکس پیام */
        .toast {
            width: 450px !important;
        }
    </style>

</head>
<body>
<main>

    <!-- Sidebar START -->
    <nav class="navbar sidebar navbar-expand-xl navbar-dark bg-dark">

        <!-- Navbar brand for xl START -->
        <div class="d-flex align-items-center">
            <a class="navbar-brand" href="index.php">
                <img class="navbar-brand-item" src="assets/images/logo-light.svg" alt="">
            </a>
        </div>
        <!-- Navbar brand for xl END -->

        <div class="offcanvas offcanvas-start flex-row custom-scrollbar h-100" data-bs-backdrop="true" tabindex="-1" id="offcanvasSidebar">
            <div class="offcanvas-body sidebar-content d-flex flex-column bg-dark">

                <!-- Sidebar menu START -->
                <ul class="navbar-nav flex-column" id="navbar-sidebar">

                    <li class="nav-item"><a href="index.php?page=admin" class="nav-link <?php echo ($section == 'dashboard') ? ' active ' : ''; ?>"><i class="bi bi-speedometer2  me-2"></i>داشبورد</a></li>

                    <li class="nav-item"><a href="index.php?page=admin&section=menu" class="nav-link <?php echo ($section == 'menu') ? ' active ' : ''; ?>"><i class="bi bi-list me-2"></i>منو ها</a></li>

                    <li class="nav-item"><a href="index.php?page=admin&section=pages" class="nav-link <?php echo ($section == 'pages') ? ' active ' : ''; ?>"><i class="bi bi-file-earmark me-2"></i>صفحات</a></li>


                    <li class="nav-item">
                        <a class="nav-link <?php echo ($section == 'courses') ? ' active ' : ''; ?>" data-bs-toggle="collapse" href="#collapsepage" role="button" aria-expanded=<?php echo ($section == 'courses' || $section=='categories') ? ' true ' : ' false '; ?> aria-controls="collapsepage">
                            <i class="bi bi-basket fa-fw me-2 "></i>دوره ها
                        </a>
                        <!-- Submenu -->
                        <ul class="nav collapse flex-column <?php echo ($section == 'courses' || $section=='categories') ? ' show ' : ''; ?>" id="collapsepage" data-bs-parent="#navbar-sidebar">
                            <li class="nav-item"> <a class="nav-link <?php echo ($section == 'courses') ? ' active ' : ''; ?>" href="index.php?page=admin&section=courses">لیست</a></li>
                            <li class="nav-item"> <a class="nav-link <?php echo ($section == 'categories') ? ' active ' : ''; ?>" href="index.php?page=admin&section=categories">دسته بندی</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a href="index.php?page=admin&section=article" class="nav-link <?php echo ($section == 'article') ? ' active ' : ''; ?>"><i class="bi bi-substack me-2"></i>مقالات</a></li>

                    <li class="nav-item"> <a class="nav-link <?php echo ($section == 'users') ? ' active ' : ''; ?>" href="index.php?page=admin&section=users"><i class="bi bi-people-fill me-2"></i>کاربران</a></li>

                    <li class="nav-item"> <a href="index.php?page=admin&section=revenues" class="nav-link <?php echo ($section == 'revenues') ? ' active ' : ''; ?>"><i class="far fa-chart-bar fa-fw me-2"></i>درآمدها</a></li>
                    <li class="nav-item"> <a class="nav-link <?php echo ($section == 'site_info') ? ' active ' : ''; ?>" href="index.php?page=admin&section=site_info"><i class="bi bi-globe2 me-2"></i>مشخصات سایت</a></li>
                    <li class="nav-item"> <a href="index.php?page=admin&section=profile" class="nav-link <?php echo ($section == 'profile') ? ' active ' : ''; ?>"><i class="fas fa-user-cog fa-fw me-2"></i>تنظیمات حساب کاربری</a></li>
                </ul>
                <!-- Sidebar menu end -->

                <!-- Sidebar footer START -->
                <div class="px-3 mt-auto pt-3">
                    <div class="d-flex align-items-center justify-content-between text-primary-hover">
                        <a class="h5 mb-0 text-body" href="index.php" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="مشاهده سایت">
                            <i class="bi bi-globe"></i>
                        </a>
                        <a class="h5 mb-0 text-body" href="index.php?logout"  data-bs-toggle="tooltip" data-bs-placement="top" title="خروج">
                            <i class="bi bi-power"></i>
                        </a>
                    </div>
                </div>
                <!-- Sidebar footer END -->

            </div>
        </div>
    </nav>
    <!-- Sidebar END -->

    <!-- Page content START -->
    <div class="page-content">

        <!-- Top bar START -->
        <nav class="navbar top-bar navbar-light border-bottom py-0 py-xl-3 ">
            <div class="container-fluid p-0 ">
                <div class="d-flex align-items-center w-100 ">

                    <!-- Logo START -->
                    <div class="d-flex align-items-center d-xl-none">
                        <a class="navbar-brand" href="#">
                            <img class="light-mode-item navbar-brand-item h-30px" src="assets/images/logo-mobile.svg" alt="">
                            <img class="dark-mode-item navbar-brand-item h-30px" src="assets/images/logo-mobile-light.svg" alt="">
                        </a>
                    </div>
                    <!-- Logo END -->

                    <!-- Toggler for sidebar START -->
                    <div class="navbar-expand-xl sidebar-offcanvas-menu">
                        <button class="navbar-toggler me-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar" aria-expanded="false" aria-label="Toggle navigation" data-bs-auto-close="outside">
                            <i class="bi bi-text-right fa-fw h2 lh-0 mb-0 rtl-flip" data-bs-target="#offcanvasMenu"> </i>
                        </button>
                    </div>
                    <!-- Toggler for sidebar END -->

                    <!-- Top bar left -->
                    <div class="navbar-expand-lg ms-auto ms-xl-0">

                        <!-- Toggler for menubar START -->
                        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTopContent" aria-controls="navbarTopContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-animation">
							<span></span>
							<span></span>
							<span></span>
						</span>
                        </button>
                        <!-- Toggler for menubar END -->

                        <!-- Topbar menu START -->
                        <div class="collapse navbar-collapse w-100" id="navbarTopContent">
                            <!-- Top search START -->
                            <div class="nav my-3 my-xl-0 flex-nowrap align-items-center">
                                <div class="nav-item w-100">
                                    <form class="position-relative">
                                        <input class="form-control pe-5 bg-secondary bg-opacity-10 border-0" type="search" placeholder="جستجو..." aria-label="Search">
                                        <button class="bg-transparent px-2 py-0 border-0 position-absolute top-50 end-0 translate-middle-y" type="submit"><i class="fas fa-search fs-6 text-primary"></i></button>
                                    </form>
                                </div>
                            </div>
                            <!-- Top search END -->
                        </div>
                        <!-- Topbar menu END -->
                    </div>
                    <!-- Top bar left END -->

                    <!-- Top bar right START -->
                    <div class="ms-xl-auto">
                        <ul class="navbar-nav flex-row align-items-center">

                            <!-- Notification dropdown START -->
                            <li class="nav-item ms-2 ms-md-3 dropdown">
                                <!-- Notification button -->
                                <a class="btn btn-light btn-round mb-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                    <i class="bi bi-bell fa-fw"></i>
                                </a>
                                <!-- Notification dote -->
                                <span class="notif-badge animation-blink"></span>

                                <!-- Notification dropdown menu START -->
                                <div class="dropdown-menu dropdown-animation dropdown-menu-end dropdown-menu-size-md p-0 shadow-lg border-0">
                                    <div class="card bg-transparent">
                                        <div class="card-header bg-transparent border-bottom py-4 d-flex justify-content-between align-items-center">
                                            <h6 class="m-0">پیام ها <span class="badge bg-danger bg-opacity-10 text-danger ms-2">2 پیام جدید</span></h6>
                                            <a class="small" href="#">حذف همه</a>
                                        </div>
                                        <div class="card-body p-0">
                                            <ul class="list-group list-unstyled list-group-flush">
                                                <!-- Notif item -->
                                                <li>
                                                    <a href="#" class="list-group-item-action border-0 border-bottom d-flex p-3">
                                                        <div class="me-3">
                                                            <div class="avatar avatar-md">
                                                                <img class="avatar-img rounded-circle" src="assets/images/avatar/08.jpg" alt="avatar">
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <p class="text-body small m-0">به  <b> مهرداد قربانی </b> برای فارغ التحصیلی از <b>دانشگاه دماوند </b>تبریک میگوییم.</p>
                                                            <u class="small">پیام تبریک</u>
                                                        </div>
                                                    </a>
                                                </li>

                                                <!-- Notif item -->
                                                <li>
                                                    <a href="#" class="list-group-item-action border-0 border-bottom d-flex p-3">
                                                        <div class="me-3">
                                                            <div class="avatar avatar-md">
                                                                <img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="avatar">
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1">افزودن دوره جدید</h6>
                                                            <p class="small text-body m-0">با ویژگی های جدید آشنا شوید...</p>
                                                            <u class="small">مشاهده</u>
                                                        </div>
                                                    </a>
                                                </li>

                                                <!-- Notif item -->
                                                <li>
                                                    <a href="#" class="list-group-item-action border-0 border-bottom d-flex p-3">
                                                        <div class="me-3">
                                                            <div class="avatar avatar-md">
                                                                <img class="avatar-img rounded-circle" src="assets/images/avatar/05.jpg" alt="avatar">
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1">درخواست جدید برای درخواست مربی</h6>
                                                            <u class="small">مشاهده</u>
                                                        </div>
                                                    </a>
                                                </li>

                                                <!-- Notif item -->
                                                <li>
                                                    <a href="#" class="list-group-item-action border-0 border-bottom d-flex p-3">
                                                        <div class="me-3">
                                                            <div class="avatar avatar-md">
                                                                <img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg" alt="avatar">
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1">به روز رسانی نسخه 2.3</h6>
                                                            <p class="small text-body m-0">با ویژگی های جدید آشنا شوید...</p>
                                                            <small class="text-body">5 دقیقه پیش</small>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- Button -->
                                        <div class="card-footer bg-transparent border-0 py-3 text-center position-relative">
                                            <a href="#" class="stretched-link">مشاهده تمام فعالیت ها</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Notification dropdown menu END -->
                            </li>
                            <!-- Notification dropdown END -->


                        </ul>
                    </div>
                    <!-- Top bar right END -->
                </div>
            </div>
        </nav>
        <!-- Top bar END -->
