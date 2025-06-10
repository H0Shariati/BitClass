<?php
require_once 'core/database.php';
$q = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';
$q = $link->real_escape_string($q);

if ($q != '') {
    switch ($q){
        case 'مقدماتی':?>
            <div class="row mt-3">
                <div class="col-12">
                    <!-- Course Grid START -->
                    <div class="row g-4">
                        <?php
                        $sql = "SELECT * FROM courses WHERE level='مقدماتی'";
                        $result_course = $link->query($sql);
                        if ($result_course->num_rows > 0) {
                            while($row_course = $result_course->fetch_assoc()) {?>
                                <div class="col-sm-6 col-lg-4 col-xl-3">
                                    <div class="card shadow h-100">
                                        <div class="rounded-top overflow-hidden">
                                            <div class="card-overlay-hover">
                                                <!-- Image -->
                                                <img src="files/courses/<?php echo $row_course['course_image']; ?>" class="card-img-top" alt="course image">
                                            </div>
                                            <!-- Hover element -->
                                            <div class="card-img-overlay">
                                                <div class="card-element-hover d-flex justify-content-end">
                                                    <a href="index.php?page=single&id=<?php echo $row_course['id']; ?>" class="icon-md bg-white rounded-circle text-center">
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
                                                        $cnParticipants=$link->query("SELECT count(*) as cn FROM cart WHERE course_id=".$row_course['id']." AND status=1");
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
                                                        $countcom=$link->query("select count(*) as count from comments where course_id=".$row_course['id']);
                                                        $rowcounrcom=$countcom->fetch_assoc();
                                                        $avg_rating=$link->query("select comments.* , users.username as username from comments JOIN users ON comments.sender=users.id where comments.course_id=".$row_course['id']." order by comments.date desc ");
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
                                            <h5 class="card-title fw-normal"><a href="index.php?page=single&id=<?php echo $row_course['id']; ?>"><?php echo $row_course['course_title']; ?></a></h5>
                                            <!-- Badge and Price -->
                                            <div class="d-flex justify-content-between align-items-center mb-0">
                                                <?php
                                                $get_category_name=$link->query("SELECT courses.*,course_category.category_name as category_name FROM courses join course_category on courses.cat_id=course_category.category_id WHERE cat_id=".$row_course['cat_id']);
                                                $row_category_name=$get_category_name->fetch_assoc();
                                                ?>

                                                <a href="#" class="badge bg-info bg-opacity-10 text-info me-2"><i class="fas fa-circle small fw-bold"></i><?php  echo ' '.$row_category_name['category_name']; ?> </a>
                                                <!-- Price -->
                                                <h3 class="text-success mb-0 fs-5 fw-normal"><?php if($row_course['course_price']!=0){echo priceFormat($row_course['course_price']).' تومان';} else{echo 'رایگان';}  ?></h3>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <?php
                            }
                        } else {?>
                            <div class=" text-center p-6 alert alert-danger mt-2">دوره ی رایگانی وجود ندارد!!<br>منتظر دوره های جذاب ما باشید....</div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <?php
            break;
        case 'متوسط':?>
            <div class="row mt-3">
                <div class="col-12">
                    <!-- Course Grid START -->
                    <div class="row g-4">
                        <?php
                        $sql = "SELECT * FROM courses WHERE level='متوسط'";
                        $result_course = $link->query($sql);
                        if ($result_course->num_rows > 0) {
                            while($row_course = $result_course->fetch_assoc()) {?>
                                <div class="col-sm-6 col-lg-4 col-xl-3">
                                    <div class="card shadow h-100">
                                        <div class="rounded-top overflow-hidden">
                                            <div class="card-overlay-hover">
                                                <!-- Image -->
                                                <img src="files/courses/<?php echo $row_course['course_image']; ?>" class="card-img-top" alt="course image">
                                            </div>
                                            <!-- Hover element -->
                                            <div class="card-img-overlay">
                                                <div class="card-element-hover d-flex justify-content-end">
                                                    <a href="index.php?page=single&id=<?php echo $row_course['id']; ?>" class="icon-md bg-white rounded-circle text-center">
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
                                                        $cnParticipants=$link->query("SELECT count(*) as cn FROM cart WHERE course_id=".$row_course['id']." AND status=1");
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
                                                        $countcom=$link->query("select count(*) as count from comments where course_id=".$row_course['id']);
                                                        $rowcounrcom=$countcom->fetch_assoc();
                                                        $avg_rating=$link->query("select comments.* , users.username as username from comments JOIN users ON comments.sender=users.id where comments.course_id=".$row_course['id']." order by comments.date desc ");
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
                                            <h5 class="card-title fw-normal"><a href="index.php?page=single&id=<?php echo $row_course['id']; ?>"><?php echo $row_course['course_title']; ?></a></h5>
                                            <!-- Badge and Price -->
                                            <div class="d-flex justify-content-between align-items-center mb-0">
                                                <?php
                                                $get_category_name=$link->query("SELECT courses.*,course_category.category_name as category_name FROM courses join course_category on courses.cat_id=course_category.category_id WHERE cat_id=".$row_course['cat_id']);
                                                $row_category_name=$get_category_name->fetch_assoc();
                                                ?>

                                                <a href="#" class="badge bg-info bg-opacity-10 text-info me-2"><i class="fas fa-circle small fw-bold"></i><?php  echo ' '.$row_category_name['category_name']; ?> </a>
                                                <!-- Price -->
                                                <h3 class="text-success mb-0 fs-5 fw-normal"><?php if($row_course['course_price']!=0){echo priceFormat($row_course['course_price']).' تومان';} else{echo 'رایگان';}  ?></h3>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <?php
                            }
                        } else {?>
                            <div class=" text-center p-6 alert alert-danger mt-2">همه ی دوره های ما رایگان هستند!!<br>منتظر دوره های جدید ما باشید....</div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <?php
            break;
        case 'پیشرفته':?>
            <div class="row mt-3">
                <div class="col-12">
                    <!-- Course Grid START -->
                    <div class="row g-4">
                        <?php
                        $sql = "SELECT * FROM courses WHERE level='پیشرفته'";
                        $result_course = $link->query($sql);
                        if ($result_course->num_rows > 0) {
                            while($row_course = $result_course->fetch_assoc()) {?>
                                <div class="col-sm-6 col-lg-4 col-xl-3">
                                    <div class="card shadow h-100">
                                        <div class="rounded-top overflow-hidden">
                                            <div class="card-overlay-hover">
                                                <!-- Image -->
                                                <img src="files/courses/<?php echo $row_course['course_image']; ?>" class="card-img-top" alt="course image">
                                            </div>
                                            <!-- Hover element -->
                                            <div class="card-img-overlay">
                                                <div class="card-element-hover d-flex justify-content-end">
                                                    <a href="index.php?page=single&id=<?php echo $row_course['id']; ?>" class="icon-md bg-white rounded-circle text-center">
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
                                                        $cnParticipants=$link->query("SELECT count(*) as cn FROM cart WHERE course_id=".$row_course['id']." AND status=1");
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
                                                        $countcom=$link->query("select count(*) as count from comments where course_id=".$row_course['id']);
                                                        $rowcounrcom=$countcom->fetch_assoc();
                                                        $avg_rating=$link->query("select comments.* , users.username as username from comments JOIN users ON comments.sender=users.id where comments.course_id=".$row_course['id']." order by comments.date desc ");
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
                                            <h5 class="card-title fw-normal"><a href="index.php?page=single&id=<?php echo $row_course['id']; ?>"><?php echo $row_course['course_title']; ?></a></h5>
                                            <!-- Badge and Price -->
                                            <div class="d-flex justify-content-between align-items-center mb-0">
                                                <?php
                                                $get_category_name=$link->query("SELECT courses.*,course_category.category_name as category_name FROM courses join course_category on courses.cat_id=course_category.category_id WHERE cat_id=".$row_course['cat_id']);
                                                $row_category_name=$get_category_name->fetch_assoc();
                                                ?>

                                                <a href="#" class="badge bg-info bg-opacity-10 text-info me-2"><i class="fas fa-circle small fw-bold"></i><?php  echo ' '.$row_category_name['category_name']; ?> </a>
                                                <!-- Price -->
                                                <h3 class="text-success mb-0 fs-5 fw-normal"><?php if($row_course['course_price']!=0){echo priceFormat($row_course['course_price']).' تومان';} else{echo 'رایگان';}  ?></h3>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <?php
                            }
                        } else {?>
                            <div class=" text-center p-6 alert alert-danger mt-2">همه ی دوره های ما رایگان هستند!!<br>منتظر دوره های جدید ما باشید....</div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

            <?php
            break;
    }
}
else{?>
    <div class="row mt-3">
        <div class="col-12">
            <!-- Course Grid START -->
            <div class="row g-4">
                <?php
                $sql = "SELECT * FROM courses";
                $result_course = $link->query($sql);
                if ($result_course->num_rows > 0) {
                    while($row_course = $result_course->fetch_assoc()) {?>
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card shadow h-100">
                                <div class="rounded-top overflow-hidden">
                                    <div class="card-overlay-hover">
                                        <!-- Image -->
                                        <img src="files/courses/<?php echo $row_course['course_image']; ?>" class="card-img-top" alt="course image">
                                    </div>
                                    <!-- Hover element -->
                                    <div class="card-img-overlay">
                                        <div class="card-element-hover d-flex justify-content-end">
                                            <a href="index.php?page=single&id=<?php echo $row_course['id']; ?>" class="icon-md bg-white rounded-circle text-center">
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
                                                $cnParticipants=$link->query("SELECT count(*) as cn FROM cart WHERE course_id=".$row_course['id']." AND status=1");
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
                                                $countcom=$link->query("select count(*) as count from comments where course_id=".$row_course['id']);
                                                $rowcounrcom=$countcom->fetch_assoc();
                                                $avg_rating=$link->query("select comments.* , users.username as username from comments JOIN users ON comments.sender=users.id where comments.course_id=".$row_course['id']." order by comments.date desc ");
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
                                    <h5 class="card-title fw-normal"><a href="index.php?page=single&id=<?php echo $row_course['id']; ?>"><?php echo $row_course['course_title']; ?></a></h5>
                                    <!-- Badge and Price -->
                                    <div class="d-flex justify-content-between align-items-center mb-0">
                                        <?php
                                        $get_category_name=$link->query("SELECT courses.*,course_category.category_name as category_name FROM courses join course_category on courses.cat_id=course_category.category_id WHERE cat_id=".$row_course['cat_id']);
                                        $row_category_name=$get_category_name->fetch_assoc();
                                        ?>

                                        <a href="#" class="badge bg-info bg-opacity-10 text-info me-2"><i class="fas fa-circle small fw-bold"></i><?php  echo ' '.$row_category_name['category_name']; ?> </a>
                                        <!-- Price -->
                                        <h3 class="text-success mb-0 fs-5 fw-normal"><?php if($row_course['course_price']!=0){echo priceFormat($row_course['course_price']).' تومان';} else{echo 'رایگان';}  ?></h3>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "نتیجه ای پیدا نشد.";
                }
                ?>
            </div>
        </div>
    </div>

    <?php

}
?>
