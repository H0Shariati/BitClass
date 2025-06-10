<?php
defined('site') or die('ACCESS DENIED!');

if(isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'delete':
            $link->query("delete from users where id=".$_GET['id']);

            if($link->errno==0 && $link->affected_rows==1){
                $message = '<script>toastr.success("عملیات حذف با موفقیت انجام شد");</script>';
            }
            else if($link->errno==1451){
                $message = '<script>toastr.error("کلید خارجی");</script>';
            }
            else if($link->errno>0){
                $message = '<script>toastr.error("خطا در حذف اطلاعات");</script>';

            }
            break;
    }
}
?>
<style>
    .icon-selection {
        display: flex;
        flex-wrap: wrap;
    }

    .icon-option {
        margin: 5px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .icon-option:hover {
        background-color: #e0e0e0;
    }

    .icon-option.selected {
        border-color: #007bff;
        background-color: #007bff;
        color: white;
    }  </style>

<div class="page-content-wrapper border">
    <!-- Title and Form Section -->
    <div class="row">
        <div class="col-12 mb-3">
            <h1 class="h3 mb-2 mb-sm-0 fs-5">لیست کاربران سایت</h1>
        </div>
    </div>

    <div class="row g-4 mb-4 my-1">
        <?php
        if(isset($message)){
            echo $message;
        }
        ?>

        <!-- Other Sections (Optional) -->
        <div class="row g-4 mb-4">
            <!-- Course item -->
            <div class="col-sm-6 col-lg-4">
                <div class="text-center p-4 bg-primary bg-opacity-10 border border-primary rounded-3">
                    <h6>تعداد کل کاربران</h6>
                    <?php
                    $resultusers = $link->query("SELECT COUNT(*) AS total FROM users");
                    $rowuser = $resultusers->fetch_assoc();
                    ?>
                    <h2 class="mb-0 fs-1 text-primary"><?php echo $rowuser['total']; ?>
                    </h2>
                </div>
            </div>

            <!-- Course item -->
            <div class="col-sm-6 col-lg-4">
                <div class="text-center p-4 bg-success bg-opacity-10 border border-success rounded-3">
                    <h6>تعداد مدرسین</h6>
                    <?php
                    $resultusers = $link->query("SELECT COUNT(*) AS total_teacher FROM users WHERE role=2 ");
                    $rowuser = $resultusers->fetch_assoc();
                    ?>
                    <h2 class="mb-0 fs-1 text-success"><?php echo $rowuser['total_teacher']; ?></h2>
                </div>
            </div>

            <!-- Course item -->
            <div class="col-sm-6 col-lg-4">
                <div class="text-center p-4  bg-warning bg-opacity-15 border border-warning rounded-3">
                    <h6>تعداد هنرجویان</h6>
                    <?php
                    $resultusers = $link->query("SELECT COUNT(*) AS total_student FROM users WHERE role=3 ");
                    $rowuser = $resultusers->fetch_assoc();
                    ?>
                    <h2 class="mb-0 fs-1 text-warning"><?php echo $rowuser['total_student']; ?></h2>
                </div>
            </div>
        </div>

        <!-- List Menu Section -->
        <div class="row my-2">
            <div class="col-12 d-sm-flex justify-content-between align-items-center">
                <h1 class="h3 mb-1 mb-sm-0 fs-5">لیست کاربران</h1>
            </div>
        </div>

        <div class="card bg-transparent my-2">
            <div class="card-header bg-light border-bottom">
                <div class="row g-3 align-items-center justify-content-between">
                    <div class="col-md-12">
                        <form method="post" class="rounded position-relative">
                            <input name="search" class="form-control bg-body" type="text" placeholder="جستجوی کاربر" aria-label="Search">
                            <button name="searchsub" class="bg-transparent p-2 position-absolute top-50 end-0 translate-middle-y border-0 text-primary-hover text-reset" type="submit">
                                <i class="fas fa-search fs-6 "></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive border-0 rounded-3">
                    <table class="table table-dark-gray align-middle p-4 mb-0 table-hover">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام کاربری</th>
                            <th>ایمیل</th>
                            <th>تاریخ عضویت</th>
                            <th>سطح کاربری</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (isset($_POST['searchsub'])){
                            $resultusers=$link->query("SELECT * FROM users where users.username like '%".$_POST['search']."%'");
                            if($resultusers->num_rows==0){
                                echo '<div class="alert alert-danger">نتیجه ای یافت نشد</div>';
                            }

                        }
                        else{
                            $resultusers = $link->query("SELECT * FROM users");

                        }
                        $num = 1; // برای شماره گذاری ردیف‌ها

                        while ($user = $resultusers->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $num++ . '</td>';
                            echo '<td>' . $user['username'] . '</td>';
                            echo '<td>' . $user['email'] . '</td>';
                            $gregorianDate = $user['created_at'];
                            $timestamp = strtotime($gregorianDate);
                            $jalaliDate = jdate('Y/m/d', $timestamp);
                            echo '<td>' . $jalaliDate . '</td>';
                            switch ($user['role']) {
                                case 1:
                                    echo '<td><span class="btn btn-info btn-sm">مدیر سایت</span></td>';
                                break;
                                case 2:
                                    echo '<td><span class="btn btn-info btn-sm">مدرس</span></td>';
                                break;
                                case 3:
                                    echo '<td><span class="btn btn-info btn-sm">دانشجو</span></td>';
                                break;
                            }
                            echo '<td>';
                            echo '<a href="index.php?page=admin&section=edit_user&id=' . $user['id'] . '" class="btn btn-warning btn-sm mx-1"><i class="bi bi-pencil-square me-1"></i>ویرایش</a>';
                            echo '<a href="index.php?page=admin&section=users&action=delete&id='. $user['id'] . '" class="btn btn-danger btn-sm mx-1"><i class="bi bi-trash me-1"></i>حذف</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-transparent pt-0">
                <div class="d-sm-flex justify-content-sm-between align-items-sm-center">
                    <p class="mb-0 text-center text-sm-start">نمایش 1 تا 8 از 20</p>
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
            </div>
        </div>
    </div>
</div>


