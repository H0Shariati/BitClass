<?php
defined('site') or die('ACCESS DENIED!');
if(isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'delete':
            $link->query("delete from courses where id=".$_GET['id']);


            if($link->errno==0 && $link->affected_rows==1){
                $message = '<script>toastr.success("عملیات حذف با موفقیت انجام شد");</script>';

            }
            else if($link->errno==1451){
                $message = '<script>toastr.error("این دوره به قسمت های دیگری مرتبط است و حذف ان باعث ایجاد مشکل می شود");</script>';
            }
            else if($link->errno>0){
                $message = '<script>toastr.error("خطا در حذف اطلاعات");</script>';

            }
            break;
    }
}
?>

<div class="page-content-wrapper border">

    <!-- Title -->
    <div class="row mb-3">
        <div class="col-12 d-sm-flex justify-content-between align-items-center">
            <h1 class="h3 mb-2 mb-sm-0 fs-5">لیست دوره ها</h1>
            <div>
                <a href="index.php?page=admin&section=add_course" class="btn btn-sm btn-primary mb-2">افزودن دوره جدید</a>
                <a href="index.php?page=admin&section=add_category" class="btn btn-sm btn-primary mb-2">افزودن دسته بندی جدید</a>

            </div>

        </div>
    </div>
    <?php

    if(isset($message)){
        echo $message;
    }
    ?>

    <!-- Course boxes START -->
    <div class="row g-4 mb-4">
        <!-- Course item -->
        <div class="col-sm-6 col-lg-4">
            <div class="text-center p-4 bg-primary bg-opacity-10 border border-primary rounded-3">
                <h6>دوره ها</h6>
                <?php
                $result = $link->query("SELECT COUNT(*) AS total FROM courses");
                $row = $result->fetch_assoc();
                ?>
                <h2 class="mb-0 fs-1 text-primary"><?php echo $row['total']; ?>
                </h2>
            </div>
        </div>

        <!-- Course item -->
        <div class="col-sm-6 col-lg-4">
            <div class="text-center p-4 bg-success bg-opacity-10 border border-success rounded-3">
                <h6>دوره های فعال</h6>
                <?php
                $result = $link->query("SELECT COUNT(*) AS total_active FROM courses WHERE status=1 ");
                $row = $result->fetch_assoc();
                ?>
                <h2 class="mb-0 fs-1 text-success"><?php echo $row['total_active']; ?></h2>
            </div>
        </div>

        <!-- Course item -->
        <div class="col-sm-6 col-lg-4">
            <div class="text-center p-4  bg-warning bg-opacity-15 border border-warning rounded-3">
                <h6>دوره های رایگان</h6>
                <?php
                $result = $link->query("SELECT COUNT(*) AS free FROM courses WHERE course_price=0 ");
                $row = $result->fetch_assoc();
                ?>
                <h2 class="mb-0 fs-1 text-warning"><?php echo $row['free']; ?></h2>
            </div>
        </div>
    </div>
    <!-- Course boxes END -->

    <!-- Card START -->
    <div class="card bg-transparent border">

        <!-- Card header START -->
        <div class="card-header bg-light border-bottom">
            <!-- Search and select START -->
            <div class="row g-3 align-items-center justify-content-between">
                <!-- Search bar -->
                <div class="col-md-7">
                    <form class="rounded position-relative" method="post">
                        <input name="search" class="form-control bg-body" type="text" placeholder="جستجوی دوره" >
                        <button name="sub" class="bg-transparent p-2 position-absolute top-50 end-0 translate-middle-y border-0 text-primary-hover text-reset" type="submit">
                            <i class="fas fa-search fs-6 "></i>
                        </button>
                    </form>
                </div>

                <!-- Select option -->
                <div class="col-md-4">
                    <!-- Short by filter -->
                    <form method="post" class="col-md-12 d-flex flex-row">
                        <select name="filter" style="width:80%" class="form-select  border-0 z-index-9 col-md-10"  aria-label=".form-select-sm">
                            <option value="0">مرتب سازی</option>
                            <option value="1" <?php if(isset($_POST['filtersub']) && $_POST['filter']==1){echo ' selected ';} ?>>جدیدترین</option>
                            <option value="2" <?php if(isset($_POST['filtersub']) && $_POST['filter']==2){echo ' selected ';} ?>>قدیمی ترین</option>
                            <option value="3" <?php if(isset($_POST['filtersub']) && $_POST['filter']==3){echo ' selected ';} ?>>ارزان ترین</option>
                            <option value="4" <?php if(isset($_POST['filtersub']) && $_POST['filter']==4){echo ' selected ';} ?>>گران ترین</option>
                        </select>
                        <button name="filtersub" type="submit" class="btn btn-primary mb-0 rounded z-index-1 col-md-2 ms-2"><i class="fas fa-search"></i></button>
                    </form>
                </div>
            </div>
            <!-- Search and select END -->
        </div>
        <!-- Card header END -->

        <!-- Card body START -->
        <div class="card-body">
            <div class="table-responsive border-0 rounded-3 ">
                <table class="table table-dark-gray align-middle p-4 mb-0 table-hover ">
                    <thead>
                    <tr>
                        <th>تصویر شاخص</th>
                        <th>نام دوره</th>
                        <th>سطح دوره</th>
                        <th>تاریخ ثبت</th>
                        <th>تاریخ به روزرسانی</th>
                        <th>قیمت دوره</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    if(isset($_POST["filtersub"])){
                        $filter = $_POST["filter"];
                        switch ($filter) {
                            case 0:
                                $resultcourse=$link->query("SELECT * FROM courses");
                                break;
                            case 1:
                                $resultcourse=$link->query("SELECT * FROM courses order by create_date ");
                                break;
                            case 2:
                                $resultcourse=$link->query("SELECT * FROM courses order by create_date DESC ");
                                break;
                            case 3:
                                $resultcourse=$link->query("SELECT * FROM courses order by course_price ");
                                break;
                            case 4:
                                $resultcourse=$link->query("SELECT * FROM courses order by course_price DESC ");
                                break;

                        }
                    }

                    elseif (isset($_POST['sub'])){
                        $resultcourse=$link->query("SELECT * FROM courses where courses.course_title like '%".$_POST['search']."%'");
                        if($resultcourse->num_rows==0){
                            echo '<div class="alert alert-danger">نتیجه ای یافت نشد</div>';
                        }

                    }
                    else{
                        $resultcourse = $link->query("SELECT * FROM courses");

                    }



                    while ($course = $resultcourse->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td><div class="w-60px"><img class="rounded" src="files/courses/'.$course['course_image'].'"></div></td>';
                        echo '<td>' . $course['course_title'] . '</td>';
                        echo '<td><span class="btn btn-info btn-xs"> ' . $course['level'] . '</span></td>';
                        echo '<td>' . dateFormat($course['create_date']) . '</td>';
                        echo '<td>' . dateFormat($course['update_date']) . '</td>';
                        echo '<td>' . priceFormat($course['course_price']).' تومان</td>';
                        echo '<td>' . ($course['status'] == 1 ? '<span class="btn btn-success btn-xs">فعال</span>' : '<span class="btn btn-danger btn-xs">غیر فعال</span>') . '</td>';
                        echo '<td style="white-space:nowrap;">';
                        echo '<a href="index.php?page=admin&section=edit_course&id=' . $course['id'] . '" class="btn btn-warning btn-sm mx-1"><i class="bi bi-pencil-square me-1"></i>ویرایش</a>';
                        echo '<a href="index.php?page=admin&section=course_part&id=' . $course['id'] . '" class="btn btn-primary btn-sm mx-1"><i class="bi bi-list-task me-1"></i>مدیریت جلسات</a>';
                        echo '<a href="index.php?page=admin&section=courses&action=delete&id='. $course['id'] . '" class="btn btn-danger btn-sm mx-1"><i class="bi bi-trash me-1"></i>حذف</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Card body END -->

        <!-- Card footer START -->
        <div class="card-footer bg-transparent pt-0">
            <!-- Pagination START -->
            <div class="d-sm-flex justify-content-sm-between align-items-sm-center">
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
        <!-- Card footer END -->
    </div>
    <!-- Card END -->
</div>
