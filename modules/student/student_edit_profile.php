<?php
require_once 'includes/header.php';
if(isset($_POST['sub'])){
    $errors=[];
    $firstname=clean($_POST['firstname']);
    if(isset($firstname) && mb_strlen($firstname)<2){
        $errors['firstname']="نام  باید حداقل 2 کاراکتر باشد";
    }

    $lastname=clean($_POST['lastname']);
    if(isset($lastname) && mb_strlen($lastname)<2){
        $errors['lastname']="نام خانوادگی باید حداقل 2 کاراکتر باشد";
    }


    $phone_number=clean($_POST['phone_number']);
    if(isset($phone_number)){
        if(!preg_match('/^[0-9]+$/', $phone_number)){
            $errors['phone_number']="شماره تماس باید فقط عدد باشد";
        } elseif(mb_strlen($phone_number)<10){
            $errors['phone_number']="شماره تماس باید حداقل ۱۰ رقم باشد";
        }
    }

    if(count($errors)==0){

            $link->query("UPDATE users SET firstname='".$firstname."',lastname='".$lastname."',phone_number='".$phone_number."' WHERE id=".$_SESSION['login']);

            if($link->errno==0 ){
                $message = '<script>toastr.success("ویرایش با موفقیت انجام شد");</script>';
//                echo '<script>window.location="index.php?page=admin&section=menu";</script>';
            }
            else{
                $message = '<script>toastr.error("خطا در ویرایش اطلاعات");</script>';
            }
    }

}
$resultUser = $link -> query("SELECT * FROM users where id = ".$_SESSION['login']);
if($resultUser -> num_rows > 0){
    $rowUpdate = $resultUser -> fetch_assoc();
}
if(isset($_POST['change_pass'])){
    $errors=[];
    if($rowUpdate['password'] != md5($_POST['before_password'])){
        $message = '<script>toastr.error("رمز عبور فعلی درست نیست");</script>';

    }
    if(strlen($_POST['new_password']) < 8 ){
        $errors['new_password'] = "رمز عبور باید حداقل 8 کاراکتر باشد";
    }
    if ($_POST['new_password'] != $_POST['confirm_password']){
        $errors['confirm_password'] = "رمز عبور و تکرار آن برابر نیستند ";
    }
    if(count($errors)==0){
        $updateResult = $link->query("UPDATE users SET password = '" . md5($_POST['new_password']) . "' where id=".$_SESSION['login']);
        if($link -> errno == 0){
            $message = '<script>toastr.success("رمز عبور با موفقیت تغییر یافت");</script>';

        }
        else{
            $message = '<script>toastr.error("خطایی هنگام تغییر رمز رخ داد.");</script>';
        }
    }

}
$resultuser=$link->query("select * from users where id=".$_SESSION['login']);
$user=$resultuser->fetch_assoc()

