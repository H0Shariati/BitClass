<?php
defined('site') or die('ACCESS DENIED!');
require_once 'includes/header.php';



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
        $comment_add = $link->query("INSERT INTO articles_comments (article_id, sender, content, date, rating) VALUES ('".$_GET['id']."', '".$_SESSION['login']."', '".$_POST['content']."', ".$date.", '".$_POST['rating']."')");
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
$countcom=$link->query("select count(*) as count from articles_comments where article_id=".cleanId($_GET['id']));
$rowcounrcom=$countcom->fetch_assoc();
$exxxx=$rowcounrcom['count'];
if($exxxx==0) {
    $exxxx=1;
}
$avg_rating=$link->query("select articles_comments.* , users.username as username from articles_comments JOIN users ON articles_comments.sender=users.id where articles_comments.article_id=".$_GET['id']." order by articles_comments.date desc ");
while($rowavg=$avg_rating->fetch_assoc()){
    $sum+=$rowavg['rating'];
}
$avg_rating=round($sum/$exxxx);


$resultblog=$link->query("select * from articles where id=".cleanId($_GET['id']));
if($resultblog->num_rows>0){
    $rowblog=$resultblog->fetch_assoc();


?>
<main>
    <?php
    if(isset($message)){
        echo $message;
    }
    ?>
    <section class="bg-light py-0 py-sm-3">
        <div class="container">
            <div class="row py-5">
                <div class="col-lg-12 text-center">
                    <!-- Badge -->
                    <!-- Title -->
                    <h1 class="fs-3"><?php echo $rowblog['title'];?></h1>
                    <!-- Content -->
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item me-3 mb-1 mb-sm-0"><i class="fas fa-star text-warning me-2"></i><?php echo $avg_rating ; ?>/5 امتیاز</li>
                        <li class="list-inline-item me-3 mb-1 mb-sm-0"><i class="bi bi-stopwatch-fill text-info me-2"></i><?php echo $rowblog['reading_time']." دقیقه زمان مطالعه"; ?></li>
                        <li class="list-inline-item me-3 mb-1 mb-sm-0"><i class="bi bi-patch-exclamation-fill text-danger me-2"></i>انتشار در <?php echo dateFormat($rowblog['published_at']); ?></li>
                    </ul>

                </div>
            </div>
        </div>
    </section>

<section class="pb-0 pt-4 pb-md-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- image START -->
                <div class="row mt-4">
                    <div class="col-xl-10 mx-auto">
                        <!-- Card item START -->
                        <div class="card overflow-hidden h-200px h-sm-300px h-lg-400px h-xl-500px rounded-3 text-center" style="background-image:url(files/articles/<?php echo $rowblog['image'];  ?>); background-position: center left; background-size: cover;">
                        </div>
                        <!-- Card item END -->
                    </div>
                </div>
                <!-- Video END -->

                <!-- Quote and content START -->
                <div class="row mt-4">
                    <!-- Content -->
                    <div class="col-xl-10 mt-4 mt-lg-0 mx-auto">
                        <p><?php echo $rowblog['content']; ?></p>
                    </div>
                    <hr class="col-xl-10 mx-auto my-4" >
                    <!-- Tags and share START -->
                    <div class=" col-xl-10  mx-auto d-lg-flex justify-content-lg-between mb-4">
                        <!-- Social media button -->
                        <div class="align-items-center mb-3 mb-lg-0">
                            <p>اشتراک گذاری : </p>
                            <ul class="list-inline mb-0 mb-2 mb-sm-0">
                                <li class="list-inline-item"> <a class="btn px-2 btn-sm bg-facebook" href="#"><i class="fab fa-fw fa-facebook-f"></i></a> </li>
                                <li class="list-inline-item"> <a class="btn px-2 btn-sm bg-instagram-gradient" href="#"><i class="fab fa-fw fa-instagram"></i></a> </li>
                                <li class="list-inline-item"> <a class="btn px-2 btn-sm bg-twitter" href="#"><i class="fab fa-fw fa-twitter"></i></a> </li>
                                <li class="list-inline-item"> <a class="btn px-2 btn-sm bg-linkedin" href="#"><i class="fab fa-fw fa-linkedin-in"></i></a> </li>
                            </ul>
                        </div>
                        <!-- Popular tags -->
                        <div class="align-items-center">
                            <p>برچسب ها: </p>

                            <ul class="list-inline mb-0 social-media-btn">
                                <?php
                                $tags = json_decode($rowblog['tags'], true);
                                if(is_array($tags) && !empty($tags)) {
                                    echo '<div class="d-flex flex-wrap gap-2">';
                                    foreach($tags as $tag) {
                                        echo ' <li class="list-inline-item"> <a class="btn btn-outline-light btn-sm mb-lg-0">'.$tag.'</a> </li>';
                                    }
                                    echo '</div>';
                                } else {
                                    echo '-';
                                }
                                ?>

                            </ul>
                        </div>
                    </div>
                    <!-- Tags and share END -->
                </div>

                <!-- Comment review and form START -->
                <div class="mt-4">
                    <!-- Comment START -->
                    <div class="col-md-10 mx-auto">
                        <h3 class="fs-5">دیدگاه کاربران</h3>

                    <?php
                    $countcom=$link->query("select count(*) as count from articles_comments where article_id=".$_GET['id']);
                    $rowcounrcom=$countcom->fetch_assoc();
                    $resultcomments=$link->query("select articles_comments.* , users.username as username from articles_comments JOIN users ON articles_comments.sender=users.id where articles_comments.article_id=".$_GET['id']." order by articles_comments.date desc ");
                    if($rowcounrcom['count']>0){?>
                        <?php
                        $sum=0;
                        while ($rowcomments=$resultcomments->fetch_assoc()) {
                            $sum+=$rowcomments['rating'];
                            ?>
                        <!-- Comment level 1-->
                        <div class="my-4 d-flex">
                            <img class="avatar avatar-md rounded-circle me-3" src="assets/images/avatar/default.jpg" alt="avatar">
                            <div class=" bg-light p-3 rounded">
                                <div class="d-flex justify-content-center">
                                    <div class="me-2">
                                        <h6 class="mb-1 fw-normal"> <a href="#"><?php echo $rowcomments['username']; ?></a></h6>
                                        <p class="mb-0"><?php echo $rowcomments['content']; ?></p>
                                    </div>
                                    <small><?php echo dateFormat($rowcomments['date']); ?></small>
                                </div>
                            </div>
                        </div>
                            <?php
                        }
                    }
                    else{?>
                        <div class="alert alert-warning">تا به حال نظری برای این مقاله ثبت نشده است! شما اولین نفر باشید.</div>
                        <?php
                    }
                    ?>
                    </div>
                    <!-- Comment END -->
                    <hr class="col-10 mx-auto py-2">

                    <!-- Form START -->
                    <div class="col-md-10 mx-auto">
                        <?php
                        $avg=round($sum/$exxxx);
                        ?>
                        <!-- Title -->
                        <h3 class="mt-3 mt-sm-0 fs-5">ثبت دیدگاه</h3>
                        <div class="mt-4">
                            <?php
                            $avg=round($sum/$exxxx);
                            ?>
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
                                    <div class="rating rating2 mb-2"><!--
                                                    --><a href="#5" title="Give 5 stars" id="rating5">★</a><!--
                                                    --><a href="#4" title="Give 4 stars" id="rating4">★</a><!--
                                                    --><a href="#3" title="Give 3 stars" id="rating3">★</a><!--
                                                    --><a href="#2" title="Give 2 stars" id="rating2">★</a><!--
                                                    --><a href="#1" title="Give 1 star" id="rating1">★</a>
                                    </div>
                                    <!-- Button -->
                                    <div class="col-12">
                                        <input name="add_comment" type="submit" class="btn btn-primary mb-0" value="ثبت دیدگاه">
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
                    </div>
                    <!-- Form END -->
                </div>
                <!-- Comment review and form END -->
            </div>
        </div> <!-- Row END -->
    </div>
</section>
<section class=" bg-light py-6 text-center">
        <div class="container">
            <!-- Title -->
            <div class="row mb-6">
                <div class="col-10 mx-auto">
                    <h2 class="mb-0 fs-4">مقالات مشابه</h2>
                    <p>بیش از 1000 مقاله منحصر به فرد در لیست دوره های آنلاین</p>
                </div>
            </div>

            <!-- Slider START -->
            <div class="tiny-slider arrow-round arrow-hover arrow-dark">
                <div class="tiny-slider-inner" data-autoplay="false" data-arrow="true" data-edge="2" data-dots="false" data-items="4" data-items-lg="2" data-items-sm="1">

                    <?php
                    $more_articles=$link->query("SELECT * FROM articles where id!=".$_GET['id']." ORDER BY id DESC LIMIT 5");
                    while ($row_blog=$more_articles->fetch_assoc()) {?>
                        <div class="col-3">
                            <div class="card">
                                <div class="rounded-top overflow-hidden">
                                    <div class="card-overlay-hover">
                                        <!-- Image -->
                                        <img src="files/articles/<?php echo $row_blog['image']; ?>" class="card-img-top" alt="course image">
                                    </div>
                                    <!-- Hover element -->
                                    <div class="card-img-overlay">
                                        <div class="card-element-hover d-flex justify-content-end">
                                            <a href="index.php?page=blog_detail&id=<?php echo $row_blog['id']; ?>" class="icon-md bg-white rounded-circle text-center">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card body -->
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <!-- Title -->
                                    <h5 class="card-title fw-normal"><a href="index.php?page=blog_detail&id=<?php echo $row_blog['id']; ?>"><?php echo $row_blog['title'] ;?></a></h5>
                                    <p class="text-truncate-2"><?php echo strip_tags($row_blog['content']) ;?></p>
                                    <!-- Info -->
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0 fw-normal"><i class="bi bi-vector-pen me-1"></i>ادمین</h6>
                                        <span class="small"><?php echo dateFormat($row_blog['published_at']) ;?></span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <?php
                    }
                    ?>
                </div>
            </div>
            <!-- Slider END -->
        </div>
    </section>
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
    $message='<div class=" container alert alert-danger">عملیات با خطا مواجه شد</br>مقاله مورد نظر یافت نشد</div>';
    if(isset($message)){
        echo $message;
    }
}
require_once 'includes/footer.php';
?>