<?php
session_start();
session_regenerate_id();
define('site',1);
require_once 'core/database.php';
require_once 'core/functions.php';

if(isset($_GET['logout'])){
    session_destroy();
    header("Location: index.php");
}

if (isset($_GET['page'])){
    switch ($_GET['page']) {
        case 'login':
            require_once 'login.php';
        break;
        case 'register':
            require_once 'register.php';
        break;
        case 'admin':
            require_once 'modules/admin/index.php';
        break;
        case 'teacher':
            require_once 'modules/teacher/index.php';
        break;
        case 'student':
            require_once 'modules/student/dashboard.php';
        break;
        case 'page':
            require_once 'pages/page.php';
        break;
        case 'single':
            require_once 'pages/course_detail.php';
        break;
        case 'categories':
            require_once 'pages/categories.php';
        break;
        case 'all_course':
            require_once 'pages/all_course.php';
        break;
        case 'cart':
            require_once 'pages/cart.php';
        break;
        case 'payment':
            require_once 'pages/payment-gateway.php';
        break;
        case 'result_pay':
            require_once 'pages/result_pay.php';
        break;
        case 'forget_password':
            require_once 'pages/forget_password.php';
        break;
        case 'filter_category':
            require_once 'pages/filter_category_courses.php';
            break;
        case 'filter_price':
            require_once 'pages/filter_price_courses.php';
            break;
        case 'filter_level':
            require_once 'pages/filter_level_courses.php';
            break;
        case 'filter_sort':
            require_once 'pages/filter_sort_courses.php';
            break;
        case 'cat_filter_price':
            require_once 'pages/cat_filter_price_courses.php';
            break;
        case 'cat_filter_level':
            require_once 'pages/cat_filter_level_courses.php';
            break;
        case 'cat_filter_sort':
            require_once 'pages/cat_filter_sort_courses.php';
            break;
        case 'blog_detail':
            require_once 'pages/blog_detail.php';
        break;
        case 'blog':
            require_once 'pages/blog.php';
        break;
    }
}

