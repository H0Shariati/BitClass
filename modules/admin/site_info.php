<?php
defined('site') or die('ACCESS DENIED!');
if(isset($_POST['sub'])){
    $errors = [];
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
        move_uploaded_file($_FILES['image']['tmp_name'],'files/pages/about-contact/'.$new_image_name);
    }
    // اعتبارسنجی فیلدهای اجباری
    if(empty($_POST['footer_about'])) {
        $errors['footer_about'] = "معرفی سایت در حد یک پاراگراف الزامی است";
    } elseif(strlen($_POST['footer_about']) > 500) {
        $errors['footer_about'] = "معرفی سایت نباید بیشتر از 500 کاراکتر باشد";
    }

    if(empty($_POST['my_editor'])) {
        $errors['my_editor'] = "معرفی کامل سایت الزامی است";
    }

    $phone_number=$_POST['phone'];
    if(isset($phone_number)){
        if(!preg_match('/^[0-9]+$/', $phone_number)){
            $errors['phone']="شماره تماس باید فقط عدد باشد";
        } elseif(mb_strlen($phone_number)!=11){
            $errors['phone']="شماره تماس باید  ۱۰ رقم باشد";
        }
    }
    $address=clean($_POST['address']);
    if(empty($_POST['address'])) {
        $errors['address'] = "آدرس الزامی است";
    } elseif(strlen($_POST['address']) > 255) {
        $errors['address'] = "آدرس نباید بیشتر از 255 کاراکتر باشد";
    }
    $email=clean($_POST['email']);
    if(empty($_POST['email'])) {
        $errors['email'] = "ایمیل الزامی است";
    } elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "فرمت ایمیل صحیح نیست";
    }
    // اگر خطایی وجود نداشت، عملیات ذخیره را انجام دهید
    if(count($errors) == 0) {
        $date = time();
        $link->query("UPDATE site_information SET full_about='".$_POST['my_editor']."',footer_about='".$_POST['footer_about']."',about_image='".$new_image_name."',phone='".$phone_number."',address='".$address."',email='".$email."',facebook='".$_POST['facebook']."',instagram='".$_POST['instagram']."',twitter='".$_POST['twitter']."',linkdin='".$_POST['linkdin']."',telegram='".$_POST['telegram']."',updated_at='".$date."' WHERE id=2");
        if(isset($_POST['faq'])) {
            foreach($_POST['faq'] as $faq) {
                if(!empty($faq['question']) && !empty($faq['answer'])) {
                    $link->query("INSERT INTO faqs (question, answer) VALUES ('".$faq['question']."','".$faq['answer']."')");
                }
            }
        }


        if($link->errno == 0) {
            $message = '<script>toastr.success("تغییرات با موفقیت اعمال شد");</script>';



        } else {
            echo $link->error;
            $message = '<script>toastr.error("خطا در اعمال تغییرات");</script>';

        }
    }
}
$result=$link->query("select * from site_information");
$row=$result->fetch_assoc();

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
                    <div class="col-xl-12">
                        <!-- Edit profile START -->
                        <div class="card bg-transparent border rounded-3">
                            <!-- Card header -->
                            <div class="card-header bg-transparent border-bottom">
                                <h3 class="card-header-title mb-0 ff-vb fs-5">بخش درباره ما</h3>
                            </div>
                            <!-- Card body START -->
                            <div class="card-body">
                                <?php

                                ?>
                                <!-- Form -->
                                <form class="row g-4" method="post" enctype="multipart/form-data">

                                    <div class="col-12">
                                        <label class="form-label">معرفی سایت در حد یک پاراگراف(برای بخش فوتر سایت)</label>
                                        <textarea name="footer_about" class="form-control" id="footer_about" rows="3" placeholder="اینجا وارد کنید..."><?php if(isset($_POST['sub'])){echo $_POST['footer_about'];}else{echo $row['footer_about'] ;} ?></textarea>
                                        <?php if(isset($errors['footer_about'])) echo '<div class="alert alert-danger">'.$errors['footer_about'].'</div>'; ?>

                                    </div>

                                    <!-- Full name -->
                                    <div class="col-12">
                                        <label class="form-label">معرفی کامل سایت</label>
                                        <div class="centered">
                                            <div class=" row-editor">
                                                <textarea name="my_editor" id="my_editor" class="editor" placeholder="اینجا وارد کنید..."><?php if(isset($_POST['sub'])){echo $_POST['my_editor'];}else{echo $row['full_about'] ;} ?></textarea>
                                                <?php if(isset($errors['my_editor'])) echo '<div class="alert alert-danger">'.$errors['my_editor'].'</div>'; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">تصویر بخش درباره ما</label>
                                        <input name="image" class="form-control" type="file">
                                        <?php if(isset($errors['image'])) echo '<div class="alert alert-danger">'.$errors['image'].'</div>'; ?>
                                    </div>
                                    <hr>
                                    <div class="card-header bg-transparent border-bottom">
                                        <h3 class="card-header-title mb-0 ff-vb fs-5">بخش تماس با ما</h3>
                                    </div>
                                    <!-- بخش تماس تلفنی -->
                                    <div class="col-12">
                                        <label class="form-label">تماس تلفنی</label>
                                        <div class="input-group">
                                            <input name="phone" type="text" class="form-control" placeholder="شماره تلفن" value="<?php if(isset($_POST['sub'])){echo $phone_number;}else{echo $row['phone'] ;}  ?>">
                                        </div>
                                        <?php if(isset($errors['phone'])) echo '<div class="text-danger small mt-1">'.$errors['phone'].'</div>'; ?>
                                    </div>

                                    <!-- بخش آدرس -->
                                    <div class="col-12">
                                        <label class="form-label">آدرس</label>
                                        <div class="input-group">
                                            <input name="address" type="text" class="form-control" placeholder="آدرس" value="<?php if(isset($_POST['sub'])){echo $address;}else{echo $row['address'] ;}  ?>">
                                        </div>
                                        <?php if(isset($errors['address'])) echo '<div class="text-danger small mt-1">'.$errors['address'].'</div>'; ?>
                                    </div>

                                    <!-- بخش ایمیل -->
                                    <div class="col-12">
                                        <label class="form-label">ایمیل</label>
                                        <div class="input-group">
                                            <input name="email" type="text" class="form-control" placeholder="ایمیل" value="<?php if(isset($_POST['sub'])){echo $email;}else{echo $row['email'] ;}  ?>">
                                        </div>
                                        <?php if(isset($errors['email'])) echo '<div class="text-danger small mt-1">'.$errors['email'].'</div>'; ?>
                                    </div>

                                    <!-- شبکه های اجتماعی -->
                                    <div class="input-group mb-2">
                                        <span class="input-group-text text-facebook" id="basic-addon1"><i class="fab fa-fw fa-facebook-square"></i></span>
                                        <input name="facebook" type="text" class="form-control" placeholder="facebook.com/john.doe" value="<?php if(isset($_POST['sub'])){echo $_POST['facebook'];}else{echo $row['facebook'] ;}  ?>">
                                    </div>
                                    <?php if(isset($errors['facebook'])) echo '<div class="text-danger small mb-2">'.$errors['facebook'].'</div>'; ?>

                                        <div class="input-group mb-2">
                                            <span class="input-group-text text-instagram-gradient" id="basic-addon1"><i class="fab fa-fw fa-instagram"></i></span>
                                            <input name="instagram" type="text" class="form-control" placeholder="instagram.com/johndoe"  value="<?php if(isset($_POST['sub'])){echo $_POST['instagram'];}else{echo $row['instagram'] ;}  ?>">
                                        </div>
                                    <?php if(isset($errors['instagram'])) echo '<div class="text-danger small mb-2">'.$errors['instagram'].'</div>'; ?>

                                        <div class="input-group mb-2">
                                            <span class="input-group-text text-twitter" id="basic-addon1"><i class="fab fa-fw fa-twitter"></i></span>
                                            <input name="twitter" type="text" class="form-control" placeholder="twitter.com/johndoe"  value="<?php if(isset($_POST['sub'])){echo $_POST['twitter'];}else{echo $row['twitter'] ;}  ?>" >
                                        </div>
                                    <?php if(isset($errors['twitter'])) echo '<div class="text-danger small mb-2">'.$errors['twitter'].'</div>'; ?>
                                    <div class="input-group mb-2">
                                            <span class="input-group-text text-linkedin" id="basic-addon1"><i class="fab fa-fw fa-linkedin-in"></i></span>
                                        <input name="linkdin" type="text" class="form-control" placeholder="linkedin.com/in/johndoe"  value="<?php if(isset($_POST['sub'])){echo $_POST['linkdin'];}else{echo $row['linkdin'] ;}  ?>" >
                                        </div>
                                    <?php if(isset($errors['linkdin'])) echo '<div class="text-danger small mb-2">'.$errors['linkdin'].'</div>'; ?>

                                    <div class="input-group mb-2">
                                            <span class="input-group-text text-twitter" id="basic-addon1"><i class="fab fa-fw fa-telegram"></i></span>
                                            <input name="telegram" type="text" class="form-control" placeholder="t.me/johndoe"  value="<?php if(isset($_POST['sub'])){echo $_POST['telegram'];}else{echo $row['telegram'] ;}  ?>" >
                                        </div>
                                    <?php if(isset($errors['telegram'])) echo '<div class="text-danger small mb-2">'.$errors['telegram'].'</div>'; ?>
                                    <div class="col-12">
                                        <label class="form-label">سوالات متداول (FAQ)</label>

                                        <!-- Container for dynamic FAQ items -->
                                        <div id="faqContainer">
                                            <?php if(isset($faqs) && !empty($faqs)): ?>
                                                <?php foreach($faqs as $index => $faq): ?>
                                                    <div class="faq-item mb-3 border p-3 rounded">
                                                        <div class="row g-2">
                                                            <div class="col-md-5">
                                                                <input type="text" name="faq[<?php echo $index; ?>][question]"
                                                                       class="form-control"
                                                                       placeholder="سوال"
                                                                       value="<?php echo htmlspecialchars($faq['question']); ?>">
                                                            </div>
                                                            <div class="col-md-5">
                                                                <input type="text" name="faq[<?php echo $index; ?>][answer]"
                                                                       class="form-control"
                                                                       placeholder="پاسخ"
                                                                       value="<?php echo htmlspecialchars($faq['answer']); ?>">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button" class="btn btn-danger remove-faq">حذف</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <!-- Default first FAQ item -->
                                                <div class="faq-item mb-3 border p-3 rounded">
                                                    <div class="row g-2">
                                                        <div class="col-md-5">
                                                            <input type="text" name="faq[0][question]" class="form-control" placeholder="سوال">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input type="text" name="faq[0][answer]" class="form-control" placeholder="پاسخ">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="button" class="btn btn-danger remove-faq">حذف</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Add new FAQ button -->
                                        <div class="text-start mt-2">
                                            <button type="button" id="addFaq" class="btn btn-success">
                                                <i class="fas fa-plus me-1"></i> افزودن سوال جدید
                                            </button>
                                        </div>
