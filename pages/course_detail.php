<?php
defined('site') or die('ACCESS DENIED!');

if(isset($_POST['add_to_cart'])){
    if(!isset($_SESSION['login'])){
        $message = '<script>
        toastr.error("برای خرید این دوره ، لطفا ابتدا <a href=\'index.php?page=login\'>وارد حساب کاربری </a> خود شوید!");  
        </script>';

    }
    else{
        $check_query = $link->query("SELECT * FROM cart WHERE user_id = '".$_SESSION['login']."' AND course_id = '".$_GET['id']."' AND status=0");
        if ($check_query->num_rows > 0) {
            $message = '<script>toastr.error("این دوره قبلاً به سبد خرید اضافه شده است");</script>';
        }
        else {
            // اگر دوره در سبد خرید موجود نیست، آن را اضافه کنید
            $resultadd = $link->query("INSERT INTO cart ( `user_id`, `course_id`) VALUES ( '" . $_SESSION['login'] . "', '" . $_GET['id'] . "')");

            if ($resultadd) {
                $message = '<script>toastr.success("دوره با موفقیت به سبد خرید اضافه شد.");</script>';


            } else {
                $message = '<script>toastr.error("خطا در اضافه کردن دوره به سبد خرید");</script>';
            }
        }
    }



}

//add_comment
if(isset($_POST['add_comment'])){
    $errors = [];
    // اعتبارسنجی متن نظر
    if(mb_strlen($_POST['content']) < 5) {
        $message = '<script>toastr.error("متن نظر نمیتواند کمتر از 5 کاراکتر باشد");</script>';
        $errors['content'] = $message;
    }
    if(count($errors) == 0) {
        $date=time();
        $comment_add = $link->query("INSERT INTO comments ( `course_id`,`sender`, `content`,`reply`,`date`,`rating`) VALUES ( '".$_GET['id']."','" . $_SESSION['login'] . "', '" . $_POST['content'] . "','0','".$date."','".$_POST['rating']."')");
        if($link->errno == 0) {
            $message = '<script>toastr.success("نظر شما با موفقیت ذخیره شد");</script>';
            $_POST['content']=' ';


        } else {

            $message = '<script>toastr.error("خطا در ذخیره نظر");</script>';

        }
    }
}
//avg-rating
$sum=0;
$countcom=$link->query("select count(*) as count from comments where course_id=".cleanId($_GET['id']));
$rowcounrcom=$countcom->fetch_assoc();
$exxxx=$rowcounrcom['count'];
if($exxxx==0) {
    $exxxx=1;
}
$avg_rating=$link->query("select comments.* , users.username as username from comments JOIN users ON comments.sender=users.id where comments.course_id=".$_GET['id']." order by comments.date desc ");
while($rowavg=$avg_rating->fetch_assoc()){
    $sum+=$rowavg['rating'];
}
$avg_rating=round($sum/$exxxx);

