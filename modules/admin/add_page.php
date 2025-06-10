<?php
defined('site') or die('ACCESS DENIED!');
if(isset($_POST['sub'])){
    $errors = [];
    // اعتبارسنجی عنوان
    if(mb_strlen($_POST['title']) < 3) {
        $errors['title'] = 'مقدار عنوان نباید کمتر از 3 کاراکتر باشد';
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
        move_uploaded_file($_FILES['image']['tmp_name'],'files/pages/'.$new_image_name);
    }

    //اعتبارسنجی منو
    if(!isset($_POST['menu']) || $_POST['menu'] == 0) {
        $errors['menu'] ='مقدار فیلد منو انتخاب نشده است';
    }

    $check_page_exist = $link->query("SELECT * FROM pages WHERE menu_id = " . intval($_POST['menu']));
    if ($check_page_exist->num_rows > 0) {
        $errors['menu'] = 'برای این منو قبلاً صفحه ای انتخاب شده است. لطفاً منویی دیگر انتخاب کنید.';
    }




    // اگر خطاها وجود نداشته باشد، مقدار را وارد کنید
    if(count($errors) == 0) {
        $link->query("INSERT INTO pages (`menu_id`,`title`,`content`,`image`) VALUES (".intval($_POST['menu']).",'".$_POST['title']."','".$_POST['my_editor']."','".$new_image_name."');");
        $_POST['title']='';
        if($link->errno == 0) {
            $message = '<script>toastr.success("صفحه با موفقیت افزوده شد");</script>';



        } else {
            echo $link->error;
            $message = '<script>toastr.error("خطا در افزودن اطلاعات");</script>';

        }
    }
}
?>
<div class="page-content-wrapper border">
    <div class="row">
        <div class="col-12 mb-3">
            <h1 class="h3 mb-2 mb-sm-0 fs-5">افزودن صفحه جدید</h1>
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
                                <label class="form-label">عنوان صفحه</label>
                                <input name="title" class="form-control" type="text"   value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>">
                                <?php if(isset($errors['title'])) echo '<div class="alert alert-danger">'.$errors['title'].'</div>'; ?>
                            </div>

                            <div class="col-12">
                                <label class="form-label">تصویر صفحه</label>
                                <input name="image" class="form-control" type="file">
                                <?php if(isset($errors['image'])) echo '<div class="alert alert-danger">'.$errors['image'].'</div>'; ?>
                            </div>
                            <div class="col-12">
                                <label class="form-label">محتوای صفحه</label>
                                <div class="centered">
                                    <div class=" row-editor">
                                        <textarea name="my_editor" id="my_editor" class="editor" placeholder=" محتوای صفحه  را اینجا وارد کنید..."><?php if (isset($_POST['my_editor'])) echo $_POST['my_editor']; elseif (isset($rowupdate)) echo $rowupdate['content']; ?></textarea>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <label class="form-label">انتخاب منوی مربوطه</label>
                                <div class="col-sm-12">
                                    <select class="form-select" name="menu">
                                        <option value="0">بدون منو</option>
                                        <?php
                                        $resultmenu = $link->query("SELECT * FROM menu where status = 1");
                                        while($rowmenu = $resultmenu->fetch_assoc()){
                                            $array = array(83,63,64);
                                            if(!in_array($rowmenu['id'],$array)) {
                                                echo '<option value="' . $rowmenu['id'] . '">' . $rowmenu['menu_title'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php if(isset($errors['menu'])) echo '<div class="alert alert-danger">'.$errors['menu'].'</div>'; ?>

                                </div>
                            </div>


                            <!-- Step 1 button -->
                            <div class="d-flex justify-content-end mt-3">
                                <input type="submit" name="sub" value="افزودن" class="btn btn-primary">&nbsp;
                                <a class="btn btn-danger" href="index.php?page=admin&section=pages">بازگشت</a>

                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