<!--                                        <div class=" card-body table-responsive border-0 rounded-3">-->
<!---->
<!--                                        <table class="table table-dark-gray align-middle p-4 mb-0 table-hover">-->
<!--                                            <thead>-->
<!--                                            <tr>-->
<!--                                                <td>سوال</td>-->
<!--                                                <td>پاسخ</td>-->
<!--                                                <td>عملیات</td>-->
<!---->
<!--                                            </tr>-->
<!--                                            </thead>-->
<!--                                            <tbody>-->
<!--                                            --><?php
//                                            $faqs=$link->query("SELECT * FROM faqs");
//                                            while ($faq = $faqs->fetch_assoc()) {?>
<!--                                                <tr>-->
<!--                                                    <td>--><?php //echo $faq['question']; ?><!--</td>-->
<!--                                                    <td>--><?php //echo $faq['answer']; ?><!--</td>-->
<!--                                                    <td>-->
<!--                                                        <a href="index.php?page=admin&section=site_info&action=delete&id=--><?php //echo $faq['id']; ?><!--" class="btn btn-danger btn-sm mx-1"><i class="bi bi-trash me-1"></i>حذف</a>-->
<!--                                                    </td>-->
<!---->
<!--                                                </tr>-->
<!--                                            --><?php
//                                            }
//                                            ?>
<!--                                            </tbody>-->
<!--                                        </table>-->
<!--                                        </div>-->
                                    </div>
                                    <!-- Save button -->
                                    <div class="d-sm-flex justify-content-end">
                                        <button type="submit" name="sub" class="btn btn-primary mb-0">تغییر و ذخیره</button>
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            // Add new FAQ item
                                            document.getElementById('addFaq').addEventListener('click', function() {
                                                const container = document.getElementById('faqContainer');
                                                const index = container.querySelectorAll('.faq-item').length;

                                                const newFaq = document.createElement('div');
                                                newFaq.className = 'faq-item mb-3 border p-3 rounded';
                                                newFaq.innerHTML = `
                                        <div class="row g-2">
                                            <div class="col-md-5">
                                                <input type="text" name="faq[${index}][question]" class="form-control" placeholder="سوال">
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" name="faq[${index}][answer]" class="form-control" placeholder="پاسخ">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger remove-faq">حذف</button>
                                            </div>
                                        </div>
                                    `;

                                                container.appendChild(newFaq);
                                            });

                                            // Remove FAQ item
                                            document.addEventListener('click', function(e) {
                                                if(e.target.classList.contains('remove-faq')) {
                                                    e.target.closest('.faq-item').remove();
                                                    // Reindex remaining items
                                                    const items = document.querySelectorAll('.faq-item');
                                                    items.forEach((item, index) => {
                                                        item.querySelector('[name^="faq["]').name = `faq[${index}][question]`;
                                                        item.querySelector('[name$="][answer]"]').name = `faq[${index}][answer]`;
                                                    });
                                                }
                                            });
                                        });
                                    </script>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>