require_once 'includes/header.php';
$resultcourse=$link->query("select courses.* , course_category.category_name as category_name from courses join course_category ON courses.cat_id=course_category.category_id where courses.id=".cleanId($_GET['id']));
if($resultcourse->num_rows>0){
    $rowcourse=$resultcourse->fetch_assoc();

?>
<main>
    <?php
    if(isset($message)){
        echo $message;
    }
    ?>
<!-- =======================
Page intro START -->
<section class="bg-light py-0 py-sm-3">
    <div class="container">
        <div class="row py-5">
            <div class="col-lg-8">
                <!-- Badge -->
                <h6 class="mb-3 font-base bg-fullsecondary text-white py-2 px-4 rounded-2 d-inline-block"><?php echo $rowcourse['category_name'];?></h6>
                <!-- Title -->
                <h1 class="fs-3"><?php echo $rowcourse['course_title'];?></h1>
                <!-- Content -->
                <ul class="list-inline mb-0">
                    <li class="list-inline-item me-3 mb-1 mb-sm-0"><i class="fas fa-star text-warning me-2"></i><?php echo $avg_rating ; ?>/5</li>
                    <?php
                    $cnParticipants=$link->query("SELECT count(*) as cn FROM cart WHERE course_id=".$_GET['id']." AND status=1");
                    $rowParticipants=$cnParticipants->fetch_assoc();
                    ?>
                    <li class="list-inline-item me-3 mb-1 mb-sm-0"><i class="fas fa-user-graduate text-orange me-2"></i><?php echo $rowParticipants['cn'] ; ?> شرکت کننده</li>
                    <li class="list-inline-item me-3 mb-1 mb-sm-0"><i class="fas fa-signal text-success me-2"></i><?php echo $rowcourse['level'];?></li>
                    <li class="list-inline-item me-3 mb-1 mb-sm-0"><i class="bi bi-patch-exclamation-fill text-danger me-2"></i>آخرین بروزرسانی <?php echo dateFormat($rowcourse['update_date']); ?></li>
                </ul>

            </div>
        </div>
    </div>
</section>
<!-- =======================
Page intro END -->

<!-- =======================
Page content START -->
<section class="pb-0 py-lg-5">
    <div class="container">
        <div class="row">
            <!-- Main content START -->
            <div class="col-lg-8">
                <div class="card shadow rounded-2 p-0">
                    <!-- Tabs START -->
                    <div class="card-header border-bottom px-4 py-3">
                        <ul class="nav nav-pills nav-tabs-line py-0" id="course-pills-tab" role="tablist">
                            <li class="nav-item me-2 me-sm-4" role="presentation">
                                <button class="nav-link mb-2 mb-md-0 active" id="course-pills-tab-1" data-bs-toggle="pill" data-bs-target="#course-pills-1" type="button" role="tab" aria-controls="course-pills-1" aria-selected="true">توضیحات</button>
                            </li>
                            <li class="nav-item me-2 me-sm-4" role="presentation">
                                <button class="nav-link mb-2 mb-md-0" id="course-pills-tab-2" data-bs-toggle="pill" data-bs-target="#course-pills-2" type="button" role="tab" aria-controls="course-pills-2" aria-selected="false">جلسات دوره</button>
                            </li>
                            <li class="nav-item me-2 me-sm-4" role="presentation">
                                <button class="nav-link mb-2 mb-md-0" id="course-pills-tab-6" data-bs-toggle="pill" data-bs-target="#course-pills-6" type="button" role="tab" aria-controls="course-pills-6" aria-selected="false">نظرات دوره</button>
                            </li>
                        </ul>
                    </div>
                    <!-- Tabs END -->

                    <!-- Tab contents START -->
                    <div class="card-body p-4">
                        <div class="tab-content pt-2" id="course-pills-tabContent">
                            <!-- Content START -->
                            <div class="tab-pane fade show active" id="course-pills-1" role="tabpanel" aria-labelledby="course-pills-tab-1">
                                <!-- Course detail START -->
                                <h5 class="mb-3">توضیحات این دوره</h5>
                                <p class="mb-3"><?php echo $rowcourse['course_description'];?></p>

                            </div>
                            <!-- Content END -->


                            <!-- Content START -->
                            <div class="tab-pane fade" id="course-pills-2" role="tabpanel" aria-labelledby="course-pills-tab-2">
                                <!-- Course accordion START -->
                                <div class="accordion accordion-icon accordion-bg-light" id="accordionExample2">
                                    <?php
                                    $countheadlines=$link->query("SELECT count(*) as count FROM course_headline where course_id=".$_GET['id']);
                                    $countheadline=$countheadlines->fetch_assoc();
                                    $resultheadline=$link->query("SELECT * FROM course_headline where course_id=".$_GET['id']);
                                    $num=0;
                                    if($countheadline['count']!=0){
                                        while ($rowheadline=$resultheadline->fetch_assoc()){?>
                                            <!-- Item -->
                                            <div class="accordion-item mb-2">
                                                <h6 class="accordion-header font-base" id="heading<?php echo $num; ?>">
                                                    <button class="accordion-button fw-bold rounded d-inline-block collapsed d-block pe-5 d-flex justify-content-between " type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapse<?php echo $num; ?>"
                                                            aria-expanded="false"
                                                            aria-controls="collapse<?php echo $num; ?>"><div>
                                                            <?php echo $rowheadline['headline_title'].'  ';
                                                            $countpart=$link->query("SELECT COUNT(*) as count FROM course_part where course_id=".$_GET['id']." AND headline_id=".$rowheadline['id']);
                                                            $count=$countpart->fetch_assoc();
                                                            ?>
                                                            <span class="small ms-0 ms-sm-2"><?php echo '( '.$count['count'].' جلسه )' ; ?></span>
                                                        </div>

                                                    </button>
                                                </h6>
                                                <div id="collapse<?php echo $num; ?>" class="accordion-collapse collapse <?php if($num==0){echo ' show ';} ?>"
                                                     aria-labelledby="heading<?php echo $num; ?>"
                                                     data-bs-parent="#accordionExample2">
                                                    <div class="accordion-body mt-3">
                                                        <?php
                                                        $resultparts=$link->query("SELECT * FROM course_part where course_id=".$_GET['id']." AND headline_id=".$rowheadline['id']);
                                                        while($rowparts=$resultparts->fetch_assoc()){?>
                                                            <!-- Course lecture -->
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div class="position-relative d-flex align-items-center">
                                                                    <div>

                                                                    </div>
                                                                    <div class="row g-sm-0 align-items-center">
                                                                        <div class="col-sm-6">
                                                                            <span class="d-inline-block text-truncate ms-2 mb-0 h6 fw-light w-200px"><?php  echo $rowparts['part_title'] ;?></span>
                                                                        </div>
                                                                        <?php  if($rowparts['price_status']==0){?>
                                                                            <div class="col-sm-6">
                                                                <span class="badge text-bg-success ms-2 ms-md-0">
                                                                    <i class="bi bi-unlock-fill me-1"></i>
                                                                    رایگان
                                                                </span>
                                                                            </div>
                                                                            <?php
                                                                        }?>
                                                                    </div>
                                                                </div>
                                                                <div class="position-relative d-flex align-items-center">
                                                                    <p class="mb-0 me-4"><?php  echo $rowparts['time_video'].' ' ;?>دقیقه</p>
                                                                    <?php
                                                                    if($rowparts['price_status']==1){
                                                                        if(isset($_SESSION['login'])){
                                                                            $check_payresult=$link->query("SELECT count(*) as count FROM cart where user_id=".$_SESSION['login']." AND course_id=".$_GET['id']." AND status=1");
                                                                            $check_payrow=$check_payresult->fetch_assoc();
                                                                            if($check_payrow['count']!=0){
                                                                                if($rowparts['file']!=''){ ?>
                                                                                    <a href="files/courses/files/<?php echo $rowparts['file']; ?>" class=" me-2 btn btn-info-soft btn-round btn-sm mb-0 stretched-link " data-bs-toggle="tooltip" title="دانلود فایل ضمیمه" style="height: 40px; width: 40px;line-height: 40px">
                                                                                        <i class="bi bi-file-earmark-text-fill me-0" style="font-size: 1.2rem"></i>
                                                                                    </a>

                                                                                    <?php
                                                                                }?>
                                                                                <a href="files/courses/partvideo/<?php echo $rowparts['video'];?>" download class="me-2 btn btn-success-soft btn-round btn-sm mb-0 stretched-link " data-bs-toggle="tooltip" title="دانلود ویدیو این جلسه" style="height: 40px; width: 40px;line-height: 40px">
                                                                                    <i class="bi bi-download me-0" style="font-size: 1.2rem"></i>
                                                                                </a>
                                                                            <?php
                                                                            }
                                                                            else{?>
                                                                                <div class="col-sm-6">
                                                                <span class="badge text-bg-danger ms-2 ms-md-0">
                                                                برای دسترسی به فایل های جلسه باید ابتدا دوره را خریداری کنید!
                                                                </span>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        else{?>
                                                                            <div class="col-sm-6">
                                                                <span class="badge text-bg-danger ms-2 ms-md-0">
                                                                برای دسترسی به فایل های جلسه باید ابتدا <a href="index.php?page=login" class="text-white">وارد حساب کاربری</a> خود شوید!
                                                                </span>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    else{?>
                                                                        <a href="files/courses/files/<?php echo $rowparts['file'] ; ?>" class=" me-2 btn btn-info-soft btn-round btn-sm mb-0 stretched-link " data-bs-toggle="tooltip" title="دانلود فایل ضمیمه" style="height: 40px; width: 40px;line-height: 40px">
                                                                            <i class="bi bi-file-earmark-text-fill me-0" style="font-size: 1.2rem"></i>
                                                                        </a>
                                                                        <a href="files/courses/partvideo/<?php echo $rowparts['video'];?>" download class="me-2 btn btn-success-soft btn-round btn-sm mb-0 stretched-link " data-bs-toggle="tooltip" title="دانلود ویدیو این جلسه" style="height: 40px; width: 40px;line-height: 40px">
                                                                            <i class="bi bi-download me-0" style="font-size: 1.2rem"></i>
                                                                        </a>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <?php if($rowparts['price_status']==0){ ?>
                                                                        <a href="files/courses/partvideo/<?php echo $rowparts['video'] ; ?>" target="_blank"  class="me-2 btn btn-danger-soft btn-round btn-sm mb-0 stretched-link " data-bs-toggle="tooltip" title="مشاهده پیش نمایش این جلسه" style="height: 40px; width: 40px;line-height: 40px">
                                                                            <i class="fas fa-play me-0"></i>
                                                                        </a>
                                                                    <?php } ?>

                                                                </div>

                                                            </div>
                                                            <hr>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $num++;
                                        }
                                    }
                                    else{?>
                                        <div class="alert alert-warning">جلسه ای برای این دوره ثبت نشده است!</div>
                                    <?php
                                    }
                                    ?>


                                </div>
                                <!-- Course accordion END -->
                            </div>
                            <!-- Content END -->

                            <div class="tab-pane fade" id="course-pills-6" role="tabpanel" aria-labelledby="course-pills-tab-6">
                                <!-- Review START -->
                                <div class="row">
                                    <div class="col-12">
                                        <!-- Comment box -->
                                        <?php
                                        $countcom=$link->query("select count(*) as count from comments where course_id=".$_GET['id']);
                                        $rowcounrcom=$countcom->fetch_assoc();
                                        $resultcomments=$link->query("select comments.* , users.username as username from comments JOIN users ON comments.sender=users.id where comments.course_id=".$_GET['id']." order by comments.date desc ");
                                        if($rowcounrcom['count']>0){?>
                                            <?php
                                            $sum=0;

                                            while ($rowcomments=$resultcomments->fetch_assoc()) {

                                                    $sum+=$rowcomments['rating'];


                                                ?>
                                            <div class="border p-2 p-sm-4 rounded-3 mb-4">
                                                <ul class="list-unstyled mb-0">
                                                    <li class="comment-item">
                                                        <div class="d-flex">
                                                            <!-- Avatar -->
                                                            <div class="avatar avatar-sm flex-shrink-0">
                                                                <a href="#"><img class="avatar-img rounded-circle" src="assets/images/avatar/default.jpg" alt=""></a>
                                                            </div>
                                                            <div class="ms-2">
                                                                <!-- Comment by -->
                                                                <div class="bg-light p-3 rounded">
                                                                    <div class="d-flex justify-content-center">
                                                                        <div class="me-2">
                                                                            <h6 class="mb-1 fw-normal"> <a href="#"><?php echo $rowcomments['username']; ?></a></h6>
                                                                            <p class="mb-0"><?php echo $rowcomments['content']; ?></p>
                                                                        </div>
                                                                        <small><?php echo dateFormat($rowcomments['date']); ?></small>
                                                                    </div>
<!--                                                                    <div class="text-end">-->
<!--                                                                        <a href="#" class="btn btn-info">پاسخ</a>-->
<!--                                                                    </div>-->
                                                                </div>
                                                                <!-- Comment react -->
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>

                                            <?php
                                            }
                                        }
                                        else{?>
                                            <div class="alert alert-warning">تا به حال نظری برای این دوره ثبت نشده است! شما اولین نفر باشید.</div>
                                        <?php
                                        }
                                        ?>
                                        <div class="mt-4">
                                            <?php
                                            $avg=round($sum/$exxxx);
                                            ?>
                                            <h5 class="mb-4">ثبت نظر</h5>
                                            <?php
                                            if(isset($_SESSION['login'])){?>
                                                <form method="post" class="row g-3">
                                                    <!-- Message -->
                                                    <div class="col-12 bg-light-input">
                                                        <textarea name="content" class="form-control" id="exampleFormControlTextarea1" placeholder="نظر خود را بنویسید" rows="3"></textarea>
                                                    </div>
                                                    <input type="hidden" value="5" id="rating" name="rating">
                                                    <style>
                                                        a[href*="intent"] {
                                                            display:inline-block;
                                                            margin-top: 0.4em;
                                                        }

                                                        /*
                                                         * Rating styles
                                                         */
                                                        .rating {
                                                            width: 226px;
                                                            margin: 0 auto 1em;
                                                            font-size: 45px;
                                                            overflow:hidden;
                                                        }
                                                        .rating input {
                                                            float: right;
                                                            opacity: 0;
                                                            position: absolute;
                                                        }
                                                        .rating a,
                                                        .rating label {
                                                            float:right;
                                                            color: #aaa;
                                                            text-decoration: none;
                                                            -webkit-transition: color .4s;
                                                            -moz-transition: color .4s;
                                                            -o-transition: color .4s;
                                                            transition: color .4s;
                                                        }
                                                        .rating label:hover ~ label,
                                                        .rating input:focus ~ label,
                                                        .rating label:hover,
                                                        .rating a:hover,
                                                        .rating a:hover ~ a,
                                                        .rating a:focus,
                                                        .rating a:focus ~ a		{
                                                            color: orange;
                                                            cursor: pointer;
                                                        }
                                                        .rating2 {
                                                            direction: rtl;
                                                        }
                                                        .rating2 a {
                                                            float:none
                                                        }
                                                    </style>
                                                    <div class="rating rating2"><!--
                                                    --><a href="#5" title="Give 5 stars" id="rating5">★</a><!--
                                                    --><a href="#4" title="Give 4 stars" id="rating4">★</a><!--
                                                    --><a href="#3" title="Give 3 stars" id="rating3">★</a><!--
                                                    --><a href="#2" title="Give 2 stars" id="rating2">★</a><!--
                                                    --><a href="#1" title="Give 1 star" id="rating1">★</a>
                                                    </div>
                                                    <!-- Button -->
                                                    <div class="col-12">
                                                        <input name="add_comment" type="submit" class="btn btn-primary mb-0" value="ثبت نظر">
                                                    </div>
                                                </form>

                                            <?php }
                                            else{?>
                                                    <a href="index.php?page=login">
                                                        <div class="alert alert-warning">برای ثبت نظر باید ابتدا وارد حساب کاربری خود شوید!</div>

                                                    </a>
                                            <?php }
                                            ?>
                                        </div>

                                        <!-- Comment item END -->

                                    </div>

                                </div>
                            </div>




                        </div>
                    </div>
                    <!-- Tab contents END -->
                </div>
            </div>
            <!-- Main content END -->

            <!-- Right sidebar START -->
            <div class="col-lg-4 pt-5 pt-lg-0">
                <div class="row mb-5 mb-lg-0">
                    <div class="col-md-6 col-lg-12">
                        <!-- Video START -->
                        <div class="card shadow p-2 mb-4 z-index-9">
                            <div class="overflow-hidden rounded-3">
                                <img src="files/courses/<?php echo $rowcourse['course_image'];?>" class="card-img" alt="course image">
                            </div>
                            <!-- Card body -->
                            <div class="card-body px-3">
                                <!-- Info -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- Price and time -->
                                    <div>
                                        <div class="d-flex align-items-center">
                                            <h3 class="fw-bold mb-0 fs-5 me-2">قیمت این دوره :  <?php echo priceFormat($rowcourse['course_price']); ?> تومان</h3>
<!--                                            <span class="text-decoration-line-through mb-0 me-2">100,000</span>-->
<!--                                            <span class="badge text-bg-orange mb-0">60% تخفیف</span>-->
                                        </div>
<!--                                        <p class="mb-0 text-danger"><i class="fas fa-stopwatch me-2"></i>5 روز باقی مانده</p>-->
                                    </div>


                                </div>

                                <!-- Buttons -->
                                <div class="mt-3 ">
                                    <form method="post" class="d-sm-flex justify-content-sm-between">
                                        <?php
                                        if(isset($_SESSION['login'])){
                                            $countresult=$link->query("select COUNT(*) AS total from cart where user_id=".$_SESSION['login']." AND course_id=".$rowcourse['id']." AND status=1");
                                            $countrow=$countresult->fetch_assoc();
                                            if($countrow['total']==0){
                                                ?>
                                                <a href="files/courses/video/<?php echo $rowcourse['intro_video'] ;?>" class="btn btn-outline-primary mb-0" >مشاهده ویدیوی معرفی دوره</a>
                                                <input type="submit" name="add_to_cart" class="btn btn-totalsecondary mb-0"  value="خرید دوره">
                                                <?php
                                            }
                                            else
                                            {?>
                                                <span class="btn btn-totalprimary col-12 mb-0" >شما دانشجوی این دوره هستید</span>
                                            <?php
                                            }
                                        }
                                        else{?>
                                            <a href="files/courses/video/<?php echo $rowcourse['intro_video'] ;?>" class="btn btn-outline-primary mb-0">مشاهده ویدیوی معرفی دوره</a>
                                            <input type="submit" name="add_to_cart" class="btn btn-totalsecondary mb-0"  value="خرید دوره">
                                        <?php
                                        }
                                        ?>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Video END -->

                        <!-- Course info START -->
                        <div class="card card-body shadow p-4 mb-4">
                            <!-- Title -->
                            <h4 class="mb-3 fs-5">مشخصات دوره</h4>
                            <ul class="list-group list-group-borderless">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="h6 fw-light mb-0"><i class="fas fa-fw fa-book-open text-primary"></i>تعداد جلسات</span>
                                    <?php $cnpart=$link->query("select COUNT(*) AS cn from course_part where course_id=".$_GET['id']);
                                    $cnpartrow=$cnpart->fetch_assoc();
                                    ?>
                                    <span><?php echo $cnpartrow['cn'] ; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="h6 fw-light mb-0"><i class="fas fa-fw fa-clock text-primary"></i>مدت زمان دوره</span>
                                    <?php
                                    $total_time_query = $link->query("SELECT time_video FROM course_part WHERE course_id=" . intval($_GET['id']));
                                    $total_time_seconds = 0;

                                    while($row = $total_time_query->fetch_assoc()) {
                                        $total_time_seconds += (float)$row['time_video'];
                                    }
                                    ?>
                                    <span><?php echo $total_time_seconds.' دقیقه' ; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="h6 fw-light mb-0"><i class="fas fa-fw fa-signal text-primary"></i>سطح دوره</span>
                                    <span><?php echo $rowcourse['level'];?></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="h6 fw-light mb-0"><i class="fas fa-fw fa-user-clock text-primary"></i>تاریخ اخرین بروزرسانی</span>
                                    <span><?php echo dateFormat($rowcourse['update_date']); ?></span>
                                </li>

                            </ul>
                        </div>
                        <!-- Course info END -->
                    </div>
                </div><!-- Row End -->
            </div>
            <!-- Right sidebar END -->

        </div><!-- Row END -->
    </div>
</section>
<!-- =======================
Page content END -->

<!-- =======================
Listed courses START -->
<section class="pt-0">
    <div class="container">
        <!-- Title -->
        <div class="row mb-4">
            <h2 class="mb-0 fs-4">دوره های پیشنهادی</h2>
        </div>
        <div class="row">
            <!-- Slider START -->
            <div class="tiny-slider arrow-round arrow-blur arrow-hover">
                <div class="tiny-slider-inner pb-1" data-autoplay="true" data-arrow="true" data-edge="2" data-dots="false" data-items="3" data-items-lg="2" data-items-sm="1">
                    <?php

                    $resultcourse = $link->query("SELECT courses.* , course_category.category_name as category_name FROM courses join course_category ON courses.cat_id=course_category.category_id ORDER BY courses.update_date DESC LIMIT 6 ");
                    while($rowcourse = $resultcourse->fetch_assoc()){?>
                        ?>
                        <!-- Card item START -->
                        <div>
                            <div class="card action-trigger-hover border bg-transparent">
                                <!-- Image -->
                                <img src="files/courses/<?php echo $rowcourse['course_image'] ; ?>" class="card-img-top" alt="course image">
                                <!-- Ribbon -->
                                <?php if($rowcourse['course_price']==0){ ?>
                                    <div class="ribbon mt-3"><span>رایگان</span></div>
                                <?php } ?>
                                <!-- Card body -->
                                <div class="card-body pb-0">
                                    <!-- Badge and favorite -->
                                    <div class="d-flex justify-content-between mb-3">
									<span class="hstack gap-2">
										<a href="#" class="badge bg-primary bg-opacity-10 text-primary"><?php echo $rowcourse['category_name'] ; ?></a>
										<a href="#" class="badge text-bg-dark"><?php echo $rowcourse['level'] ; ?></a>
									</span>
                                    </div>
                                    <!-- Title -->
                                    <h5 class="card-title fw-normal mt-4"><a href="index.php?page=single&id=<?php echo $rowcourse['id']; ?>"><?php echo $rowcourse['course_title'] ; ?></a></h5>
                                    <!-- Rating -->

                                </div>
                                <!-- Card footer -->
                                <div class="card-footer pt-0 bg-transparent">
                                    <hr>
                                    <!-- Avatar and Price -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <!-- Avatar -->
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm">
                                                <img class="avatar-img rounded-1" src="assets/images/avatar/10.jpg" alt="avatar">
                                            </div>
                                            <p class="mb-0 ms-2"><a href="#" class="h6 fw-light mb-0">مهرداد نوروزی</a></p>
                                        </div>
                                        <!-- Price -->
                                        <div>
                                            <h5 class="text-success mb-0 item-show"><?php echo priceFormat($rowcourse['course_price']).' تومان' ; ?></h5>
                                            <a href="index.php?page=single&id=<?php echo $rowcourse['id']; ?>" class="btn btn-sm btn-success-soft item-show-hover"><i class="fas fa-shopping-cart me-2"></i>مشاهده ی دوره</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card item END -->
                    <?php } ?>
                </div>
            </div>
            <!-- Slider END -->
        </div>


    </div>
</section>
<!-- =======================
Listed courses END -->
    <script>
        $("#rating1").click(function (){
            $("#rating").val("1")
        })
        $("#rating2").click(function (){
            $("#rating").val("2")
        })
        $("#rating3").click(function (){
            $("#rating").val("3")
        })
        $("#rating4").click(function (){
            $("#rating").val("4")
        })
        $("#rating5").click(function (){
            $("#rating").val("5")
        })
    </script>
</main>


<?php
}
else{
    $message='<div class=" container alert alert-danger">عملیات با خطا مواجه شد</br>دوره مورد نظر یافت نشد</div>';
    if(isset($message)){
        echo $message;
    }
}
require_once 'includes/footer.php';
?>