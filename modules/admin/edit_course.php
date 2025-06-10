<?php
defined('site') or die('ACCESS DENIED!');

if(isset($_POST['edit'])) {
    $errors = [];
    // اعتبارسنجی عنوان
    if(mb_strlen($_POST['title']) < 3) {
        $errors['title'] = 'مقدار عنوان نباید کمتر از 3 کاراکتر باشد';
    }

    // اعتبارسنجی وضعیت
    if(!isset($_POST['status']) || !in_array($_POST['status'], ['0', '1'])) {
        $errors['status'] = 'لطفا وضعیت دوره را مشخص کنید';

    }
    //اعتبارسنجی دسته بندی
    if(!isset($_POST['subcategory']) || $_POST['subcategory'] == 0) {
        $errors['subcategory'] ='مقدار فیلد دسته بندی انتخاب نشده است';
    }
    //اعتبارسنجی سطح
    if(!isset($_POST['level']) || $_POST['level'] == 0) {
        $errors['level'] ='سطح دوره انتخاب نشده است';
    }

    //اعتبارسنجی تصویر
    if (empty($_FILES['image']['name'])) {
        $errors['image'] = 'لطفاً فایل تصویر خود را آپلود کنید';
    }
    else{
        if($_FILES['image']['size']>5242880) {  //5*1024*1024
            $errors['image'] = (isset($errors['image'])?$errors['image'].'<br>':'')."محدودیت ارسال فایل تا5MB ";
        }
        $extension_file=strtolower(substr($_FILES['image']['name'],strrpos($_FILES['image']['name'],'.')+1));
        if(!in_array($extension_file,['jpg','jpeg','png','gif'])){
            $errors['image'] = (isset($errors['image'])?$errors['image'].'<br>':'')." فرمت فایل ارسالی صحیح نمی باشد، لطفا یک فایل تصویری با فرمت (jpg,jpeg,png,gif)وارد کنید";
        }

    }
    if(!isset($errors['image'])){
        move_uploaded_file($_FILES['image']['tmp_name'],'files/courses/'.$_FILES['image']['name']);
    }

    //اعتبارسنجی ویدیو معرفی
    if (empty($_FILES['video']['name'])) {
        $errors['video'] = 'لطفاً فایل ویدیو خود را آپلود کنید';
    }
    else{
        if($_FILES['video']['size']>10485760) {  //10*1024*1024
            $errors['video'] = (isset($errors['video'])?$errors['video'].'<br>':'')."محدودیت ارسال فایل تا10MB ";
        }
        $extension_file=strtolower(substr($_FILES['video']['name'],strrpos($_FILES['video']['name'],'.')+1));
        if(!in_array($extension_file,['mp4'])){
            $errors['video'] = (isset($errors['video'])?$errors['video'].'<br>':'')." فرمت فایل ارسالی صحیح نمی باشد، لطفا یک فایل ویدیویی با فرمت (mp4)وارد کنید";
        }

    }
    if(!isset($errors['video'])){
        move_uploaded_file($_FILES['video']['tmp_name'],'files/courses/video/'.$_FILES['video']['name']);
    }


    // اگر خطاها وجود نداشته باشد، مقدار را وارد کنید
    if(count($errors) == 0) {
        $date=time();
        $link->query("UPDATE courses SET course_title='".$_POST['title']."',course_description='".$_POST['my_editor']."',cat_id='".$_POST['subcategory']."',course_image='".$_FILES['image']['name']."',intro_video='".$_FILES['video']['name']."',course_price='".$_POST['price']."',level='".$_POST['level']."',update_date='".$date."',status='".$_POST['status']."' WHERE id=".$_GET['id']);

        if($link->errno == 0) {
            $message = '<script>toastr.success("دوره با موفقیت ویرایش شد");</script>';
            echo '<script>window.location="index.php?page=admin&section=courses";</script>';
        } else {
            $message = '<script>toastr.error("خطا در ویرایش دوره");</script>';

        }
    }
}

