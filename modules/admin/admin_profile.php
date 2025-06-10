<?php
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
        } elseif(mb_strlen($phone_number)!=10){
            $errors['phone_number']="شماره تماس باید  ۱۰ رقم باشد";
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
if(isset($_POST['change_pass'])){
    $errors=[];
    $before_password = trim($_POST['before_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    $result = $link->query("SELECT password FROM users WHERE id=".$_SESSION['login']);
    if($result && $result->num_rows > 0){
        $user = $result->fetch_assoc();
        $hashedPassword = $user['password'];
    } else {
        $errors['general'] = "خطایی در بانک اطلاعاتی رخ داد.";
    }

    // اعتبارسنجی رمز فعلی
    if(empty($before_password)){
        $errors['before_password'] = "لطفاً رمز فعلی خود را وارد کنید.";
    } elseif(!password_verify($before_password, $hashedPassword)){
        $errors['before_password'] = "رمز فعلی نادرست است.";
    }

    // اعتبارسنجی رمز جدید
    if(empty($new_password)){
        $errors['new_password'] = "لطفاً رمز جدید را وارد کنید.";
    } elseif(mb_strlen($new_password) < 8){
        $errors['new_password'] = "رمز عبور حداقل باید ۸ کاراکتر باشد.";
    }

    // تایید رمز جدید
    if($new_password !== $confirm_password){
        $errors['confirm_password'] = "تایید رمز عبور مطابقت ندارد.";
    }

    if(count($errors)==0){
        $newHashedPassword = md5($new_password);
        $update = $link->query("UPDATE users SET password='".$link->real_escape_string($newHashedPassword)."' WHERE id=".$_SESSION['login']);
        if($update){
            $message = '<script>toastr.success("رمز عبور با موفقیت تغییر یافت");</script>';
        } else {
            $message = '<script>toastr.error("خطایی هنگام تغییر رمز رخ داد.");</script>';
        }
    }

}
$resultuser=$link->query("select * from users where id=".$_SESSION['login']);
$user=$resultuser->fetch_assoc()

?>
<div class="page-content-wrapper border">
    <div class="row">
        <section class="pt-0">
            <?php
            if(isset($message)){
                echo $message;
            }
            ?>
            <div class="container">
                <div class="row">


                    <!-- Main content START -->
                    <div class="col-xl-8">
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
                    </div>
                        <!-- Edit profile END -->

                        <div class="g-4 mt-3 col-4">

                            <!-- Password change START -->

                            <div class="">
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
        </section>

    </div>

