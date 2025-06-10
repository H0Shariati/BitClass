<?php
if(isset($_GET['action'])){
    switch($_GET['action']){
        case 'delete':
            $link->query("DELETE FROM cart where id=".$_GET['id']);
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <title>آکادمی بیت کلاس</title>
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

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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

<header class="navbar-light navbar-sticky header-static">
    <!-- Nav START -->
    <nav class="navbar navbar-expand-xl">
        <div class="container-fluid px-3 px-xl-5">
            <!-- Logo START -->
            <a class="navbar-brand" href="index.php">
                <img class="light-mode-item navbar-brand-item" src="assets/images/logo.svg" alt="logo">
                <!--                <img class="dark-mode-item navbar-brand-item" src="assets/images/logo-light.svg" alt="logo">-->
            </a>
            <!-- Logo END -->

            <!-- Responsive navbar toggler -->
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-animation">
					<span></span>
					<span></span>
					<span></span>
				</span>
            </button>

            <!-- Main navbar START -->
            <div class="navbar-collapse w-100 collapse" id="navbarCollapse">

                <!-- Nav category menu START -->
                <ul class="navbar-nav navbar-nav-scroll me-auto">
                    <!-- Nav item 1 Demos -->
                    <li class="nav-item dropdown dropdown-menu-shadow-stacked">
                        <a class="nav-link bg-primary bg-opacity-10 rounded-3 text-primary px-3 py-3 py-xl-0" href="#" id="categoryMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-ui-radios-grid me-2"></i><span>دسته بندی دوره ها</span></a>
                        <ul class="dropdown-menu" aria-labelledby="categoryMenu">
                            <!-- Dropdown submenu -->
                            <?php
                            $resultcategory = $link->query("SELECT * FROM course_category");
                            while ($category = $resultcategory->fetch_assoc()) {
                                if($category['status']==1 ){?>
                            <li> <a class="dropdown-item" href="index.php?page=categories&id=<?php echo $category['category_id']; ?>"><?php  echo $category['category_name']; ?></a></li>
                                    <?php
                                }
                            }
                            ?>
                            <li> <a class="dropdown-item bg-primary text-primary bg-opacity-10 rounded-2 mb-0" href="index.php?page=all_course">مشاهده همه</a></li>
                        </ul>
                    </li>
                </ul>
                <!-- Nav category menu END -->

                <!-- Nav Main menu START -->
                <ul class="navbar-nav navbar-nav-scroll me-auto">
                    <?php
                    $resultmenu = $link->query("SELECT * FROM menu order by sort");
                    $menus = []; // آرایه‌ای برای ذخیره منوها
                    while ($menu = $resultmenu->fetch_assoc()) {
                        $menus[] = $menu;
                    }
                    // حلقه برای نمایش منوهای اصلی
                    foreach ($menus as $menu) {
                        if ($menu['status'] == 1 && $menu['submenu'] == 0) {
                            $hasSubmenu = false; // فرض اولیه: زیرمنو نداریم

                            foreach ($menus as $submenu) {
                                if ($submenu['submenu'] == $menu['id']) {
                                    $hasSubmenu = true; // اگر زیرمنو وجود داشته باشد
                                }
                            }

                            // اگر منو دارای زیرمنو باشد
                            if ($hasSubmenu) {
                                ?>
                                <li class="nav-item me-2 dropdown d-flex justify-content-center align-items-center flex-row">
                                    <a class="nav-link pe-0" href="index.php?page=page&id=<?php echo $menu['id']; ?>" ><?php echo $menu['menu_title']; ?>
                                        <a class=" dropdown-toggle text-secondary" id="demoMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="demoMenu">
                                        <?php
                                        // حلقه برای نمایش زیرمنوها
                                        foreach ($menus as $submenu) {
                                            if ($submenu['submenu'] == $menu['id'] && $submenu['status'] == 1) {
                                                ?>
                                                <li><a class="dropdown-item" href="index.php?page=page&id=<?php echo $submenu['id']; ?>"><?php echo $submenu['menu_title']; ?></a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </li>
                                <?php
                            } else {
                                // اگر زیرمنو نداشت، فقط منوی اصلی را نمایش می‌دهیم
                                ?>
                                <li class="nav-item me-2">
                                    <a class="nav-link" href="index.php?page=page&id=<?php echo $menu['id']; ?>"><?php echo $menu['menu_title']; ?></a>
                                </li>
                                <?php
                            }
                        }
                    }
                    ?>
                </ul>
                <!-- Nav Main menu END -->

                <!-- Nav Search START -->
                <div class="nav my-3 my-xl-0 px-4 flex-nowrap align-items-center">
                    <div class="nav-item w-100">
                        <form class="position-relative" method="post" action="index.php?page=all_course">
                            <input class="form-control pe-5 bg-transparent" name="search" type="search" placeholder="جستجو..." aria-label="Search" value="<?php if(isset($_POST['search'])){ echo $_POST['search'] ;} ?>">
                            <button class="bg-transparent p-2 position-absolute top-50 end-0 translate-middle-y border-0 text-primary-hover text-reset" type="submit">
                                <i class="fas fa-search fs-6 "></i>
                            </button>
                        </form>
                    </div>
                </div>
                <!-- Nav Search END -->
            </div>
            <?php if(isset($_SESSION['login'])){
                $countresult=$link->query("SELECT COUNT(*) AS total FROM cart where user_id='".$_SESSION['login']."' AND status=0");
                $countrow= $countresult->fetch_assoc();
                ?>
            <!-- Add to cart START -->
            <ul class="nav flex-row align-items-center list-unstyled ms-xl-auto">

                <li class="nav-item me-3 dropdown ">
                    <!-- Cart button -->
                    <a class="btn btn-light btn-round mb-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        <i class="bi bi-bag"></i>
                    </a>
                    <!-- badge -->
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-dark mt-xl-2 ms-n1"><?php echo $countrow['total'] ;?>
						<span class="visually-hidden">اقلام</span>
					</span>

                    <!-- Cart dropdown menu START -->
                    <div class="dropdown-menu dropdown-animation dropdown-menu-end dropdown-menu-size-md p-0 shadow-lg border-0">
                        <div class="card bg-transparent">

                            <?php if($countrow['total']==0){?>
                                <div class="p-4 text-center">سبد خرید شما خالیست!</div>
                             <?php
                            }
                            else{
                                $resultcart=$link->query("SELECT courses.*,cart.* FROM cart JOIN courses ON cart.course_id=courses.id WHERE cart.user_id=".$_SESSION['login']." AND cart.status=0");
                                ?>
                                <div class="card-header bg-transparent border-bottom py-4">
                                    <h5 class="m-0">سبد خرید شما</h5>
                                </div>
                                <?php
                                while ($cart_items=$resultcart->fetch_assoc()) {
                                    ?>
                                    <div class="card-body border-bottom ">
                                        <div class="row p-2 g-2">
                                            <div class="col-3">
                                                <img class="rounded-1" src="files/courses/<?php echo $cart_items['course_image'] ;?>" alt="avatar">
                                            </div>

                                            <div class="col-9  my-auto">
                                                <div class="d-flex justify-content-between">
                                                    <h6 class="m-0 fw-normal"><?php echo $cart_items['course_title'] ; ?></h6>
                                                    <h6 class="m-0 fw-normal"><?php echo priceFormat($cart_items['course_price']).' تومان' ; ?></h6>

                                                    <a href="?action=delete&id=<?php echo $cart_items['id'] ;?>" class="small text-primary-hover"><i class="bi bi-x-lg"></i></a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                <?php
                                }
                                ?>

                                <!-- Button -->
                                <div class="card-footer bg-transparent border-top py-3 text-end position-relative">
                                    <a href="index.php?page=cart" class="btn btn-sm btn-totalprimary text-white mb-0 col-12">مشاهده سبدخرید</a>
                                </div>

                                <?php
                            }?>

                        </div>
                    </div>
                    <!-- Cart dropdown menu END -->
                </li>
            </ul>
            <!-- Add to cart END -->
            <?php } ?>
            <?php
            if(isset($_SESSION['login'])){
                ?>
                <div class="dropdown ms-1 ms-lg-0">
                    <a class="avatar avatar-sm p-0" href="#" id="profileDropdown" role="button" data-bs-auto-close="outside" data-bs-display="static" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="avatar-img rounded-circle" src="assets/images/avatar/default.jpg" alt="avatar">
                    </a>
                    <ul class="dropdown-menu dropdown-animation dropdown-menu-end shadow pt-3" aria-labelledby="profileDropdown">
                        <li class="px-3 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar me-3">
                                    <img class="avatar-img rounded-circle shadow" src="assets/images/avatar/default.jpg" alt="avatar">
                                </div>
                                <div>
                                    <a class="h6" href="#"><?php  echo $_SESSION['username']; ?></a>
                                    <p class="small m-0"><?php  echo $_SESSION['email']; ?></p>
                                </div>
                            </div>
                        </li>
                        <li> <hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?php if(isset($_SESSION['role'])){
                            switch($_SESSION['role']){
                                case 1: echo "index.php?page=admin"; break;
                                case 2: echo "index.php?page=teacher"; break;
                                case 3: echo "index.php?page=student&id=".$_SESSION['login']; break;
                            }
                            }
                            ?>"><i class="bi bi-person  me-2"></i>پنل کاربری</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-info-circle  me-2"></i>پشتیبانی</a></li>
                        <li><a class="dropdown-item bg-danger-soft-hover" href="index.php?logout"  ><i class="bi bi-power  me-2"></i>خروج</a></li>
                    </ul>
                </div>
                <?php

            }
            else{
                ?>
                <div class="navbar-nav d-none d-lg-inline-block">
                    <a href="index.php?page=login"><button class="btn btn-danger-soft mb-0"><i class="fas fa-sign-in-alt me-2"></i>ورود / ثبت نام</button></a>
                </div>

            <?php
            }

            ?>


            <!-- Main navbar END -->

        </div>
    </nav>
    <!-- Nav END -->
</header>
