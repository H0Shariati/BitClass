<?php
require_once 'includes/header.php';
if(isset($_GET['section'])){
    switch ($_GET['section']) {
        case 'student_course_list':
            require_once 'student_course_list.php';
        break;
        case 'student_edit_profile':
            require_once 'student_edit_profile.php';
        break;
    }
}
?>
<section class="pt-6">
    <div class="container mt-n4">
        <div class="row">
            <div class="col-12">
                <div class="card bg-transparent card-body pb-0 px-0 mt-2 mt-sm-0">
                    <div class="row d-sm-flex justify-sm-content-between mt-2 mt-md-0">
                        <!-- Avatar -->
                        <div class="col-auto">
                            <div class="avatar avatar-xxl position-relative mt-n3">
                                <img class="avatar-img rounded-circle border border-white border-3 shadow" src="assets/images/avatar/default.jpg" alt="">
                                <?php
                                switch ($_SESSION['role']) {
                                    case '2':
                                        $role = 'مدرس';
                                    break;
                                    case '3':
                                        $role = 'دانشجو';
                                    break;

                                }
                                ?>
                                <span class="badge text-bg-success rounded-pill position-absolute top-50 start-100 translate-middle mt-4 mt-md-5 ms-n3 px-md-3"><?php echo $role ; ?></span>
                            </div>
                        </div>
                        <!-- Profile info -->
                        <div class="col d-sm-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="my-1 fs-4"><?php echo  $_SESSION['username']; ?></h1>
                                <ul class="list-inline mb-0">
                                    <?php
                                    $count_course_pay=$link->query("select count(*) as count from cart where user_id=".$_SESSION['login']);
                                    $row_count_course_pay=$count_course_pay->fetch_array();
                                    ?>
                                    <li class="list-inline-item me-3 mb-1 mb-sm-0">
                                        <span class="h6"><?php echo $row_count_course_pay['count']; ?></span>
                                        <span class="text-body fw-light">دوره خریداری شده</span>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Advanced filter responsive toggler START -->
                <!-- Divider -->
                <hr class="d-xl-none">
                <div class="col-12 col-xl-3 d-flex justify-content-between align-items-center">
                    <a class="h6 mb-0 fw-bold d-xl-none" href="#">منو</a>
                    <button class="btn btn-primary d-xl-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
                        <i class="fas fa-sliders-h"></i>
                    </button>
                </div>
                <!-- Advanced filter responsive toggler END -->
            </div>
        </div>
    </div>
