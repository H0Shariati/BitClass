<?php
defined('site') or die('ACCESS DENIED!');
if(isset($_POST['sub'])){
    $errors = [];
    // اعتبارسنجی عنوان
    if(mb_strlen($_POST['title']) < 3) {
        $errors['title'] = 'مقدار عنوان نباید کمتر از 3 کاراکتر باشد';
    }
    if(!isset($_POST['time']) || $_POST['time'] == 0) {
        $errors['time'] ='تایم دوره وارد نشده است';
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
        $new_image_name=rand(100,10000).$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'],'files/articles/'.$new_image_name);
    }
    // اعتبارسنجی وضعیت
    if(!isset($_POST['status']) || !in_array($_POST['status'], ['0', '1'])) {
        $errors['status'] = 'مقدار فیلد وضعیت نامعتبر می باشد';
    }
    // دریافت تگ‌ها
    $tags_input = $_POST['tags'];

    $tags_array = json_decode($tags_input, true);

// تبدیل به آرایه ساده
    $simple_tags = [];
    foreach($tags_array as $tag) {
        if(isset($tag['value'])) {
            $simple_tags[] = trim($tag['value']);
        }
    }

// ذخیره به صورت JSON
    $tags_json = json_encode($simple_tags, JSON_UNESCAPED_UNICODE);


    if(count($errors) == 0) {
        $tags = isset($_POST['tags']) ? json_encode(explode(',', $_POST['tags'])) : '[]';
        $link->query("UPDATE articles SET title='".$_POST['title']."',content='".$_POST['my_editor']."',status='".$_POST['status']."',image='".$new_image_name."',reading_time='".$_POST['time']."',tags='".$link->real_escape_string($tags_json)."' WHERE id=".$_GET['id']);
        if($link->errno == 0) {
            $message = '<script>toastr.success("ذخیره با موفقیت انجام شد");</script>';
            echo '<script>window.location="index.php?page=admin&section=article";</script>';


        } else {
            $message = '<script>toastr.error("خطا در ذخیره اطلاعات");</script>';

        }
    }
}
$rowresult=$link->query("select * from articles where id=".$_GET['id']);
if($rowresult->num_rows>0){
    $rowupdate=$rowresult->fetch_assoc();
}

else{
    $message='<div class="alert alert-danger">عملیات با خطا مواجه شد</div>';
}
?>
<div class="page-content-wrapper border">
    <div class="row">
        <div class="col-12 mb-3">
            <h1 class="h3 mb-2 mb-sm-0 fs-5">افزودن مقاله جدید</h1>
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
                            <div class="col-10">
                                <label class="form-label">عنوان مقاله</label>
                                <input name="title" class="form-control" type="text"   value="<?php if (isset($rowupdate)) echo $rowupdate['title']; ?>">
                                <?php if(isset($errors['title'])) echo '<div class="alert alert-danger">'.$errors['title'].'</div>'; ?>
                            </div>
                            <div class="col-2">
                                <label class="form-label">تایم ویدیو (دقیقه)</label>
                                <input name="time" class="form-control" type="number" value="<?php if (isset($rowupdate)) echo $rowupdate['reading_time']; ?>">
                                <?php if(isset($errors['time'])) echo '<div class="alert alert-danger">'.$errors['time'].'</div>'; ?>
                            </div>



                            <div class="col-12">
                                <label class="form-label">تصویر شاخص</label>
                                <input name="image" class="form-control" type="file">
                                <?php if(isset($errors['image'])) echo '<div class="alert alert-danger">'.$errors['image'].'</div>'; ?>
                            </div>
                            <div class="col-12">
                                <label class="form-label">محتوا</label>
                                <div class="centered">
                                    <div class=" row-editor">
                                         <textarea name="my_editor" id="my_editor" class="editor" placeholder="محتوای مقاله را اینجا وارد کنید..."  >
                                            <?php if (isset($rowupdate)) echo $rowupdate['content']; ?>
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">تگ‌ها</label>
                                <input name='tags' class="form-control" placeholder='تگ‌ها را وارد کنید و اینتر بزنید' value='<?php
                                if(isset($rowupdate['tags']) && !empty($rowupdate['tags'])) {
                                    $tagsArray = json_decode($rowupdate['tags'], true);
                                    if(is_array($tagsArray)) {
                                        echo htmlspecialchars(implode(',', $tagsArray));
                                    }
                                }
                                ?>'>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Initialize Tagify
                                    var input = document.querySelector('input[name=tags]');
                                    var tagify = new Tagify(input, {
                                        duplicates: false,
                                        trim: true,
                                        pattern: /^[a-zA-Zآ-ی0-9\-_\s]{1,20}$/,
                                        dropdown: {
                                            enabled: 0
                                        }
                                    });

                                    // برای نمایش تگ‌های فارسی بهتر
                                    tagify.on('input', function(e){
                                        var value = e.detail.value;
                                        tagify.settings.pattern = value.match(/[آ-ی]/) ? /^[a-zA-Zآ-ی0-9\-_\s]{1,20}$/ : /^[a-zA-Z0-9\-_\s]{1,20}$/;
                                    });

                                    // بارگذاری تگ‌های قبلی اگر وجود داشته باشند
                                    <?php
                                    if(isset($rowupdate['tags']) && !empty($rowupdate['tags'])) {
                                        $tagsArray = json_decode($rowupdate['tags'], true);
                                        if(is_array($tagsArray)) {
                                            echo "tagify.addTags(".json_encode($tagsArray).");";
                                        }
                                    }
                                    ?>
                                });
                            </script>                            <div class="col-md-6">
                                <label class="col-sm-2 col-form-label">وضعیت</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="status" value="1" id="st1" <?php if(isset($rowupdate) && $rowupdate['status']==1) echo ' checked ' ?>>
                                        <label class="form-check-label" for="st1">فعال</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="status" value="0" id="st0" <?php if(isset($rowupdate) && $rowupdate['status']==0) echo ' checked ' ?>>
                                        <label class="form-check-label" for="st0">غیرفعال</label>
                                    </div>
                                </div>
                                <?php if(isset($errors['status'])) echo '<div class="alert alert-danger">'.$errors['status'].'</div>'; ?>

                            </div>


                            <!-- Step 1 button -->
                            <div class="d-flex justify-content-end mt-3">
                                <input type="submit" name="sub" value="ویرایش" class="btn btn-primary">&nbsp;
                                <a class="btn btn-danger" href="index.php?page=admin&section=article">بازگشت</a>

                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
