<?php
defined('site') or die('ACCESS DENIED!');
if(isset($_POST['edit_course_part'])){
    $errors = [];

    // اعتبارسنجی عنوان
    if(mb_strlen($_POST['title']) < 3) {
        $errors['title'] = 'مقدار عنوان نباید کمتر از 3 کاراکتر باشد';
    }
    // اعتبارسنجی وضعیت قیمت
    if(!isset($_POST['options']) || !in_array($_POST['options'], ['0', '1'])) {
        $errors['options'] = 'لطفا وضعیت دوره را مشخص کنید';

    }
    //اعتبارسنجی ویدیو
    if (empty($_FILES['video']['name'])) {
        $errors['video'] = 'لطفاً فایل ویدیو خود را آپلود کنید';
    }
    else{
        if($_FILES['video']['size']>314572800) {  //300*1024*1024
            $errors['video'] = (isset($errors['video'])?$errors['video'].'<br>':'')."محدودیت ارسال فایل تا300MB ";
        }
        $extension_file=strtolower(substr($_FILES['video']['name'],strrpos($_FILES['video']['name'],'.')+1));
        if(!in_array($extension_file,['mp4'])){
            $errors['video'] = (isset($errors['video'])?$errors['video'].'<br>':'')." فرمت فایل ارسالی صحیح نمی باشد، لطفا یک فایل ویدیویی با فرمت (mp4)وارد کنید";
        }

    }
    if(!isset($errors['video'])){
        $new_video_name=rand(100,10000).$_FILES['video']['name'];
        move_uploaded_file($_FILES['video']['tmp_name'],'files/courses/partvideo/'.$new_video_name);
    }
//اعتبارسنجی تایم ویدیو
    if(!isset($_POST['time']) || $_POST['time'] == 0) {
        $errors['time'] ='تایم دوره وارد نشده است';
    }
    //اعتبارسنجی فایل ضمیمه
    if (!empty($_FILES['file']['name'])) {
        if ($_FILES['file']['size'] > 314572800) {  //300*1024*1024
            $errors['file'] = (isset($errors['file']) ? $errors['file'] . '<br>' : '') . "محدودیت ارسال فایل تا300MB ";
        }
        $extension_file = strtolower(substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], '.') + 1));
        if (!in_array($extension_file, ['zip', 'rar'])) {
            $errors['file'] = (isset($errors['file']) ? $errors['file'] . '<br>' : '') . " فرمت فایل ارسالی صحیح نمی باشد، لطفا یک فایل  با فرمت (zip یا rar)وارد کنید";
        }

    }
    if(!isset($errors['file'])){
        if(!empty($_FILES['file']['name'])){
            $new_file_name=rand(100,10000).$_FILES['file']['name'];
            move_uploaded_file($_FILES['file']['tmp_name'],'files/courses/files/'.$new_file_name);
        }
        else{
            $new_file_name='';
        }

    }

    if(count($errors) == 0){
        $link->query("UPDATE course_part SET part_title='".$_POST['title']."',course_id=".$_GET['id'].",headline_id=".$_GET['headline_id'].",video='".$new_video_name."',time_video=".$_POST['time'].",file='".$new_file_name."',price_status=".$_POST['options']." WHERE id=".$_GET['part_id']);

        if($link->errno == 0){
            $message = '<script>toastr.success("جلسه با موفقیت ویرایش شد");</script>';?>
            <script> window.location="index.php?page=admin&section=course_part&id=<?php echo $_GET['id']; ?>"</script>
        <?php
        } else {
            echo $link->error;
            $message = '<script>toastr.error("خطا در ویرایش اطلاعات");</script>';
        }
    }
}
$rowresult=$link->query("select * from course_part where id=".$_GET['part_id']);
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
            <h1 class="h3 mb-2 mb-sm-0 fs-5">افزودن جلسه جدید</h1>
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
                                <label class="form-label">عنوان جلسه</label>
                                <input name="title" class="form-control" type="text"   value="<?php if (isset($rowupdate)) echo $rowupdate['part_title']; ?>">
                                <?php if(isset($errors['title'])) echo '<div class="alert alert-danger">'.$errors['title'].'</div>'; ?>
                            </div>
                            <div class="col-10">
                                <label class="form-label">ویدیو این جلسه</label>
                                <input name="video" class="form-control" type="file">
                                <?php if(isset($errors['video'])) echo '<div class="alert alert-danger">'.$errors['video'].'</div>'; ?>
                            </div>
                            <div class="col-2">
                                <label class="form-label">تایم ویدیو (دقیقه)</label>
                                <input name="time" class="form-control" type="number" value="<?php if (isset($rowupdate)) echo $rowupdate['time_video']; ?>">
                                <?php if(isset($errors['time'])) echo '<div class="alert alert-danger">'.$errors['time'].'</div>'; ?>
                            </div>
                            <div class="col-12">
                                <label class="form-label">فایل ضمیمه</label>
                                <input name="file" class="form-control" type="file">
                                <?php if(isset($errors['file'])) echo '<div class="alert alert-danger">'.$errors['file'].'</div>'; ?>
                            </div>
                            <div class="col-6 mt-3">
                                <label class="form-label">وضعیت نمایش این جلسه را مشخص کنید</label>&nbsp;

                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    <!-- رایگان button -->
                                    <input type="radio" class="btn-check" name="options" id="option1" value="0" <?php if(isset($rowupdate) && $rowupdate['price_status'] == 0) echo ' checked '; ?>>
                                    <label class="btn btn-sm btn-light btn-success-soft-check border-0 m-0" for="option1">رایگان</label>
                                    <!-- Premium button -->
                                    <input type="radio" class="btn-check" name="options" value="1" id="option2" <?php if(isset($rowupdate) && $rowupdate['price_status'] == 1) echo ' checked '; ?>>
                                    <label class="btn btn-sm btn-light btn-success-soft-check border-0 m-0" for="option2">پولی</label>
                                </div>
                                <?php if(isset($errors['options'])) echo '<div class="alert alert-danger">'.$errors['options'].'</div>'; ?>

                            </div>
                            <!-- Step 1 button -->
                            <div class="d-flex justify-content-end mt-3">
                                <input type="submit" name="edit_course_part" value="ویرایش" class="btn btn-primary">&nbsp;
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