</section>
<section class="pt-0">
    <div class="container">
        <div class="row">

            <!-- Left sidebar START -->
            <div class="col-xl-3">
                <!-- Responsive offcanvas body START -->
                <div class="offcanvas-xl offcanvas-end" tabindex="-1" id="offcanvasSidebar">
                    <!-- Offcanvas header -->
                    <div class="offcanvas-header bg-light">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">پروفایل من</h5>
                        <button  type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasSidebar" aria-label="Close"></button>
                    </div>
                    <!-- Offcanvas body -->
                    <div class="offcanvas-body p-3 p-xl-0">
                        <div class="bg-dark border rounded-3 p-3 w-100">
                            <!-- Dashboard menu -->
                            <div class="list-group list-group-dark list-group-borderless collapse-list">
                                <a class="list-group-item active" href="#"><i class="bi bi-ui-checks-grid fa-fw me-2"></i>داشبورد</a>
                                <a class="list-group-item" href="index.php?page=student&section=student_course_list"><i class="bi bi-basket fa-fw me-2"></i>لیست دوره های خریداری شده</a>
                                <a class="list-group-item" href="index.php?page=student&section=student_edit_profile"><i class="bi bi-pencil-square fa-fw me-2"></i>ویرایش پروفایل</a>
                                <a class="list-group-item text-danger bg-danger-soft-hover" href="index.php?logout"><i class="fas fa-sign-out-alt fa-fw me-2"></i>خروج</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Responsive offcanvas body END -->
            </div>
            <!-- Left sidebar END -->

            <!-- Main content START -->
            <div class="col-xl-9">

                <!-- Counter boxes START -->
                <div class="row mb-4">
                    <!-- Counter item -->
                    <div class="col-sm-6 col-lg-4 mb-3 mb-lg-0">
                        <div class="d-flex justify-content-center align-items-center p-4 bg-orange bg-opacity-15 rounded-3">
                            <span class="display-6 lh-1 text-orange mb-0"><i class="fas fa-tv fa-fw"></i></span>
                            <div class="ms-4">
                                <div class="d-flex">
                                    <h5 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="<?php echo $row_count_course_pay['count']; ?>"	data-purecounter-delay="200">0</h5>
                                </div>
                                <p class="mb-0 h6 fw-light">دوره های خریداری شده</p>
                            </div>
                        </div>
                    </div>
                    <!-- Counter item -->
                    <div class="col-sm-6 col-lg-4 mb-3 mb-lg-0">
                        <div class="d-flex justify-content-center align-items-center p-4 bg-purple bg-opacity-15 rounded-3">
                            <span class="display-6 lh-1 text-purple mb-0"><i class="fas fa-clipboard-check fa-fw"></i></span>
                            <div class="ms-4">
                                <?php
                                $total_price_cart = $link->query("SELECT cart.*, courses.course_price as price FROM cart join users on cart.user_id=users.id join courses on cart.course_id=courses.id where cart.status=1 and user_id=".$_SESSION['login']);
                                $total_price=0;
                                while ($row_price = $total_price_cart->fetch_assoc()) {
                                    $total_price=$total_price+$row_price['price'];
                                }?>
                                <div class="d-flex">
                                    <h5 class="mb-0 fw-bold"><?php echo priceFormat($total_price).' تومان';?></h5>
                                </div>
                                <p class="mb-0 h6 fw-light">جمع مبلغ خرید ها</p>
                            </div>
                        </div>
                    </div>
                    <!-- Counter item -->
                    <div class="col-sm-6 col-lg-4 mb-3 mb-lg-0">
                        <div class="d-flex justify-content-center align-items-center p-4 bg-success bg-opacity-10 rounded-3">
                            <span class="display-6 lh-1 text-success mb-0"><i class="bi bi-stopwatch-fill fa-fw"></i></span>
                            <div class="d-flex flex-column">
                                <div class="">
                                    <h4>
                                        <div id="clock"></div>

                                        <script>
                                            function updateClock() {
                                                const now = new Date();
                                                const hours = now.getHours().toString().padStart(2, '0');
                                                const minutes = now.getMinutes().toString().padStart(2, '0');
                                                const seconds = now.getSeconds().toString().padStart(2, '0');

                                                document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
                                            }

                                            setInterval(updateClock, 1000);
                                            updateClock(); // برای نمایش سریع در لحظه اول
                                        </script>

                                    </h4>
                                </div>
                                <h2 class="mb-0 h6 mt-1">
                                    <?php $time=time(); echo dateFormat($time); ?>
                                </h2>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Counter boxes END -->

                <div class="card bg-transparent border rounded-3">
                    <!-- Card header START -->
                    <div class="card-header bg-transparent border-bottom">
                        <h3 class="mb-0 fs-5 ff-vb">لیست دوره های من</h3>
                    </div>
                    <!-- Card header END -->

                    <!-- Card body START -->
                    <div class="card-body">

                        <!-- Search and select START -->
                        <div class="row g-3 align-items-center justify-content-between mb-4">
                            <!-- Content -->
                            <div class="col-md-8">
                                <form class="rounded position-relative">
                                    <input class="form-control pe-5 bg-transparent" type="search" placeholder="جستجوی دوره" aria-label="Search">
                                    <button class="bg-transparent p-2 position-absolute top-50 end-0 translate-middle-y border-0 text-primary-hover text-reset" type="submit">
                                        <i class="fas fa-search fs-6 "></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Select option -->
                            <div class="col-md-3">
                                <!-- Short by filter -->
                                <form>
                                    <select class="form-select js-choice border-0 z-index-9 bg-transparent" aria-label=".form-select-sm">
                                        <option value="">مرتب سازی</option>
                                        <option>رایگان</option>
                                        <option>جدیدترین</option>
                                        <option>پربازدیدترین</option>
                                        <option>پرفروش ترین</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        <!-- Search and select END -->
                        <?php
                        $course=$link->query("SELECT courses.* FROM cart join courses on cart.course_id=courses.id WHERE cart.user_id=".$_SESSION['login']." and cart.status=1");
                        while ($row_course = $course->fetch_assoc()) {?>
                            <div class="card rounded overflow-hidden shadow mb-4">
                                <div class="row g-0">
                                    <!-- Image -->
                                    <div class="col-md-3">
                                        <img src="files/courses/<?php echo $row_course['course_image']; ?>" alt="card image">
                                    </div>

                                    <!-- Card body -->
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <!-- Title -->
                                            <div class="d-flex justify-content-between mb-2 mb-sm-3">
                                                <h5 class="card-title mb-0"><a href="index.php?page=single&id=<?php echo $row_course['id']; ?>"><?php echo $row_course['course_title']; ?></a></h5>
                                                <!-- Wishlist icon -->
                                                <a href="index.php?page=single&id=<?php echo $row_course['id']; ?>" class="btn btn-info-soft">ادامه دوره</a>
                                            </div>
                                            <!-- Content -->
                                            <!-- Info -->
                                            <ul class="list-inline mb-2">
                                                <?php $cnpart=$link->query("select COUNT(*) AS cn from course_part where course_id=".$row_course['id']);
                                                $cnpartrow=$cnpart->fetch_assoc();
                                                ?>
                                                <?php
                                                $total_time_query = $link->query("SELECT time_video FROM course_part WHERE course_id=" . $row_course['id']);
                                                $total_time_seconds = 0;

                                                while($row = $total_time_query->fetch_assoc()) {
                                                    $total_time_seconds += (float)$row['time_video'];
                                                }?>
                                                <li class="list-inline-item text-dark mb-1 mb-sm-0"><i class="far fa-clock text-danger ms-2 me-2"></i><?php echo $total_time_seconds.' دقیقه' ; ?></li>
                                                <li class="list-inline-item text-dark mb-1 mb-sm-0 "><i class="fas fa-table text-orange me-2 ms-2"></i><?php echo $cnpartrow['cn'].' جلسه' ; ?></li>
                                                <li class="list-inline-item text-dark"><i class="fas fa-signal text-success ms-2 me-2"></i><?php echo $row_course['level']; ?></li>
                                            </ul>

                                            <div class="overflow-hidden">
                                                <h6 class="mb-0 text-end">  درصد پیشرفت دوره 85%</h6>
                                                <div class="progress progress-sm bg-primary bg-opacity-10">
                                                    <div class="progress-bar bg-totalsecondary aos" role="progressbar" data-aos="slide-left" data-aos-delay="200" data-aos-duration="1000" data-aos-easing="ease-in-out" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php

                        }
                        ?>
                        <!-- Pagination START -->
                        <div class="d-sm-flex justify-content-sm-between align-items-sm-center mt-4 mt-sm-3">
                            <!-- Content -->
                            <p class="mb-0 text-center text-sm-start">نمایش 1 تا 8 از 20</p>
                            <!-- Pagination -->
                            <nav class="d-flex justify-content-center mb-0" aria-label="navigation">
                                <ul class="pagination pagination-sm pagination-primary-soft d-inline-block d-md-flex rounded mb-0">
                                    <li class="page-item mb-0"><a class="page-link" href="#" tabindex="-1"><i class="fas fa-angle-right"></i></a></li>
                                    <li class="page-item mb-0"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item mb-0 active"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item mb-0"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item mb-0"><a class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li>
                                </ul>
                            </nav>
                        </div>
                        <!-- Pagination END -->
                    </div>
                    <!-- Card body START -->
                </div>
                <!-- Main content END -->
            </div><!-- Row END -->
        </div>
    </div>
</section>

<?php
require_once 'includes/footer.php';
?>
