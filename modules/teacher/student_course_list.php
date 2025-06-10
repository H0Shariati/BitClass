<?php
require_once 'includes/header.php';
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
                                <a class="list-group-item " href="index.php?page=student"><i class="bi bi-ui-checks-grid fa-fw me-2"></i>داشبورد</a>
                                <a class="list-group-item active" href="index.php?page=student&section=student_course_list"><i class="bi bi-basket fa-fw me-2"></i>لیست دوره های خریداری شده</a>
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

                        <!-- Course list table START -->
                        <div class="table-responsive border-0">
                            <table class="table table-dark-gray align-middle p-4 mb-0 table-hover">
                                <!-- Table head -->
                                <thead>
                                <tr>
                                    <th scope="col" class="border-0 rounded-start">دوره</th>
                                    <th scope="col" class="border-0">جلسات</th>
                                    <th scope="col" class="border-0">قیمت</th>
                                    <th scope="col" class="border-0">وضعیت پرداخت</th>
                                    <th scope="col" class="border-0 rounded-end">عملیات</th>
                                </tr>
                                </thead>

                                <!-- Table body START -->
                                <tbody>
                                <!-- Table item -->
                                <?php
                                $course=$link->query("SELECT courses.*,cart.status as price_status FROM cart join courses on cart.course_id=courses.id WHERE cart.user_id=".$_SESSION['login']);
                                while ($row_course = $course->fetch_assoc()) {?>
                                <tr>
                                    <!-- Table data -->
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <!-- Image -->
                                            <div class="w-100px">
                                                <img src="files/courses/<?php echo $row_course['course_image']; ?>" class="rounded" alt="">
                                            </div>
                                            <div class="mb-0 ms-2">
                                                <!-- Title -->
                                                <h6 class="fw-normal"><a href="index.php?page=single&id=<?php echo $row_course['id']; ?>"><?php echo $row_course['course_title']; ?></a></h6>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Table data -->
                                    <?php $cnpart=$link->query("select COUNT(*) AS cn from course_part where course_id=".$row_course['id']);
                                    $cnpartrow=$cnpart->fetch_assoc();
                                    ?>
                                    <td><?php echo $cnpartrow['cn']; ?></td>
                                    <td><?php echo priceFormat($row_course['course_price']).' تومان'; ?></td>
                                    <?php echo '<td>';
                                    if($row_course['price_status']==1){?>
                                        <a href="#" class="btn btn-sm btn-success-soft me-1 mb-1 mb-md-0">پرداخت شده</a>

                                    <?php
                                    }
                                    else {?>
                                        <a href="index.php?page=cart" class="btn btn-sm btn-danger-soft me-1 mb-1 mb-md-0">پرداخت نشده</a>
                                    <?php
                                    }
                                    echo '</td>';
                                    ?>


                                    <!-- Table data -->

                                    <td>
                                        <?php
                                        if($row_course['price_status']==1){?>
                                            <a href="index.php?page=single&id=<?php echo $row_course['id']; ?>" class="btn btn-sm btn-primary-soft me-1 mb-1 mb-md-0"><i class="bi bi-play-circle me-1"></i>ادامه</a>
                                            <?php
                                        }
                                        ?>

                                    </td>
                                </tr>
                                <?php } ?>

                                </tbody>
                                <!-- Table body END -->
                            </table>
                        </div>
                        <!-- Course list table END -->

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

            </div><!-- Row END -->
        </div>
    </div>
</section>

<?php
require_once 'includes/footer.php';
?>
