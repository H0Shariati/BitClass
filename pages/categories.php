<?php
defined('site') or die('ACCESS DENIED!');
require_once 'includes/header.php';
$result_category = $link->query("SELECT courses.* , course_category.category_name as category_name FROM courses join course_category ON courses.cat_id=course_category.category_id where courses.cat_id=".$_GET['id']);
//$row_category = $result_category->fetch_assoc();
?>

<section class="pt-4 pb-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php
                $result_categorys = $link->query("SELECT * FROM course_category where category_id=".$_GET['id']);
                $row_categorys = $result_categorys->fetch_assoc();?>
                <div class="bg-light p-4 text-center rounded-3">
                    <h1 class="m-0 fs-2"><?php echo $row_categorys['category_name']; ?></h1>
                    <!-- Breadcrumb -->
                    <div class="d-flex justify-content-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-dots mb-0">
                                <li class="breadcrumb-item"><a href="index.php">صفحه اصلی</a></li>
                                <li class="breadcrumb-item"><a href="index.php?page=all_course">دسته بندی دوره ها</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo $row_categorys['category_name']; ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
if($result_category->num_rows > 0){?>
    <section class="pt-0">
        <div class="container">

            <!-- Filter bar START -->
            <form method="post" action="" class="bg-light border p-4 rounded-3 my-4 z-index-9 position-relative" >
                <div class="row g-3">

                    <!-- Input -->
                    <!--                <div class="col-xl-3">-->
                    <!--                    <input name="search" class="form-control me-1" type="search" placeholder="جستجو بین دوره ها">-->
                    <!--                </div>-->

                    <!-- Select item -->
                    <div class="">

                        <div class="row g-3">
                            <div class="col-md-1 h5"><i class="bi bi-funnel-fill me-1 text-warning"></i>فیلتر ها :</div>
                            <!-- Select items -->
                            <div class="col-sm-6 col-md-3 pb-2 pb-md-0">

                                <select name="category" onchange="filter_category(this.value)" class="form-select form-select-sm js-choice" aria-label=".form-select-sm example" disabled>
                                    <option value=""> همه دسته بندی ها</option>

                                    <?php
                                    $result_categori= $link->query("SELECT * FROM course_category");
                                    while ($row_categori = $result_categori->fetch_assoc()) {?>
                                        <option value="<?php $row_categori['category_id'] ?>" <?php if($row_categori['category_id']==$_GET['id']){echo ' selected ';} ?> ><?php echo $row_categori['category_name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Search item -->
                            <div class="col-sm-6 col-md-3 pb-2 pb-md-0">
                                <select name="price" onchange="filter_price(this.value)" class="form-select form-select-sm js-choice" aria-label=".form-select-sm example">
                                    <option value="">قیمت</option>
                                    <option value="0">رایگان</option>
                                    <option value="1">خریدنی</option>
                                </select>
                            </div>

                            <!-- Search item -->
                            <div class="col-sm-6 col-md-3 pb-2 pb-md-0">
                                <select name="level" onchange="filter_level(this.value)" class="form-select form-select-sm js-choice" aria-label=".form-select-sm example">
                                    <option value="">مهارت</option>
                                    <option value="مقدماتی">مقدماتی</option>
                                    <option value="متوسط">متوسط</option>
                                    <option value="پیشرفته">پیشرفته</option>
                                </select>
                            </div>

                            <div class="col-sm-6 col-md-2 pb-2 pb-md-0">
                                <select name="price" onchange="filter_sort(this.value)" class="form-select form-select-sm js-choice" aria-label=".form-select-sm example">
                                    <option value="">مرتب سازی بر اساس ...</option>
                                    <option value="1">جدید ترین</option>
                                    <option value="2">ارزان ترین</option>
                                    <option value="3">گران ترین</option>
                                </select>
                            </div>
                            <!-- Search item -->
                        </div> <!-- Row END -->
                    </div>
                </div> <!-- Row END -->
            </form>
             <!-- Filter bar END -->
            <div id="txtHint">
                <div class="row mt-3">
                    <!-- Main content START -->
                    <div class="col-12">

                        <!-- Course Grid START -->
                        <div class="row g-4">
                            <?php
                            while ($row_category = $result_category->fetch_assoc()){
                                ?>
                                <div class="col-sm-6 col-lg-4 col-xl-3">
                                    <div class="card shadow h-100">
                                        <div class="rounded-top overflow-hidden">
                                            <div class="card-overlay-hover">
                                                <!-- Image -->
                                                <img src="files/courses/<?php echo $row_category['course_image']; ?>" class="card-img-top" alt="course image">
                                            </div>
                                            <!-- Hover element -->
                                            <div class="card-img-overlay">
                                                <div class="card-element-hover d-flex justify-content-end">
                                                    <a href="index.php?page=single&id=<?php echo $row_category['id']; ?>" class="icon-md bg-white rounded-circle text-center">
                                                        <i class="fas fa-shopping-cart text-danger"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Card body -->
                                        <div class="card-body d-flex flex-column justify-content-between">
                                            <!-- Rating and avatar -->
                                            <div class="d-flex justify-content-between">
                                                <!-- Rating and info -->
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <!-- Info -->
                                                    <li class="list-inline-item d-flex justify-content-center align-items-center">
                                                        <div class="icon-md bg-orange bg-opacity-10 text-orange rounded-circle"><i class="fas fa-user-graduate"></i></div>
                                                        <?php
                                                        $cnParticipants=$link->query("SELECT count(*) as cn FROM cart WHERE course_id=".$row_category['id']." AND status=1");
                                                        $rowParticipants=$cnParticipants->fetch_assoc();
                                                        ?>
                                                        <span class="h6 fw-light mb-0 ms-2"><?php echo $rowParticipants['cn'] ; ?></span>
                                                    </li>
                                                    <!-- Rating -->
                                                    <li class="list-inline-item d-flex justify-content-center align-items-center">
                                                        <div class="icon-md bg-warning bg-opacity-15 text-warning rounded-circle"><i class="fas fa-star"></i></div>
                                                        <?php
                                                        //avg-rating
                                                        $sum=0;
                                                        $countcom=$link->query("select count(*) as count from comments where course_id=".$row_category['id']);
                                                        $rowcounrcom=$countcom->fetch_assoc();
                                                        $avg_rating=$link->query("select comments.* , users.username as username from comments JOIN users ON comments.sender=users.id where comments.course_id=".$row_category['id']." order by comments.date desc ");
                                                        while($rowavg=$avg_rating->fetch_assoc()){
                                                            $sum+=$rowavg['rating'];
                                                        }
                                                        if($rowcounrcom['count']!=0){
                                                            $avg_rating=round($sum/$rowcounrcom['count']);
                                                        }
                                                        else{
                                                            $avg_rating=5;
                                                        }

                                                        ?>
                                                        <span class="h6 fw-light mb-0 ms-2"><?php echo $avg_rating ; ?></span>
                                                    </li>
                                                </ul>
                                                <!-- Avatar -->
                                                <div class="avatar avatar-sm">
                                                    <img class="avatar-img rounded-circle" src="assets/images/avatar/09.jpg" alt="avatar">
                                                </div>
                                            </div>
                                            <!-- Divider -->
                                            <hr>
                                            <!-- Title -->
                                            <h5 class="card-title fw-normal"><a href="index.php?page=single&id=<?php echo $row_category['id']; ?>"><?php echo $row_category['course_title']; ?></a></h5>
                                            <!-- Badge and Price -->
                                            <div class="d-flex justify-content-between align-items-center mb-0">

                                                <a href="#" class="badge bg-info bg-opacity-10 text-info me-2"><i class="fas fa-circle small fw-bold"></i><?php  echo ' '.$row_category['category_name']; ?> </a>
                                                <!-- Price -->
                                                <h3 class="text-success mb-0 fs-5 fw-normal"><?php if($row_category['course_price']!=0){echo priceFormat($row_category['course_price']).' تومان';} else{echo 'رایگان';}  ?></h3>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <?php
                            }


                            ?>




                        </div>
                        <!-- Course Grid END -->

                        <!-- Pagination START -->
                        <div class="col-12">
                            <nav class="mt-4 d-flex justify-content-center" aria-label="navigation">
                                <ul class="pagination pagination-primary-soft d-inline-block d-md-flex rounded mb-0">
                                    <li class="page-item mb-0"><a class="page-link" href="#" tabindex="-1"><i class="fas fa-angle-double-right"></i></a></li>
                                    <li class="page-item mb-0"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item mb-0 active"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item mb-0"><a class="page-link" href="#">..</a></li>
                                    <li class="page-item mb-0"><a class="page-link" href="#">6</a></li>
                                    <li class="page-item mb-0"><a class="page-link" href="#"><i class="fas fa-angle-double-left"></i></a></li>
                                </ul>
                            </nav>
                        </div>
                        <!-- Pagination END -->
                    </div>
                    <!-- Main content END -->
                </div><!-- Row END -->

            </div>
            <script>
                function filter_category(str) {
                    const xhttp = new XMLHttpRequest();
                    xhttp.onload = function() {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                    xhttp.open("POST", "index.php?page=filter_category&q="+str);
                    xhttp.send();
                }
            </script>
            <script>
                function filter_price(str) {
                    const xhttp = new XMLHttpRequest();
                    xhttp.onload = function() {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                    xhttp.open("POST", "index.php?page=cat_filter_price&id=<?php echo $_GET['id'];?>&q="+str);
                    xhttp.send();
                }
            </script>
            <script>
                function filter_level(str) {
                    const xhttp = new XMLHttpRequest();
                    xhttp.onload = function() {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                    xhttp.open("POST", "index.php?page=cat_filter_level&id=<?php echo $_GET['id'];?>&q="+str);
                    xhttp.send();
                }
            </script>
            <script>
                function filter_sort(str) {
                    const xhttp = new XMLHttpRequest();
                    xhttp.onload = function() {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                    xhttp.open("POST", "index.php?page=cat_filter_sort&id=<?php echo $_GET['id'];?>&q="+str);
                    xhttp.send();
                }
            </script>
        </div>
    </section>

    <?php
}else{?>
    <div class="container text-center p-6 alert alert-danger">برای این دسته بندی دوره ای ثبت نشده است!<br>منتظر دوره های جذاب ما باشید....</div>

<?php
}
?>


<?php
require_once 'includes/footer.php';
?>