?>
<section class="pt-6">
    <?php
    if(isset($message)){
        echo $message;
    }
    ?>
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
                                <a class="list-group-item " href="index.php?page=student&section=student_course_list"><i class="bi bi-basket fa-fw me-2"></i>لیست دوره های خریداری شده</a>
                                <a class="list-group-item active" href="index.php?page=student&section=student_edit_profile"><i class="bi bi-pencil-square fa-fw me-2"></i>ویرایش پروفایل</a>
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
                <!-- Edit profile START -->
                <div class="card bg-transparent border rounded-3">
                    <!-- Card header -->
                    <div class="card-header bg-transparent border-bottom">
                        <h3 class="card-header-title mb-0 ff-vb fs-5">ویرایش پروفایل</h3>
                    </div>
                    <!-- Card body START -->
                    <div class="card-body">
                        <!-- Form -->
                        <form class="row g-4" method="post">

                            <!-- Full name -->
                            <div class="col-12">
                                <label class="form-label">نام</label>
                                <div class="input-group">
                                    <input name="firstname" type="text" class="form-control" value="<?php if(isset($_POST['sub'])){echo $firstname;}else{echo $user['firstname'] ;}  ?>" placeholder="نام">
                                    <?php
                                    if(isset($errors['firstname'])){
                                        echo '<div class="alert alert-danger">'.$errors['firstname'].'</div>';
                                    }
                                    ?>
                                    <input name="lastname" type="text" class="form-control" value="<?php if(isset($_POST['sub'])){echo $lastname;}else{echo $user['lastname'] ;}  ?>" placeholder="نام خانوادگی">
                                    <?php
                                    if(isset($errors['lastname'])){
                                        echo '<div class="alert alert-danger">'.$errors['lastname'].'</div>';
                                    }
                                    ?>
                                </div>
                            </div>

                            <!-- Username -->
                            <div class="col-md-6">
                                <label class="form-label">نام کاربری</label>
                                <div class="input-group">

                                    <input name="username" type="text" class="form-control" value="<?php echo $user['username']; ?>" disabled>
                                    <?php
                                    if(isset($errors['username'])){
                                        echo '<div class="alert alert-danger">'.$errors['username'].'</div>';
                                    }
                                    ?>
                                </div>
                            </div>

                            <!-- Email id -->
                            <div class="col-md-6">
                                <label class="form-label">ایمیل</label>
                                <input name="email" class="form-control" type="email" value="<?php echo $user['email']; ?>"  placeholder="ایمیل" disabled>
                                <?php
                                if(isset($errors['email'])){
                                    echo '<div class="alert alert-danger">'.$errors['email'].'</div>';
                                }
                                ?>
                            </div>

                            <!-- Phone number -->
                            <div class="col-md-6">
                                <label class="form-label">شماره تماس</label>
                                <input name="phone_number" type="text" class="form-control" value="<?php if(isset($_POST['sub'])){echo $phone_number;}else{echo $user['phone_number'] ;}  ?>" placeholder="شماره تماس">
                                <?php
                                if(isset($errors['phone_number'])){
                                    echo '<div class="alert alert-danger">'.$errors['phone_number'].'</div>';
                                }
                                ?>
                            </div>

                            <!-- Save button -->
                            <div class="d-sm-flex justify-content-end">
                                <button type="submit" name="sub" class="btn btn-primary mb-0">تغییر و ذخیره</button>
                            </div>
                        </form>
                    </div>
                    <!-- Card body END -->
                </div>
                <!-- Edit profile END -->

                <div class="row g-4 mt-3">

                    <!-- Password change START -->

                    <div class="col-lg-6">
                        <div class="card border bg-transparent rounded-3">
                            <!-- Card header -->
                            <div class="card-header bg-transparent border-bottom">
                                <h5 class="card-header-title mb-0">تغییر رمز عبور</h5>
                            </div>
                            <!-- Card body START -->
                            <div class="card-body">
                                <form method="post">
                                <!-- Current password -->
                                <div class="mb-3">
                                    <label class="form-label">رمز فعلی</label>
                                    <input name="before_password" class="form-control" type="password" placeholder="********"><?php
                                    if(isset($errors['before_password'])){
                                        echo '<div class="alert alert-danger">'.$errors['before_password'].'</div>';
                                    }
                                    ?>
                                </div>
                                <!-- New password -->
                                <div class="mb-3">
                                    <label class="form-label"> رمز جدید</label>
                                    <div class="input-group">
                                        <input name="new_password" class="form-control" type="password" placeholder="********"><?php
                                        if(isset($errors['new_password'])){
                                            echo '<div class="alert alert-danger">'.$errors['new_password'].'</div>';
                                        }
                                        ?>
                                    </div>
                                    <div class="rounded mt-1" id="psw-strength"></div>
                                </div>
                                <!-- Confirm password -->
                                <div>
                                    <label class="form-label">تایید رمز جدید</label>
                                    <input name="confirm_password" class="form-control" type="password" placeholder="********"><?php
                                    if(isset($errors['confirm_password'])){
                                        echo '<div class="alert alert-danger">'.$errors['confirm_password'].'</div>';
                                    }
                                    ?>
                                </div>
                                <!-- Button -->
                                <div class="d-flex justify-content-end mt-4">
                                    <button type="submit" name="change_pass" class="btn btn-primary mb-0">تغییر رمز</button>
                                </div>
                                </form>
                            </div>
                            <!-- Card body END -->
                        </div>
                    </div>
                    <!-- Password change end -->
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once 'includes/footer.php';
?>
