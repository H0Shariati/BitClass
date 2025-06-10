<?php
defined('site') or die('ACCESS DENIED!');
require_once 'includes/header.php';
?>
<section class="py-5">
    <div class="container">
        <div class="row position-relative">
            <!-- SVG decoration -->
            <figure class="position-absolute top-0 start-0 d-none d-sm-block">
                <svg width="22px" height="22px" viewBox="0 0 22 22" style="transform: scale(-1,1)">
                    <polygon class="fill-purple" points="22,8.3 13.7,8.3 13.7,0 8.3,0 8.3,8.3 0,8.3 0,13.7 8.3,13.7 8.3,22 13.7,22 13.7,13.7 22,13.7 "></polygon>
                </svg>
            </figure>

            <!-- Title and breadcrumb -->
            <div class="col-lg-10 mx-auto text-center position-relative">
                <!-- SVG decoration -->
                <figure class="position-absolute top-50 end-0 translate-middle-y">
                    <svg width="27px" height="27px"style="transform: scale(-1,1)">
                        <path class="fill-orange" d="M13.122,5.946 L17.679,-0.001 L17.404,7.528 L24.661,5.946 L19.683,11.533 L26.244,15.056 L18.891,16.089 L21.686,23.068 L15.400,19.062 L13.122,26.232 L10.843,19.062 L4.557,23.068 L7.352,16.089 L-0.000,15.056 L6.561,11.533 L1.582,5.946 L8.839,7.528 L8.565,-0.001 L13.122,5.946 Z"></path>
                    </svg>
                </figure>
                <h1 class="fs-2">لیست مقالات</h1>
                <div class="d-flex justify-content-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-dots mb-0">
                            <li class="breadcrumb-item"><a href="index.php">صفحه اصلی</a></li>
                            <li class="breadcrumb-item"><a href="#">لیست مقالات</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="position-relative pt-0 pt-lg-5">
    <div class="container">
        <div class="row g-4">
            <?php
            $result_blog=$link->query("SELECT * FROM articles where status!=0 ORDER BY published_at DESC ");
            if($result_blog->num_rows>0){
                while ($row_blog=$result_blog->fetch_assoc()){?>
                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="card shadow h-100">
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
            }
            else{?>
                <div class="container text-center p-6 alert alert-danger">متاسفانه هنوز موفق به انتشار مقاله نشده ایم!<br>منتظر مقاله های جذاب ما باشید....</div>

                <?php
            }
            ?>



        </div> <!-- Row end -->

        <!-- Pagination START -->
        <nav class="d-flex justify-content-center mt-5" aria-label="navigation">
            <ul class="pagination pagination-primary-soft rounded mb-0">
                <li class="page-item mb-0"><a class="page-link" href="#" tabindex="-1"><i class="fas fa-angle-double-right"></i></a></li>
                <li class="page-item mb-0"><a class="page-link" href="#">1</a></li>
                <li class="page-item mb-0 active"><a class="page-link" href="#">2</a></li>
                <li class="page-item mb-0"><a class="page-link" href="#">..</a></li>
                <li class="page-item mb-0"><a class="page-link" href="#">6</a></li>
                <li class="page-item mb-0"><a class="page-link" href="#"><i class="fas fa-angle-double-left"></i></a></li>
            </ul>
        </nav>
        <!-- Pagination END -->

    </div>
</section>
<?php
require_once 'includes/footer.php';
?>

