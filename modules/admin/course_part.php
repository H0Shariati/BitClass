<?php
defined('site') or die('ACCESS DENIED!');
$resultcourse=$link->query("SELECT * FROM courses where id=".$_GET['id']);
$rowcourse=$resultcourse->fetch_assoc();
if(isset($_GET['action'])){
    switch ($_GET['action']) {
        case 'delete_headline':
            $link->query("delete from course_part where headline_id=".$_GET['headline_id']);
            $link->query("delete from course_headline where id=".$_GET['headline_id']);

            if($link->errno==0 && $link->affected_rows==1){
                $message = '<script>toastr.success("عملیات حذف با موفقیت انجام شد");</script>';
            }
            else if($link->errno==1451){
                $message = '<script>toastr.error("این دوره به قسمت های دیگری مرتبط است و حذف ان باعث ایجاد مشکل می شود");</script>';
            }
            else if($link->errno>0){
                $message = '<script>toastr.error("خطا در حذف اطلاعات");</script>';
            }
        break;
        case 'delete_part':
            $link->query("delete from course_part where id=".$_GET['part_id']);
            if($link->errno==0 && $link->affected_rows==1){
                $message = '<script>toastr.success("عملیات حذف با موفقیت انجام شد");</script>';
            }
            else if($link->errno==1451){
                $message = '<script>toastr.error("این دوره به قسمت های دیگری مرتبط است و حذف ان باعث ایجاد مشکل می شود");</script>';
            }
            else if($link->errno>0){
                $message = '<script>toastr.error("خطا در حذف اطلاعات");</script>';
            }
        break;
    }
}
?>
<div class="page-content-wrapper border">
    <?php
    if(isset($message)) {
        echo $message;
    }
    ?>

    <!-- Title -->
    <div class="row mb-3">
        <div class="col-12 d-sm-flex align-items-center justify-content-between">
            <h1 class=" h3  fs-5 mb-0 ms-1 text-warning"><?php echo $rowcourse['course_title'];?></h1>
            <a class="btn btn-danger-soft" href="index.php?page=admin&section=courses">بازگشت</a>

        </div>
        <div>
            <hr> <!-- Divider -->
            <div class="row">
                <!-- Add lecture Modal button -->
                <div class="d-sm-flex justify-content-sm-between align-items-center mb-3">
                    <h5 class="mb-2 mb-sm-0">مدیریت جلسات دوره</h5>
                    <a href="index.php?page=admin&section=add_course_headline&id=<?php echo $_GET['id']; ?>" class="btn btn-sm btn-primary-soft mb-2"><i class="bi bi-plus-circle me-2"></i>افزودن سرفصل</a>
                </div>
                <!-- Edit lecture START -->
                <div class="accordion accordion-icon accordion-bg-light" id="accordionExample2">
                    <!-- Item START -->
                    <?php
                    $resultheadline=$link->query("SELECT * FROM course_headline where course_id=".$_GET['id']);
                    $num=0;
                    while ($rowheadline=$resultheadline->fetch_assoc()){

                        ?>
                        <div class="accordion-item mb-2">
                        <h6 class="accordion-header font-base" id="heading<?php echo $num; ?>">
                            <button class="accordion-button fw-bold rounded d-inline-block collapsed d-block pe-5 d-flex justify-content-between " type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse<?php echo $num; ?>"
                                    aria-expanded="false"
                                    aria-controls="collapse<?php echo $num; ?>">
                                <?php echo $rowheadline['headline_title']; ?>
                                <div>
                                <a href="index.php?page=admin&section=edit_course_headline&headline_id=<?php echo $rowheadline['id'] ; ?>&id=<?php echo $_GET['id']; ?>" class="btn btn-success-soft btn-sm mx-1" data-bs-toggle="tooltip" title="ویرایش"><i class="bi bi-pencil-square me-1"></i></a>
                                <a href="index.php?page=admin&section=course_part&action=delete_headline&headline_id=<?php echo $rowheadline['id'] ; ?>&id=<?php echo $_GET['id']; ?>" class="btn btn-danger-soft btn-sm mx-1" data-bs-toggle="tooltip" title="حذف"><i class="bi bi-trash me-1"></i></a>
                                </div>
                            </button>


                        </h6>

                        <div id="collapse<?php echo $num; ?>" class="accordion-collapse collapse"
                             aria-labelledby="heading<?php echo $num; ?>"
                             data-bs-parent="#accordionExample2">
                            <!-- Topic START -->
                            <div class="accordion-body mt-3">
                                <?php
                                $resultparts=$link->query("SELECT * FROM course_part where course_id=".$_GET['id']." AND headline_id=".$rowheadline['id']);
                                while($rowparts=$resultparts->fetch_assoc()){?>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="position-relative">
                                            <a href="#" class="btn btn-info-soft btn-sm mx-1"><i class="bi bi-play-fill me-1"></i></a>

                                            <span class="ms-2 mb-0 h6 fw-light"><?php  echo $rowparts['part_title'] ;?></span>
                                        </div>
                                        <!-- Edit and cancel button -->
                                        <div>
                                            <a href="index.php?page=admin&section=edit_course_part&action=delete&part_id=<?php echo $rowparts['id']; ?>&headline_id=<?php echo $rowheadline['id']; ?>&id=<?php echo $_GET['id']; ?>" class="btn btn-success-soft btn-sm mx-1" data-bs-toggle="tooltip" title="ویرایش"><i class="bi bi-pencil-square me-1"></i></a>
                                            <a href="index.php?page=admin&section=course_part&action=delete_part&part_id=<?php echo $rowparts['id']; ?>&id=<?php echo $_GET['id']; ?>" class="btn btn-danger-soft btn-sm mx-1" data-bs-toggle="tooltip" title="حذف"><i class="bi bi-trash me-1"></i></a>
                                        </div>
                                    </div>
                                    <!-- Divider -->
                                    <hr>
                                <?php
                                }
                                ?>
                                <div class="text-center">
                                        <a href="index.php?page=admin&section=add_course_part&headline_id=<?php echo $rowheadline['id'] ; ?>&id=<?php echo $_GET['id'] ; ?>" class="btn btn-sm btn-dark mb-0"><i class="bi bi-plus-circle me-2"></i>افزودن جلسه</a>
                                </div>
                            </div>
                            <!-- Topic END -->
                        </div>
                    </div>
                    <?php
                    $num++;
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>
