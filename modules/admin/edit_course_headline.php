<?php
defined('site') or die('ACCESS DENIED!');
if(isset($_POST['edit_headline'])){
    $errors = [];

    // اعتبارسنجی عنوان
    if(mb_strlen($_POST['title']) < 3) {
        $errors['title'] = 'مقدار عنوان نباید کمتر از 3 کاراکتر باشد';
    }

    // چک کردن تکراری بودن عنوان سرفصل
    $title = $link->real_escape_string($_POST['title']);
    $course_id = intval($_GET['id']); // اطمینان از عدد بودن id

    $check_sql = "SELECT COUNT(*) as count FROM course_headline WHERE headline_title = '$title' AND course_id = $course_id";
    $check_result = $link->query($check_sql);

    if($check_result){
        $row = $check_result->fetch_assoc();
        if($row['count'] > 0){
            $errors['count'] = 'این عنوان قبلاً ثبت شده است.';
        }
    } else {
        die("خطا در اجرای کوئری بررسی تکراری: " . $link->error);
    }

    // اگر خطا نداشتیم، ادامه بدهید
    if(count($errors) == 0){
        $headline_id=intval($_GET['headline_id']);
        // درج سرفصل جدید
        $link->query("UPDATE course_headline SET course_id=".$course_id.",headline_title='".$title."' WHERE id=".$headline_id);
        if($link->errno == 0){
            $message = '<script>toastr.success("سرفصل با موفقیت ویرایش شد");</script>';?>
            <script> window.location="index.php?page=admin&section=course_part&id=<?php echo $_GET['id']; ?>"</script>
        <?php
        } else {
            $message = '<script>toastr.error("خطا در ویرایش اطلاعات");</script>';
        }
    }
}
$rowresult=$link->query("select * from course_headline where id=".$_GET['headline_id']);
if($rowresult->num_rows>0){
    $rowupdate=$rowresult->fetch_assoc();
}

else{
    $message='<div class="alert alert-success">عملیات با خطا مواجه شد</div>';
}
?>
<div class="page-content-wrapper border">
    <div class="row">
        <div class="col-12 mb-3">
            <h1 class="h3 mb-2 mb-sm-0 fs-5">ویرایش سرفصل</h1>
        </div>
    </div>

    <div class="row g-4 mb-4 my-1">
        <div class="col-xxl-12">
            <div class="card shadow mb-2">
                <div class="card-body">
                    <?php
                    if(isset($message)){
                        echo $message;
                    }
                    ?>
                    <form method="post" enctype="multipart/form-data">
                        <div class="row g-4">
                            <!-- Course title -->
                            <div class="col-12">
                                <label class="form-label">عنوان</label>
                                <input name="title" class="form-control" type="text"   value="<?php if (isset($rowupdate)) echo $rowupdate['headline_title']; ?>">
                                <?php if(isset($errors['title'])) echo '<div class="alert alert-danger">'.$errors['title'].'</div>'; ?>
                                <?php if(isset($errors['count'])) echo '<div class="alert alert-danger">'.$errors['count'].'</div>'; ?>


                            </div>
                            <!-- Step 1 button -->
                            <div class="d-flex justify-content-end mt-3">
                                <input type="submit" name="edit_headline" value="ویرایش" class="btn btn-primary">&nbsp;
                                <a class="btn btn-danger" href="index.php?page=admin&section=course_part&id=<?php echo $_GET['id']; ?>">بازگشت</a>

                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
