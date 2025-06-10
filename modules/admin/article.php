<?php
defined('site') or die('ACCESS DENIED!');
if(isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'delete':
            $link->query("delete from articles where id=".$_GET['id']);

            if($link->errno==0 && $link->affected_rows==1){
                $message = '<script>toastr.success("عملیات حذف با موفقیت انجام شد");</script>';

            }
            else if($link->errno==1451){
                $message = '<script>toastr.error("کلید خارجی");</script>';
            }
            else if($link->errno>0){
                $message = '<script>toastr.error("خطا در حذف اطلاعات");</script>';

            }
            break;
    }
}
?>

<div class="page-content-wrapper border">

    <!-- Title -->
    <div class="row mb-3">
        <div class="col-12 d-sm-flex justify-content-between align-items-center">
            <h1 class="h3 mb-2 mb-sm-0 fs-5">لیست مقالات</h1>
            <div>
                <a href="index.php?page=admin&section=add_article" class="btn btn-sm btn-primary mb-2">افزودن مقاله جدید</a>

            </div>

        </div>
    </div>
    <?php

    if(isset($message)){
        echo $message;
    }
    ?>



    <!-- Card START -->
    <div class="card bg-transparent border">

        <!-- Card header START -->
        <div class="card-header bg-light border-bottom">
            <!-- Search and select START -->
            <div class="row g-3 align-items-center justify-content-between">
                <!-- Search bar -->
                <div class="col-md-12">
                    <form method="post" class="rounded position-relative">
                        <input name="search" class="form-control bg-body" type="text" placeholder="جستجو" aria-label="Search">
                        <button name="searchsub" class="bg-transparent p-2 position-absolute top-50 end-0 translate-middle-y border-0 text-primary-hover text-reset" type="submit">
                            <i class="fas fa-search fs-6 "></i>
                        </button>
                    </form>
                </div>

                <!-- Search END -->
            </div>
            <!-- Card header END -->

            <!-- Card body START -->
            <div class="card-body">
                <div class="table-responsive border-0 rounded-3">
                    <table class="table table-dark-gray align-middle p-4 mb-0 table-hover">
                        <thead>
                        <tr>
                            <th>تصویر شاخص</th>
                            <th>عنوان مقاله</th>
                            <th>تاریخ انتشار</th>
                            <th>تگ ها</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (isset($_POST['searchsub'])){
                            $resultarticles=$link->query("SELECT * FROM articles where articles.title like '%".$_POST['search']."%'");
                            if($resultarticles->num_rows==0){
                                echo '<div class="alert alert-danger">نتیجه ای یافت نشد</div>';
                            }

                        }
                        else{
                            $resultarticles = $link->query("SELECT * FROM articles");

                        }

                        while ($row_article = $resultarticles->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td><div class="w-60px"><img class="rounded" src="files/articles/'.$row_article['image'].'"></div></td>';
                            echo '<td>' . $row_article['title'] . '</td>';
                            echo '<td>' . dateFormat($row_article['published_at']) . '</td>';
                            echo '<td>';
                            $tags = json_decode($row_article['tags'], true);
                            if(is_array($tags) && !empty($tags)) {
                                echo '<div class="d-flex flex-wrap gap-2">';
                                foreach($tags as $tag) {
                                    echo '<span class="badge text-bg-secondary">'.$tag.'</span>';
                                }
                                echo '</div>';
                            } else {
                                echo '-';
                            }
                            echo '</td>';

                            echo '<td>' . ($row_article['status'] == 1 ? '<span class="btn btn-success btn-xs">فعال</span>' : '<span class="btn btn-danger btn-xs">غیر فعال</span>') . '</td>';
                            echo '<td style="white-space:nowrap;">';
                            echo '<a href="index.php?page=admin&section=edit_articles&id=' . $row_article['id'] . '" class="btn btn-warning btn-sm mx-1"><i class="bi bi-pencil-square me-1"></i>ویرایش</a>';
                            echo '<a href="index.php?page=admin&section=article&action=delete&id='. $row_article['id'] . '" class="btn btn-danger btn-sm mx-1"><i class="bi bi-trash me-1"></i>حذف</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Card body END -->

            <!-- Card footer START -->
            <div class="card-footer bg-transparent pt-0">
                <!-- Pagination START -->
                <div class="d-sm-flex justify-content-sm-between align-items-sm-center">
                    <!-- Content -->
                    <p class="mb-0 text-center text-sm-start">نمایش 1 تا 8 از 20</p>
                    <!-- Pagination -->
                    <nav class="d-flex justify-content-center mb-0" aria-label="navigation">
                        <ul class="pagination pagination-sm pagination-primary-soft d-inline-block d-md-flex rounded mb-0">
                            <li class="page-item mb-0"><a class="page-link" href="#" tabindex="-1"><i class="fas fa-angle-right"></i></a></li>
                            <li class="page-item mb-0"><a class="page-link" href="#">1</a></li>
                            <li class="page-item mb-0 active"><a class="page-link" href="#">2</a></li>
                            <li class="page-item mb-0"><a class="page-link" href="#">3</a></li>
                            <li class="page-item mb-0"><a class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li>
                        </ul>
                    </nav>
                </div>
                <!-- Pagination END -->
            </div>
            <!-- Card footer END -->
        </div>
        <!-- Card END -->
    </div>