else{
    if(isset($_SESSION['role']) && $_SESSION['role'] == '1' && isset($_GET['page']) && $_GET['page'] == 'admin'){
        require_once 'modules/admin/index.php';
    }
    else{
        require_once 'includes/header.php';
    ?>

<main>
    <?php
    if(isset($_SESSION['alert_login'])){
        echo  '<script>toastr.success("ورود با موفقیت انجام شد'.$_SESSION['username'].' عزیز خوش آمدید");</script> ';
    }
    unset($_SESSION['alert_login']);
    ?>
    <!-- Main Banner START -->
    <section class="overflow-hidden pt-6 pt-xxl-0">
        <div class="container-fluid">
            <div class="row g-4 g-md-5 align-items-center justify-content-between	mb-xxl-n7">
                <!-- Left image side START -->
                <div class="col-lg-3 col-xl-4 col-xxl-3 d-none d-lg-block">
                    <div class="row g-md-5 align-items-center ms-n6">
                        <div class="col-6">
                            <img src="assets/images/bg/3by4/07.jpg" class="rounded-3 mt-6 mb-5" alt="">
                            <img src="assets/images/bg/3by4/06.jpg" class="rounded-3" alt="">
                        </div>

                        <div class="col-6 position-relative">
                            <img src="assets/images/bg/3by4/05.jpg" class="rounded-3" alt="">

                            <!-- Svg element decoration -->
                            <img src="assets/images/element/17.svg" class="h-60px position-absolute top-0 start-0 ms-3 mt-n3" alt="">

                        </div>
                    </div>
                </div>
                <!-- Left image side END -->

                <!-- Main content -->
                <div class="col-lg-6 col-xl-4 col-xxl-5 text-center position-relative">
                    <!-- Title -->
                    <h1 class="display-6">بیت به بیت، کد به کد،<br>با ما کامپیوتر رو حرفه ای شو!</h1>
                    <!-- Svg decoration -->
                    <figure class="position-absolute top-0 start-100 translate-middle pe-7 pb-4">
                        <svg width="94.5px" height="67.6px" viewBox="0 0 94.5 67.6">
                            <path class="fill-purple" d="M15.1,3.4c-0.3,0.4-0.4,1-0.1,1.5l2,3.2l-1.3,1.7c-1-0.2-1.9,0.2-2.5,1c-0.5,0.7-0.6,1.6-0.3,2.4l-9.2,9.5
							c-0.6,0.8-0.8,1.8-0.7,2.7c0.2,0.9,0.7,1.7,1.4,2.1c1.4,0.8,3.3,0.4,4.3-1.1l6.4-11.6c0.8,0,1.6-0.3,2.1-1c0.6-0.8,0.6-1.8,0.2-2.7
							l0.8-1l9.7,15.4l-8.6,8.4c-0.2,0.1-0.4,0.3-0.6,0.5c0,0-0.1,0.1-0.1,0.1l-0.4,0.4l0.2,0.1c-0.6,2.1,1.7,5.4,3.9,7.9
							c3.2,3.8,8.1,8.2,13.6,12.2l0.3,0.2c5.4,4,10.9,7.3,15.4,9.3c3,1.3,6.9,2.6,8.7,1.4l0.2,0.2l6.2-11.9l23.8,6.7
							c0.6,0.1,1.1-0.1,1.4-0.5c0-0.1,0.1-0.1,0.1-0.2c0.1-0.1,0.1-0.1,0.1-0.2c0.3-0.4,0.4-1,0.1-1.5L67.4,13.8c-0.2-0.3-0.5-0.6-0.9-0.7
							L16.7,2.6c-0.5-0.1-1.1,0.1-1.4,0.5c0,0.1-0.1,0.1-0.1,0.2C15.2,3.3,15.1,3.4,15.1,3.4z M7.7,25.8c-0.6,0.9-1.8,1.2-2.6,0.7
							c-0.4-0.3-0.8-0.7-0.9-1.3c-0.1-0.6,0-1.2,0.4-1.7l9-9.2l0,0c0.1,0.1,0.2,0.1,0.2,0.2c0,0,0.1,0,0.1,0.1L7.7,25.8z M14.2,11.5
							c0.4-0.6,1.3-0.7,1.8-0.3c0.6,0.4,0.7,1.3,0.3,1.8c-0.4,0.5-1,0.7-1.6,0.4c-0.1,0-0.2-0.1-0.3-0.2c-0.1-0.1-0.2-0.2-0.3-0.4l0-0.1
							C13.9,12.5,13.9,11.9,14.2,11.5z M21.5,33.5L36,19.2l0-0.1c0.7-0.9,9.7,1.5,20.1,9.1l0.2,0.1c5.9,4.4,9.5,8.5,11.1,10.6
							c2.8,3.6,3.2,5.4,3,5.7l0,0.1l-9.5,18.2c-1-3-4.8-7.5-10.7-12.7l-3.4-2.5c-0.3-0.2-0.6-0.4-0.9-0.6c-0.8-0.5-1.8-1.1-3.1-1.4
							c-0.1,0-0.1,0-0.2,0c0,0,0-0.1-0.1-0.2c-0.6-1.2-1.5-2-2.2-2.6c-0.3-0.2-0.6-0.5-0.8-0.7l-3.3-2.4C29.8,35.8,24.6,33.6,21.5,33.5z
							M35.1,18.3c0,0.1-0.1,0.1-0.1,0.2l-6.2,6.1L16,4.3c0,0,0-0.1,0-0.2c0-0.1,0.1-0.1,0.2-0.1l49.4,11.1c0,0,0,0,0.1,0c0,0,0,0,0,0
							L91,59.6c0,0.1,0,0.1,0,0.2c0,0.1-0.1,0.1-0.2,0.1l-23.5-6.6l4.2-8c1-1.5-1.5-5.1-3.1-7.1c-2.9-3.7-6.9-7.5-11.4-10.8l-0.2-0.1
							C47.8,20.5,36.8,16,35.1,18.3z M59.8,64.9c-0.6,0.8-2.9,0.8-7.7-1.3c-4.4-1.9-9.8-5.2-15.2-9.2c-0.1-0.1-0.2-0.1-0.2-0.2
							c-5.4-4-10.2-8.3-13.4-12.1c-3.4-4-4.1-6.3-3.5-7c1-1.4,6.9,0.2,15.8,5.6l3.2,2.3c0.2,0.2,0.5,0.4,0.8,0.6c0.7,0.6,1.4,1.2,1.9,2.2
							c0.1,0.2,0.1,0.3,0.2,0.4l0.1,0.3l0.3,0c0.1,0,0.2,0,0.4,0.1c1.2,0.2,2,0.7,2.7,1.2c0.3,0.2,0.6,0.4,0.9,0.6l3.4,2.5
							C57.5,58.1,60.8,63.5,59.8,64.9z"/>
                        </svg>
                    </figure>
                    <p>بازار آنلاین آموزش و یادگیری با بیش از 5K دوره و 10 میلیون دانشجو. توسط متخصصان آموزش داده می شود تا به شما در کسب مهارت های جدید کمک کند.</p>

                    <!-- Buttons -->
                    <div class="d-sm-flex align-items-center justify-content-center">
                        <!-- Button -->
                        <a href="#courses" class="btn btn-lg btn-warning me-2 mb-4 mb-sm-0">مشاهده دوره ها<i class="bi bi-arrow-left ms-2"></i></a>
                        <!-- Video button -->
                        <div class="d-flex align-items-center justify-content-center py-2 ms-0 ms-sm-4">
                            <a href="files/intro.mp4" class="btn btn-lg btn-round btn-light mb-0 overflow-visible me-7">
                                <i class="fas fa-play"></i>
                                <h6 class="mb-0 ms-2 fw-normal position-absolute start-100 top-50 translate-middle-y">مشاهده ویدیو</h6>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right image side START -->
                <div class="col-lg-3 col-xl-4 col-xxl-3">
                    <div class="row g-4 align-items-center me-n4">
                        <!-- Images -->
                        <div class="col-4">
                            <img src="assets/images/bg/3by4/01.jpg" class="rounded-3" alt="">
                        </div>

                        <!-- Images -->
                        <div class="col-5 position-relative">
                            <img src="assets/images/bg/3by4/02.jpg" class="rounded-3 mb-5" alt="">
                            <img src="assets/images/bg/3by4/03.jpg" class="rounded-3 mb-n5" alt="">

                            <!-- Content -->
                            <div class="p-3 card card-body shadow position-absolute top-0 start-0 translate-middle z-index-1 d-none d-xxl-block mt-6 ms-n7">
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- Icon -->
                                    <div class="icon-md text-bg-orange rounded-2 flex-shrink-0">
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <!-- Info -->
                                    <h6 class="mb-0 small mb-0 ms-3">بیش از 100 هزار دانشجو امتیاز پنج ستاره به مدرسین خود داده اند.</h6>
                                </div>
                            </div>
                        </div>

                        <!-- Images -->
                        <div class="col-3">
                            <img src="assets/images/bg/3by4/04.jpg" class="rounded-3 mt-7 mb-5" alt="">
                            <img src="assets/images/bg/3by4/08.jpg" class="rounded-3 mb-n8" alt="">
                        </div>
                    </div>
                </div>
                <!-- Right image side END -->
            </div>
        </div>
    </section>
    <!-- Main Banner END -->

    <!-- Counter START -->
    <section class="py-0 py-xl-5">
        <div class="container">
            <div class="row g-4">
                <!-- Counter item -->
                <div class="col-sm-6 col-xl-3">
                    <div class="d-flex justify-content-center align-items-center p-4 bg-warning bg-opacity-15 rounded-3">
                        <span class="display-6 lh-1 text-warning mb-0"><i class="fas fa-tv"></i></span>
                        <div class="ms-4 h6 fw-normal mb-0">
                            <div class="d-flex">
                                <?php
                                $countcourse=$link->query("select count(*) as count from courses");
                                $countcourse_item=$countcourse->fetch_assoc();

                                ?>
                                <h5 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="<?php echo $countcourse_item['count']; ?>"	data-purecounter-delay="200">0</h5>
                                <span class="mb-0 h5">دوره</span>
                            </div>
                            <p class="mb-0">آموزش آنلاین</p>
                        </div>
                    </div>
                </div>
                <!-- Counter item -->
                <div class="col-sm-6 col-xl-3">
                    <div class="d-flex justify-content-center align-items-center p-4 bg-blue bg-opacity-10 rounded-3">
                        <span class="display-6 lh-1 text-blue mb-0"><i class="fas fa-user-tie"></i></span>
                        <div class="ms-4 h6 fw-normal mb-0">
                            <div class="d-flex">
                                <?php
                                $countteacher=$link->query("select count(*) as count from users where role=2");
                                $countteacher_item=$countteacher->fetch_assoc();

                                ?>
                                <h5 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="<?php echo $countteacher_item['count']; ?>" data-purecounter-delay="200"></h5>
                                <span class="mb-0 h5">مـدرس</span>
                            </div>
                            <p class="mb-0">مجرب و باسابقه</p>
                        </div>
                    </div>
                </div>
                <!-- Counter item -->
                <div class="col-sm-6 col-xl-3">
                    <div class="d-flex justify-content-center align-items-center p-4 bg-purple bg-opacity-10 rounded-3">
                        <span class="display-6 lh-1 text-purple mb-0"><i class="fas fa-user-graduate"></i></span>
                        <div class="ms-4 h6 fw-normal mb-0">
                            <div class="d-flex">
                                <?php
                                $countstudent=$link->query("select count(*) as count from users where role=3");
                                $countstudent_item=$countstudent->fetch_assoc();

                                ?>
                                <h5 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="<?php echo $countstudent_item['count'] ; ?>"	data-purecounter-delay="200">0</h5>
                                <span class="mb-0 h5">هنرجـو</span>
                            </div>
                            <p class="mb-0">دانشجوی آنلاین</p>
                        </div>
                    </div>
                </div>
                <!-- Counter item -->
                <div class="col-sm-6 col-xl-3">
                    <div class="d-flex justify-content-center align-items-center p-4 bg-info bg-opacity-10 rounded-3">
                        <span class="display-6 lh-1 text-info mb-0"><i class="bi bi-patch-check-fill"></i></span>
                        <div class="ms-4 h6 fw-normal mb-0">
                            <div class="d-flex">
                                <h5 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="6" data-purecounter-delay="300">0</h5>
                                <span class="mb-0 h5">مدرک بین المللی</span>
                            </div>
                            <p class="mb-0">دوره های گواهی شده</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Counter END -->

    <!-- Trending courses START -->
    <section class="pt-0 pt-md-5" id="courses">
        <div class="container">
            <!-- Title -->
            <div class="row mb-4">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="mb-0">دوره های <span class="text-warning">محبوب </span> آکادمی</h2>
                    <p class="mb-0">مشاهده دوره های جدید و 🔥 در جشنواره</p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Card Item START -->
                <?php
                $resultcourse = $link->query("SELECT courses.* , course_category.category_name as category_name FROM courses join course_category ON courses.cat_id=course_category.category_id ORDER BY courses.update_date DESC LIMIT 6 ");
                while($rowcourse = $resultcourse->fetch_assoc()){?>
                    <div class="col-md-6 col-xl-4">
                        <div class="card p-2 shadow h-100">
                            <div class="rounded-top overflow-hidden">
                                <div class="card-overlay-hover">
                                    <!-- Image -->
                                    <img src="files/courses/<?php echo $rowcourse['course_image']; ?>" class="card-img-top" alt="course image">
                                </div>
                                <!-- Hover element -->
                                <div class="card-img-overlay">
                                    <div class="card-element-hover d-flex justify-content-end">
                                        <a href="index.php?page=single&id=<?php echo $rowcourse['id']; ?>" class="icon-md bg-white rounded-circle text-center">
                                            <i class="fas fa-shopping-cart text-danger"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                <!-- Rating and avatar -->
                                <div class="d-flex justify-content-between">
                                    <!-- Rating and info -->
                                    <ul class="list-inline hstack gap-2 mb-0">
                                        <!-- Info -->
                                        <li class="list-inline-item d-flex justify-content-center align-items-center">
                                            <div class="icon-md bg-orange bg-opacity-10 text-orange rounded-circle"><i class="fas fa-user-graduate"></i></div>
                                            <?php
                                            $cnParticipants=$link->query("SELECT count(*) as cn FROM cart WHERE course_id=".$rowcourse['id']." AND status=1");
                                            $rowParticipants=$cnParticipants->fetch_assoc();
                                            ?>
                                            <span class="h6 fw-light mb-0 ms-2"><?php echo $rowParticipants['cn'] ; ?></span>
                                        </li>
                                        <!-- Rating -->
                                        <li class="list-inline-item d-flex justify-content-center align-items-center">
                                            <div class="icon-md bg-warning bg-opacity-15 text-warning rounded-circle"><i class="fas fa-star"></i></div>
                                            <?php
                                            //avg-rating
                                            $sum=0;
                                            $countcom=$link->query("select count(*) as count from comments where course_id=".$rowcourse['id']);
                                            $rowcounrcom=$countcom->fetch_assoc();
                                            $avg_rating=$link->query("select comments.* , users.username as username from comments JOIN users ON comments.sender=users.id where comments.course_id=".$rowcourse['id']." order by comments.date desc ");
                                            while($rowavg=$avg_rating->fetch_assoc()){
                                                $sum+=$rowavg['rating'];
                                            }
                                            if($rowcounrcom['count']!=0){
                                                $avg_rating=round($sum/$rowcounrcom['count']);
                                            }
                                            else{
                                                $avg_rating=5;
                                            }

                                            ?>
                                            <span class="h6 fw-light mb-0 ms-2"><?php echo $avg_rating ; ?></span>
                                        </li>
                                    </ul>
                                    <!-- Avatar -->
                                    <div class="avatar avatar-sm">
                                        <img class="avatar-img rounded-circle" src="assets/images/avatar/09.jpg" alt="avatar">
                                    </div>
                                </div>
                                <!-- Divider -->
                                <hr>
                                <!-- Title -->
                                <h5 class="card-title fw-normal"><a href="index.php?page=single&id=<?php echo $rowcourse['id']; ?>"><?php echo $rowcourse['course_title']; ?></a></h5>
                                <!-- Badge and Price -->
                                <div class="d-flex justify-content-between align-items-center mb-0">
                                    <a href="#" class="badge bg-info bg-opacity-10 text-info me-2"><i class="fas fa-circle small fw-bold"></i><?php  echo ' '.$rowcourse['category_name']; ?> </a>
                                    <!-- Price -->
                                    <h3 class="text-success mb-0 fs-5 fw-normal"><?php if($rowcourse['course_price']!=0){echo priceFormat($rowcourse['course_price']).' تومان';} else{echo 'رایگان';}  ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }
                ?>
                <!-- Card Item END -->


            </div>
            <!-- Button -->
            <div class="text-center mt-5">
                <a href="index.php?page=all_course" class="btn btn-primary-soft mb-0">مشاهده همه  <i class="bi bi-arrow-left"></i></a>
            </div>
        </div>
    </section>
    <!-- Trending courses END -->

    <!-- Category START -->
    <section class="position-relative pb-0 pb-sm-5">
        <div class="container">
            <!-- Title -->
            <div class="row mb-4">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fs-3">دسته بندی دوره ها</h2>
                    <p class="mb-0">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.</p>
                </div>
            </div>

            <div class="row g-4">
                <?php
                $categoris=$link->query("SELECT * FROM course_category WHERE status=1 limit 8");
                while ($category_item=$categoris->fetch_assoc()) {?>
                <!-- Item -->
                <div class="col-sm-6 col-md-4 col-xl-3">
                    <div class="bg-primary bg-opacity-10 rounded-3 text-center p-3 position-relative btn-transition">
                        <!-- Image -->
                        <div class="icon-xl bg-body mx-auto rounded-circle mb-3">
                            <img src="assets/images/element/coding.svg" alt="">
                        </div>
                        <!-- Title -->
                        <h5 class="mb-1"><a href="#" class="stretched-link"><?php echo $category_item['category_name']; ?></a></h5>
                        <?php
                        $count_course_in_category=$link->query("select count(*) as count from courses where cat_id=".$category_item['category_id']);
                        $count_course_in_category_item=$count_course_in_category->fetch_assoc();
                        ?>
                        <span class="mb-0"><?php echo $count_course_in_category_item['count']; ?> دوره آموزشی</span>
                    </div>
                </div>


                <?php
                }
                ?>

            </div>
        </div>
    </section>
    <!-- Category END -->

    <!-- Become a teacher START -->
    <section class="overflow-hidden">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-md-5 position-relative z-index-9">
                    <!-- Title -->
                    <h2 class="fs-3">مدرس شوید!</h2>
                    <p>طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>
                    <!-- Download button -->
                    <div class="row">
                        <!-- button -->
                        <div class="col-6 col-sm-4 col-md-6 col-lg-4">
                            <a href="#"><button class="btn btn-primary">همین حالا ثبت نام کنید</button></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 text-md-end position-relative">
                    <!-- Image -->
                    <img src="assets/images/element/07.svg" class="position-relative" alt="">
                </div>
            </div>
        </div>
    </section>
    <!-- Become a teacher END -->

    <!-- New course START -->
    <section class="pt-0 pt-md-5">
        <div class="container">
            <!-- Title -->
            <div class="row mb-4">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="mb-0">دوره های <span class="text-warning">جدید </span> آکادمی</h2>
                    <p class="mb-0">مشاهده دوره های جدید </p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Card Item START -->
                <?php
                $resultcourse = $link->query("SELECT courses.* , course_category.category_name as category_name FROM courses join course_category ON courses.cat_id=course_category.category_id ORDER BY courses.update_date DESC LIMIT 6 ");
                while($rowcourse = $resultcourse->fetch_assoc()){?>
                    <div class="col-md-6 col-xl-4">
                        <div class="card p-2 shadow h-100">
                            <div class="rounded-top overflow-hidden">
                                <div class="card-overlay-hover">
                                    <!-- Image -->
                                    <img src="files/courses/<?php echo $rowcourse['course_image']; ?>" class="card-img-top" alt="course image">
                                </div>
                                <!-- Hover element -->
                                <div class="card-img-overlay">
                                    <div class="card-element-hover d-flex justify-content-end">
                                        <a href="index.php?page=single&id=<?php echo $rowcourse['id']; ?>" class="icon-md bg-white rounded-circle text-center">
                                            <i class="fas fa-shopping-cart text-danger"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card body -->
                            <div class="card-body">
                                <!-- Rating and avatar -->
                                <div class="d-flex justify-content-between">
                                    <!-- Rating and info -->
                                    <ul class="list-inline hstack gap-2 mb-0">
                                        <!-- Info -->
                                        <li class="list-inline-item d-flex justify-content-center align-items-center">
                                            <div class="icon-md bg-orange bg-opacity-10 text-orange rounded-circle"><i class="fas fa-user-graduate"></i></div>
                                            <?php
                                            $cnParticipants=$link->query("SELECT count(*) as cn FROM cart WHERE course_id=".$rowcourse['id']." AND status=1");
                                            $rowParticipants=$cnParticipants->fetch_assoc();
                                            ?>
                                            <span class="h6 fw-light mb-0 ms-2"><?php echo $rowParticipants['cn'] ; ?></span>
                                        </li>
                                        <!-- Rating -->
                                        <li class="list-inline-item d-flex justify-content-center align-items-center">
                                            <div class="icon-md bg-warning bg-opacity-15 text-warning rounded-circle"><i class="fas fa-star"></i></div>
                                            <?php
                                            //avg-rating
                                            $sum=0;
                                            $countcom=$link->query("select count(*) as count from comments where course_id=".$rowcourse['id']);
                                            $rowcounrcom=$countcom->fetch_assoc();
                                            $avg_rating=$link->query("select comments.* , users.username as username from comments JOIN users ON comments.sender=users.id where comments.course_id=".$rowcourse['id']." order by comments.date desc ");
                                            while($rowavg=$avg_rating->fetch_assoc()){
                                                $sum+=$rowavg['rating'];
                                            }
                                            if($rowcounrcom['count']!=0){
                                                $avg_rating=round($sum/$rowcounrcom['count']);
                                            }
                                            else{
                                                $avg_rating=5;
                                            }

                                            ?>
                                            <span class="h6 fw-light mb-0 ms-2"><?php echo $avg_rating ; ?></span>
                                        </li>
                                    </ul>
                                    <!-- Avatar -->
                                    <div class="avatar avatar-sm">
                                        <img class="avatar-img rounded-circle" src="assets/images/avatar/09.jpg" alt="avatar">
                                    </div>
                                </div>
                                <!-- Divider -->
                                <hr>
                                <!-- Title -->
                                <h5 class="card-title fw-normal"><a href="index.php?page=single&id=<?php echo $rowcourse['id']; ?>"><?php echo $rowcourse['course_title']; ?></a></h5>
                                <!-- Badge and Price -->
                                <div class="d-flex justify-content-between align-items-center mb-0">
                                    <a href="#" class="badge bg-info bg-opacity-10 text-info me-2"><i class="fas fa-circle small fw-bold"></i><?php  echo ' '.$rowcourse['category_name']; ?> </a>
                                    <!-- Price -->
                                    <h3 class="text-success mb-0 fs-5 fw-normal"><?php if($rowcourse['course_price']!=0){echo priceFormat($rowcourse['course_price']).' تومان';} else{echo 'رایگان';}  ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }
                ?>
                <!-- Card Item END -->


            </div>
            <!-- Button -->
            <div class="text-center mt-5">
                <a href="index.php?page=all_course" class="btn btn-primary-soft mb-0">مشاهده همه  <i class="bi bi-arrow-left"></i></a>
            </div>
        </div>
    </section>
    <!-- New course END -->

    <!-- Client feedback START -->
    <section class="bg-light position-relative">
        <!-- SVG Image -->
        <figure class="position-absolute start-0 bottom-0 mb-0">
            <img src="assets/images/element/10.svg" class="h-200px" alt="">
        </figure>

        <div class="container">
            <!-- Title -->
            <div class="row mb-4">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fs-3">دیدگاه هنرجویان</h2>
                    <p class="mb-0">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.</p>
                </div>
            </div>

            <!-- Feedback START -->
            <div class="row">
                <!-- Slider START -->
                <div class="tiny-slider arrow-round arrow-creative arrow-dark arrow-hover">
                    <div class="tiny-slider-inner" data-autoplay="true" data-edge="5" data-arrow="true" data-dots="false" data-items="4" data-items-xl="3" data-items-md="2" data-items-xs="1">
                        <?php
                        $resultfeedback=$link->query("SELECT comments.* , users.username as username FROM `comments` JOIN users ON comments.sender=users.id LIMIT 8");
                        while($rowfeedback=$resultfeedback->fetch_assoc()){?>
                            <!-- Feedback item -->
                            <div>
                                <div class="bg-body text-center p-4 rounded-3 border border-1 position-relative">
                                    <!-- Avatar -->
                                    <div class="avatar avatar-lg mb-3">
                                        <img class="avatar-img rounded-circle" src="assets/images/avatar/05.jpg" alt="avatar">
                                    </div>
                                    <!-- Title -->
                                    <h6 class="mb-2"><?php echo $rowfeedback['username'] ; ?></h6>
                                    <!-- Content -->
                                    <blockquote class="mt-1">
                                        <p>
                                            <span class="me-1 small"><i class="fas fa-quote-left"></i></span>
                                            <?php echo $rowfeedback['content'] ; ?>
                                            <span class="ms-1 small"><i class="fas fa-quote-right"></i></span>
                                        </p>
                                    </blockquote>
                                </div>
                            </div>
                        <?php
                        }
                        ?>


                    </div>
                </div>
                <!-- Slider START -->
            </div>
            <!-- Feedback END -->
        </div>
    </section>
    <!-- Client feedback END -->



    <!-- Trending courses START -->
    <section class="pb-5 pt-0 pt-lg-5">
        <div class="container">
            <!-- Title -->
            <div class="row mb-4">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fs-3">دوره های پیشنهادی جشنواره</h2>
                    <p class="mb-0">مشاهده دوره های جدید و 🔥 در جشنواره</p>
                </div>
            </div>
            <div class="row">
                <!-- Slider START -->
                <div class="tiny-slider arrow-round arrow-blur arrow-hover">
                    <div class="tiny-slider-inner pb-1" data-autoplay="true" data-arrow="true" data-edge="2" data-dots="false" data-items="3" data-items-lg="2" data-items-sm="1">
                        <?php

                        $resultcourse = $link->query("SELECT courses.* , course_category.category_name as category_name FROM courses join course_category ON courses.cat_id=course_category.category_id ORDER BY courses.update_date DESC LIMIT 6 ");
                        while($rowcourse = $resultcourse->fetch_assoc()){?>
                        ?>
                        <!-- Card item START -->
                        <div>
                            <div class="card action-trigger-hover border bg-transparent">
                                <!-- Image -->
                                <img src="files/courses/<?php echo $rowcourse['course_image'] ; ?>" class="card-img-top" alt="course image">
                                <!-- Ribbon -->
                                <?php if($rowcourse['course_price']==0){ ?>
                                <div class="ribbon mt-3"><span>رایگان</span></div>
                                <?php } ?>
                                <!-- Card body -->
                                <div class="card-body pb-0">
                                    <!-- Badge and favorite -->
                                    <div class="d-flex justify-content-between mb-3">
									<span class="hstack gap-2">
										<a href="#" class="badge bg-primary bg-opacity-10 text-primary"><?php echo $rowcourse['category_name'] ; ?></a>
										<a href="#" class="badge text-bg-dark"><?php echo $rowcourse['level'] ; ?></a>
									</span>
                                    </div>
                                    <!-- Title -->
                                    <h5 class="card-title fw-normal mt-4"><a href="index.php?page=single&id=<?php echo $rowcourse['id']; ?>"><?php echo $rowcourse['course_title'] ; ?></a></h5>
                                    <!-- Rating -->

                                </div>
                                <!-- Card footer -->
                                <div class="card-footer pt-0 bg-transparent">
                                    <hr>
                                    <!-- Avatar and Price -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <!-- Avatar -->
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm">
                                                <img class="avatar-img rounded-1" src="assets/images/avatar/10.jpg" alt="avatar">
                                            </div>
                                            <p class="mb-0 ms-2"><a href="#" class="h6 fw-light mb-0">مهرداد نوروزی</a></p>
                                        </div>
                                        <!-- Price -->
                                        <div>
                                            <h5 class="text-success mb-0 item-show"><?php echo priceFormat($rowcourse['course_price']).' تومان' ; ?></h5>
                                            <a href="index.php?page=single&id=<?php echo $rowcourse['id']; ?>" class="btn btn-sm btn-success-soft item-show-hover"><i class="fas fa-shopping-cart me-2"></i>مشاهده ی دوره</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card item END -->
            <?php } ?>
                    </div>
                </div>
                <!-- Slider END -->
            </div>
        </div>
    </section>
    <!-- Trending courses END -->

    <!-- Banner START -->
    <section class="py-0">
        <div class="container">
            <div class="row g-4">
                <!-- Action box item -->
                <div class="col-lg-6 position-relative overflow-hidden">
                    <div class="bg-primary bg-opacity-10 rounded-3 p-5 h-100">
                        <!-- Image -->
                        <div class="position-absolute bottom-0 end-0 me-3">
                            <img src="assets/images/element/08.svg" class="h-100px h-sm-200px" alt="">
                        </div>
                        <!-- Content -->
                        <div class="row">
                            <div class="col-sm-8 position-relative">
                                <h2 class="mb-1 h4">اعطای مدرک معتبر</h2>
                                <p class="mb-3 h5 fw-light">برنامه گواهینامه حرفه ای مناسب را برای خود دریافت کنید.</p>
                                <a href="#" class="btn btn-primary mb-0">مشاهده</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action box item -->
                <div class="col-lg-6 position-relative overflow-hidden">
                    <div class="bg-secondary rounded-3 bg-opacity-10 p-5 h-100">
                        <!-- Image -->
                        <div class="position-absolute bottom-0 end-0 me-3">
                            <img src="assets/images/element/15.svg" class="h-100px h-sm-200px" alt="">
                        </div>
                        <!-- Content -->
                        <div class="row">
                            <div class="col-sm-8 position-relative">
                                <h2 class="mb-1 h4">بهترین دوره های آنلاین</h2>
                                <p class="mb-3 h5 fw-light">اکنون در محبوب ترین و بهترین دوره ها ثبت نام کنید.</p>
                                <a href="#" class="btn btn-warning mb-0">مشاهده</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner box END -->

    <!-- Blog START -->
    <section>
        <div class="container">
            <!-- Title -->
            <div class="row mb-4">
                <div class="d-md-flex justify-content-md-between align-items-center">
                    <h2 class="mb-2 mb-md-0 fs-3">آخرین مقالات</h2>
                    <div>
                        <span class="me-2">همه مقالات</span>
                        <a href="index.php?page=blog" class="btn btn-sm btn-primary-soft mb-0">مشاهده <i class="fas fa-angle-left ms-2"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Slider START -->
                <div class="tiny-slider arrow-round arrow-hover arrow-dark">
                    <div class="tiny-slider-inner" data-autoplay="false" data-arrow="true" data-edge="2" data-dots="false" data-items="4" data-items-lg="2" data-items-sm="1">

                        <?php
                        $more_articles=$link->query("SELECT * FROM articles ORDER BY id DESC LIMIT 5");
                        while ($row_blog=$more_articles->fetch_assoc()) {?>
                            <div class="col-3">
                                <div class="card shadow h-100">
                                    <div class="rounded-top overflow-hidden">
                                        <div class="card-overlay-hover">
                                            <!-- Image -->
                                            <img src="files/articles/<?php echo $row_blog['image']; ?>" class="card-img-top" alt="course image">
                                        </div>
                                        <!-- Hover element -->
                                        <div class="card-img-overlay">
                                            <div class="card-element-hover d-flex justify-content-end">
                                                <a href="index.php?page=blog_detail&id=<?php echo $row_blog['id']; ?>" class="icon-md bg-white rounded-circle text-center">
                                                    <i class="bi bi-eye-fill"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card body -->
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <!-- Title -->
                                        <h5 class="card-title fw-normal"><a href="index.php?page=blog_detail&id=<?php echo $row_blog['id']; ?>"><?php echo $row_blog['title'] ;?></a></h5>
                                        <p class="text-truncate-2"><?php echo strip_tags($row_blog['content']) ;?></p>
                                        <!-- Info -->
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-0 fw-normal"><i class="bi bi-vector-pen me-1"></i>ادمین</h6>
                                            <span class="small"><?php echo dateFormat($row_blog['published_at']) ;?></span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <?php
                        }
                        ?>
                    </div>
                </div>
                <!-- Slider START -->
            </div>

        </div>
    </section>
    <!-- Blog END -->


</main>


<?php
require_once 'includes/footer.php';
}
}
?>

