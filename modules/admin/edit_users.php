<?php
defined('site') or die('ACCESS DENIED!');
require_once 'modules/admin/includes/header-sidebar.php';
if(isset($_POST['edit'])){
    $errors=[];
    if(mb_strlen($_POST['username'])<3) {
        $errors['username']='مقدار نام کاربری نباید کمتر از 3 کاراکتر باشد';
    }
    if(count($errors)==0){
        $date = new DateTime(); // ایجاد یک شیء DateTime برای زمان کنونی
        $date->modify('+3 hours 30 minutes'); // افزودن 3.5 ساعت به زمان کنونی
        $formattedDate = $date->format('Y-m-d H:i:s');

        $link->query("UPDATE users SET username='".$link->real_escape_string($_POST['username'])."', email='".$link->real_escape_string($_POST['email'])."', role='".$_POST['role']."', updated_at='".$formattedDate."' WHERE id=".$_GET['id']);

        if($link->errno==0 ){
            $message = '<script>toastr.success("ویرایش با موفقیت انجام شد");</script>';
            echo '<script>window.location="index.php?page=admin&section=users";</script>';
        }
        else{
            $message = '<script>toastr.error("خطا در ویرایش اطلاعات");</script>';
        }
    }

}
$rowresult=$link->query("select * from users where id=".$_GET['id']);
if($rowresult->num_rows>0){
    $rowupdate=$rowresult->fetch_assoc();

}

else{
    $message='<div class="alert alert-success">عملیات با خطا مواجع شد</div>';

}
?>

    <div class="page-content-wrapper border">

        <!-- Title -->
        <div class="row">
            <div class="col-12 mb-3">
                <h1 class="h3 mb-2 mb-sm-0 fs-5">ویرایش اطلاعات کاربر</h1>
            </div>
        </div>

        <div class=" row g-4 mb-4 my-1">
            <div class="col-xxl-8">
                <div class="card shadow mb-2">



                    <!-- Card body -->
                    <div class="card-body">
                        <?php
                        if(isset($message)){
                            echo $message;
                        }
                        ?>
                        <form method="post">

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">نام کاربری</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="username" value="<?php if(isset($rowupdate)) echo $rowupdate['username'];?>">
                                    <?php
                                    if(isset($errors['username'])){
                                        echo '<div class="alert alert-danger">'.$errors['username'].'</div>';
                                    }
                                    ?>
                                </div>
                            </div><br>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">ایمیل</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="email" value="<?php if(isset($rowupdate)) echo $rowupdate['email'];?>">
                                    <?php
                                    if(isset($errors['email'])){
                                        echo '<div class="alert alert-danger">'.$errors['email'].'</div>';
                                    }
                                    ?>
                                </div>
                            </div><br>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">سطح کاربری</label>
                                <div class="col-sm-10">
                                    <select class="form-select"  name="role">
                                        <option value="1" <?php if($rowupdate['role']==1){ ?> selected <?php } ?>>مدیر سایت</option>
                                        <option value="2" <?php if($rowupdate['role']==2){ ?> selected <?php } ?>>مدرس</option>
                                        <option value="3" <?php if($rowupdate['role']==3){ ?> selected <?php } ?>>دانشجو</option>


                                    </select>
                                </div>
                            </div><br>
                            <div class="col-12 text-end">
                                <input type="submit" name="edit" value="ویرایش" class="btn btn-success ">
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
require_once 'modules/admin/includes/footer.php';
?>