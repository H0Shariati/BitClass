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


    // اگر خطاها وجود نداشته باشد، مقدار را وارد کنید
    if(count($errors) == 0) {
        $link->query("INSERT INTO course_category (category_name, category_sub, status) VALUES ('" . $link->real_escape_string($_POST['title']) . "', " . (int)$_POST['subcategory'] . ", " . (int)$_POST['status'] . ")");

        if($link->errno == 0) {
            $message = '<script>toastr.success("ذخیره با موفقیت انجام شد");</script>';
            echo '<script>window.location="index.php?page=admin&section=add_category";</script>';


        } else {
            $message = '<script>toastr.error("خطا در ذخیره اطلاعات");</script>';

        }
    }
}
?>
<div class="page-content-wrapper border">
    <div class="row">
        <div class="col-12 mb-3">
            <h1 class="h3 mb-2 mb-sm-0 fs-5">افزودن دسته بندی جدید</h1>
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
                                <label class="form-label">عنوان دسته بندی</label>
                                <input name="title" class="form-control" type="text"   value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>">
                                <?php if(isset($errors['title'])) echo '<div class="alert alert-danger">'.$errors['title'].'</div>'; ?>
                            </div>


                            <div class="col-md-6">
                                <label class="form-label">سردسته</label>
                                <div class="col-sm-12">
                                    <select class="form-select" name="subcategory">
                                        <option value="0">بدون سر دسته</option>
                                        <?php
                                        $resultcategory = $link->query("SELECT * FROM course_category");
                                        while($rowcategory = $resultcategory->fetch_assoc()){
                                            echo '<option value="'.$rowcategory['category_id'].'">'.$rowcategory['category_name'].'</option>';
                                        }
                                        ?>
                                    </select>
                                    <?php if(isset($errors['category'])) echo '<div class="alert alert-danger">'.$errors['category'].'</div>'; ?>

                                </div>
                            </div>


                            <div class="col-md-6">
                                <label class="col-sm-2 col-form-label">وضعیت</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="status" value="1" id="st1" <?php if(isset($_POST['status']) && $_POST['status'] == 1) echo ' checked '; ?>>
                                        <label class="form-check-label" for="st1">فعال</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="status" value="0" id="st0" <?php if(isset($_POST['status']) && $_POST['status'] == 0) echo ' checked '; ?>>
                                        <label class="form-check-label" for="st0">غیرفعال</label>
                                    </div>
                                </div>
                                <?php if(isset($errors['status'])) echo '<div class="alert alert-danger">'.$errors['status'].'</div>'; ?>

                            </div>



                            <!-- Step 1 button -->
                            <div class="d-flex justify-content-end mt-3">
                                <input type="submit" name="sub" value="افزودن" class="btn btn-primary">&nbsp;
                                <a class="btn btn-danger" href="index.php?page=admin&section=categories">بازگشت</a>

                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
