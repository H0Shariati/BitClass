<?php
defined('site') or die('ACCESS DENIED!');

if(isset($_POST['sub'])){
    $errors = [];
    // اعتبارسنجی عنوان
    if(mb_strlen($_POST['title']) < 3) {
        $errors['title'] = 'مقدار عنوان نباید کمتر از 3 کاراکتر باشد';
    }

    // اعتبارسنجی وضعیت
    if(!isset($_POST['status']) || !in_array($_POST['status'], ['0', '1'])) {
        $errors['status'] = 'مقدار فیلد وضعیت نامعتبر می باشد';
    }

    // بررسی وجود مقدار sort در پایگاه داده
    $sort_value = (int)$_POST['sort'];
    $check_sort_query = $link->query("SELECT COUNT(*) as count FROM menu WHERE sort = $sort_value");
    $count_result = $check_sort_query->fetch_assoc();

    if($count_result['count'] > 0) {
        $errors['sort'] = 'این اولویت قبلاً برای یکی از منوها ثبت شده است. لطفا اولویت دیگری وارد کنید.';
    }

    // اگر خطاها وجود نداشته باشد، مقدار را وارد کنید
    if(count($errors) == 0) {
        $link->query("INSERT INTO menu (menu_title, submenu, sort, status) VALUES ('" . $link->real_escape_string($_POST['title']) . "', " . (int)$_POST['submenu'] . ", $sort_value, " . (int)$_POST['status'] . ")");

        if($link->errno == 0) {
            $message = '<script>toastr.success("ذخیره با موفقیت انجام شد");</script>';

        } else {
            $message = '<script>toastr.error("خطا در ذخیره اطلاعات");</script>';

        }
    }
}
if(isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'delete':
            $link->query("delete from menu where id=".$_GET['id']);

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
            <h1 class="h3 mb-2 mb-sm-0 fs-5">ایجاد منو جدید</h1>
        </div>
    </div>

    <div class="row g-4 mb-4 my-1">
        <div class="col-xxl-8">
            <div class="card shadow mb-2">
                <div class="card-body">
                    <?php
                    if(isset($message)){
                        echo $message;
                    }
                    ?>
                    <form method="post">
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">عنوان منو</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="title" value="<?php if(isset($rowupdate)) echo $rowupdate['title'];?>">
                                <?php if(isset($errors['title'])) echo '<div class="alert alert-danger">'.$errors['title'].'</div>'; ?>
                            </div>
                        </div><br>
<!--                        <div class="mb-3 row">-->
<!--                            <label class="col-sm-2 col-form-label">آیکون منو</label>-->
<!--                            <div class="col-sm-10">-->
<!--                                <div class="icon-selection">-->
<!--                                    <div class="icon-option" >-->
<!--                                        <i class="bi bi-journals"></i>-->
<!--                                    </div>-->
<!--                                    <div class="icon-option" >-->
<!--                                        <i class="bi bi-briefcase"></i>-->
<!--                                    </div>-->
<!--                                    <div class="icon-option" >-->
<!--                                        <i class="bi bi-info-square"></i>-->
<!--                                    </div>-->
<!--                                    <div class="icon-option" >-->
<!--                                        <i class="bi bi-headset"></i>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <input type="hidden" name="icon" id="selected-icon">-->
<!--                            </div>-->
<!--                        </div><br>-->

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">سر منو</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="submenu">
                                    <option value="0">بدون سر منو</option>
                                    <?php
                                    $resultmenu = $link->query("SELECT * FROM menu");
                                    while($rowmenu = $resultmenu->fetch_assoc()){
                                        echo '<option value="'.$rowmenu['id'].'">'.$rowmenu['menu_title'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div><br>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">اولویت بندی</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="sort" value="<?php if(isset($_POST['sort'])) echo $_POST['sort']; ?>">
                                <?php if(isset($errors['sort'])) echo '<div class="alert alert-danger">'.$errors['sort'].'</div>'; ?>
                            </div>
                        </div><br>

                        <div class="mb-3 ">
                            <label class="col-sm-2 col-form-label">وضعیت منو</label>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="status" value="1" id="st1" <?php if(isset($_POST['status']) && $_POST['status'] == 1) echo ' checked '; ?>>
                                <label class="form-check-label" for="st1">فعال</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="status" value="0" id="st0" <?php if(isset($_POST['status']) && $_POST['status'] == 0) echo ' checked '; ?>>
                                <label class="form-check-label" for="st0">غیرفعال</label>
                            </div>
                            <?php if(isset($errors['status'])) echo '<div class="alert alert-danger">'.$errors['status'].'</div>'; ?>
                        </div>

                        <div class="col-12 text-end">
                            <input type="submit" name="sub" value="افزودن" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Other Sections (Optional) -->
        <div class="col-xxl-4">
            <!-- Optional statistics or other display sections -->
            <div class="col-sm-12 col-lg-12 mb-4">
                <div class="text-center p-2 bg-primary bg-opacity-10 border border-primary rounded-3">
                    <h6>تعداد منو ها</h6>
                    <?php
                    $result = $link->query("SELECT COUNT(*) AS total FROM menu");
                    $row = $result->fetch_assoc();
                    ?>
                    <h2 class="mb-0 fs-1 text-primary"><?php echo $row['total']; ?></h2>
                </div>
            </div>
            <div class="col-sm-12 col-lg-12 mb-4">
                <div class="text-center p-2 bg-success bg-opacity-10 border border-success rounded-3">
                    <h6>منو های فعال</h6>
                    <?php
                    $result = $link->query("SELECT COUNT(*) AS total_active FROM menu WHERE status=1 ");
                    $row = $result->fetch_assoc();
                    ?>
                    <h2 class="mb-0 fs-1 text-success"><?php echo $row['total_active']; ?></h2>
                </div>
            </div>
            <div class="col-sm-12 col-lg-12 mb-4">
                <div class="text-center p-2 bg-warning bg-opacity-10 border border-warning rounded-3">
                    <h6 class="mt-2">بیشترین منوی استفاده شده</h6>
                    <span class="btn btn-warning btn-sm mt-2 "><h6 class="mb-1 fs-6 ">دسته بندی دوره ها</h6></span>


                </div>
            </div>


        </div>

        <!-- List Menu Section -->
        <div class="row my-2">
            <div class="col-12 d-sm-flex justify-content-between align-items-center">
                <h1 class="h3 mb-1 mb-sm-0 fs-5">لیست منو ها</h1>
            </div>
        </div>

        <div class="card bg-transparent my-2">
            <div class="card-header bg-light border-bottom">
                <div class="row g-3 align-items-center justify-content-between">
                    <div class="col-md-12">
                        <form method="post" class="rounded position-relative">
                            <input name="search" class="form-control bg-body" type="text" placeholder="جستجوی منو" aria-label="Search">
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
                            <th>عنوان</th>
                            <th>سرمنو</th>
                            <th>اولویت</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (isset($_POST['searchsub'])){
                            $resultmenu=$link->query("SELECT * FROM menu where menu.menu_title like '%".$_POST['search']."%'");
                            if($resultmenu->num_rows==0){
                                echo '<div class="alert alert-danger">نتیجه ای یافت نشد</div>';
                            }

                        }
                        else{
                            $resultmenu = $link->query("SELECT * FROM menu ORDER BY sort ASC");

                        }

                        $num = 1; // برای شماره گذاری ردیف‌ها

                        while ($menu = $resultmenu->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $num++ . '</td>';
                            echo '<td>' . $menu['menu_title'] . '</td>'; ?>
                            <td><span class="btn btn-info btn-sm">
                            <?php
                            // بررسی سرمنو
                            $submenu_id = $menu['submenu'];
                            if ($submenu_id != 0) {
                                $submenu_query = $link->query("SELECT menu_title FROM menu WHERE id = $submenu_id");
                                if ($submenu_query->num_rows > 0) {
                                    $submenu_row = $submenu_query->fetch_assoc();
                                    echo $submenu_row['menu_title'];
                                }
                            } else {
                                echo 'بدون سر منو';
                            }
                            ?></span></td>
                            <?php
                            echo '<td>' . $menu['sort'] . '</td>';
                            echo '<td>' . ($menu['status'] == 1 ? '<span class="btn btn-success btn-sm">فعال</span>' : '<span class="btn btn-danger btn-sm">غیر فعال</span>') . '</td>';
                            echo '<td>';
                            echo '<a href="index.php?page=admin&section=editmenu&id=' . $menu['id'] . '" class="btn btn-warning btn-sm mx-1"><i class="bi bi-pencil-square me-1"></i>ویرایش</a>';
                            $array = array(83,63,64);
                            if(!in_array($menu['id'],$array)){
                                echo '<a href="index.php?page=admin&section=menu&action=delete&id='. $menu['id'] . '" class="btn btn-danger btn-sm mx-1"><i class="bi bi-trash me-1"></i>حذف</a>';
                            }
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