$rowresult=$link->query("select * from courses where id=".$_GET['id']);
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
            <h1 class="h3 mb-2 mb-sm-0 fs-5">ویرایش دوره</h1>
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
                                <label class="form-label">عنوان دوره</label>
                                <input name="title" class="form-control" type="text" placeholder="آموزش ساخت وب سایت خبری"  value="<?php if (isset($rowupdate)) echo $rowupdate['course_title']; ?>">
                                <?php if(isset($errors['title'])) echo '<div class="alert alert-danger">'.$errors['title'].'</div>'; ?>
                            </div>

                            <!-- Course description -->
                            <div class="col-12">
                                <label class="form-label">توضیحات دوره</label>
                                <div class="centered">
                                    <div class=" row-editor">
                                        <textarea name="my_editor" id="my_editor" class="editor" placeholder=" توضیحات دوره را اینجا وارد کنید..."  >
                                            <?php if (isset($rowupdate)) echo $rowupdate['course_description']; ?>
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">انتخاب تصویر شاخص</label>
                                <input type="file" class="form-control" name="image">
                                <?php if(isset($errors['image'])) echo '<div class="alert alert-danger">'.$errors['image'].'</div>'; ?>
                            </div>
                            <div class="col-12">
                                <label class="form-label">ویدیو معرفی دوره</label>
                                <input type="file" class="form-control" name="video">
                                <?php if(isset($errors['video'])) echo '<div class="alert alert-danger">'.$errors['video'].'</div>'; ?>

                            </div>
                            <div class="col-md-6">
                                <label class="form-label">دسته بندی</label>
                                <div class="col-sm-12">
                                    <select class="form-select" name="subcategory">
                                        <option value="0">بدون دسته بندی</option>
                                        <?php
                                        $resultcategory=$link->query("select * from course_category ");
                                        while($rowcategory=$resultcategory->fetch_assoc()){
                                            echo '<option';
                                            if(isset($rowupdate)){
                                                if($rowcategory['category_id']==$rowupdate['cat_id']){
                                                    echo ' selected ';
                                                }
                                            }
                                            echo ' value="'.$rowcategory['category_id'].'">'.$rowcategory['category_name'].'</option>';
                                        }
                                        ?>
                                    </select>
                                    <?php if(isset($errors['subcategory'])) echo '<div class="alert alert-danger">'.$errors['subcategory'].'</div>'; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">سطح دوره</label>
                                <div class="col-sm-12">
                                    <select  name="level" class="form-select" >
                                        <option value="0">انتخاب سطح</option>
                                        <option value="مقدماتی" <?php if (isset($rowupdate['level']) && $rowupdate['level'] == 'مقدماتی') echo 'selected'; ?>>مقدماتی</option>
                                        <option value="متوسط" <?php if (isset($rowupdate['level']) && $rowupdate['level'] == 'متوسط') echo 'selected'; ?>>متوسط</option>
                                        <option value="پیشرفته" <?php if (isset($rowupdate['level']) && $rowupdate['level'] == 'پیشرفته') echo 'selected'; ?>>پیشرفته</option>
                                    </select>
                                    <?php if(isset($errors['level'])) echo '<div class="alert alert-danger">'.$errors['level'].'</div>'; ?>

                                </div>
                            </div>

                            <!-- Course price -->
                            <div class="col-md-6">
                                <label class="form-label">قیمت</label>
                                <input name="price" type="text" class="form-control" placeholder="90,000 تومان" value="<?php if (isset($rowupdate)) echo $rowupdate['course_price']; ?>">
                            </div>


                            <div class="col-md-6">
                                <label class="col-sm-2 col-form-label">وضعیت دوره</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="status" value="1" id="st1" <?php if(isset($rowupdate) && $rowupdate['status'] == 1) echo ' checked '; ?>>
                                        <label class="form-check-label" for="st1">فعال</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="status" value="0" id="st0" <?php if(isset($rowupdate) && $rowupdate['status'] == 0) echo ' checked '; ?>>
                                        <label class="form-check-label" for="st0">غیرفعال</label>
                                    </div>
                                </div>

                                <?php if(isset($errors['status'])) echo '<div class="alert alert-danger">'.$errors['status'].'</div>'; ?>

                            </div>



                            <!-- Step 1 button -->
                            <div class="d-flex justify-content-end mt-3">
                                <input type="submit" name="edit" value="ویرایش" class="btn btn-primary">&nbsp;
                                <a class="btn btn-danger" href="index.php?page=admin&section=courses">بازگشت</a>

                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
