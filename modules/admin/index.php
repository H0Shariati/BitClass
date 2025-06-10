<link rel="stylesheet" type="text/css" href="assets/css/style.css">
<?php
if(isset($_SESSION['login']) && $_SESSION['role']!=1){?>
    <div class="d-flex justify-content-center align-items-center" style="height: 100%;"><a href="index.php?page=login" class="btn btn-totalprimary p-4">از حساب کاربری خود خارج شدید! لطفا برای ادامه فرآیند وارد حساب خود شوید </a></div>
    <?php
    die('ACCESS DENIED!');
}
else if(!isset($_SESSION['login'])){?>
    <div class="d-flex justify-content-center align-items-center" style="height: 100%;"><a href="index.php?page=login" class="btn btn-totalprimary p-4">از حساب کاربری خود خارج شدید! لطفا برای ادامه فرآیند وارد حساب خود شوید </a></div>
<?php
}
else{
    require_once 'modules/admin/includes/header-sidebar.php';

    if(isset($_GET['section'])){
    switch ($_GET['section']) {
        case 'menu':
            require_once 'menu.php';
        break;
        case 'editmenu':
            require_once 'editmenu.php';
        break;
        case 'pages':
            require_once 'pages.php';
        break;
        case 'add_page':
            require_once 'add_page.php';
        break;
        case 'edit_page':
            require_once 'edit_page.php';
        break;
        case 'courses':
            require_once 'courses.php';
        break;
        case 'add_course':
            require_once 'add_course.php';
            break;
        case 'edit_course':
            require_once 'edit_course.php';
        break;
        case 'categories':
            require_once 'categories.php';
        break;
        case 'add_category':
            require_once 'add_category.php';
        break;
        case 'edit_category':
            require_once 'edit_category.php';
        break;
        case 'users':
            require_once 'users.php';
        break;
        case 'edit_user':
            require_once 'edit_users.php';
        break;
        case 'course_part':
            require_once 'course_part.php';
        break;
        case 'add_course_headline':
            require_once 'add_course_headline.php';
        break;
        case 'add_course_part':
            require_once 'add_course_part.php';
        break;
        case 'edit_course_headline':
            require_once 'edit_course_headline.php';
        break;
        case 'edit_course_part':
            require_once 'edit_course_part.php';
        break;
        case 'revenues':
            require_once 'revenues.php';
        break;
        case 'profile':
            require_once 'admin_profile.php';
        break;
        case 'article':
            require_once 'article.php';
        break;
        case 'add_article':
            require_once 'add_article.php';
        break;
        case 'edit_articles':
            require_once 'edit_article.php';
        break;
        case 'site_info':
            require_once 'site_info.php';
        break;

    }
}
else{
            ?>
            <!-- Page main content START -->
            <div class="page-content-wrapper border">

                <!-- Title -->
                <div class="row">
                    <div class="col-12 mb-3">
                        <h1 class="h3 mb-2 mb-sm-0 fs-5">داشبورد</h1>
                    </div>
                </div>

                <!-- Counter boxes START -->
                <div class="row g-4 mb-4">
                    <!-- Counter item -->
                    <div class="col-md-6 col-xxl-3">
                        <div class="card card-body bg-warning bg-opacity-15 p-4 h-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Digit -->
                                <div>
                                    <?php
                                    $countcourse=$link->query('SELECT COUNT(*) as count FROM courses where status=1');
                                    $rowcountcourse=$countcourse->fetch_assoc();
                                    ?>
                                    <h2 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="<?php echo $rowcountcourse['count']; ?>" data-purecounter-delay="200">0</h2>
                                    <span class="mb-0 h6 fw-light">دوره های تکمیل شده</span>
                                </div>
                                <!-- Icon -->
                                <div class="icon-lg rounded-circle bg-warning text-white mb-0"><i class="fas fa-tv fa-fw"></i></div>
                            </div>
                        </div>
                    </div>

                    <!-- Counter item -->
                    <div class="col-md-6 col-xxl-3">
                        <div class="card card-body bg-purple bg-opacity-10 p-4 h-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Digit -->
                                <div>
                                    <?php
                                    $countuser=$link->query('SELECT COUNT(*) as count FROM users where role=3');
                                    $rowcountuser=$countuser->fetch_assoc();
                                    ?>
                                    <h2 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="<?php echo $rowcountuser['count']; ?>"	data-purecounter-delay="200">0</h2>
                                    <span class="mb-0 h6 fw-light">شرکت کنندگان</span>
                                </div>
                                <!-- Icon -->
                                <div class="icon-lg rounded-circle bg-purple text-white mb-0"><i class="fas fa-user-tie fa-fw"></i></div>
                            </div>
                        </div>
                    </div>

                    <!-- Counter item -->
                    <div class="col-md-6 col-xxl-3">
                        <div class="card card-body bg-primary bg-opacity-10 p-4 h-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Digit -->
                                <div>
                                    <?php
                                    $countcourse_s0=$link->query('SELECT COUNT(*) as count FROM courses where status=0');
                                    $rowcountcourse_s0=$countcourse_s0->fetch_assoc();
                                    ?>
                                    <h2 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="<?php echo $rowcountcourse_s0['count']; ?>"	data-purecounter-delay="200">0</h2>
                                    <span class="mb-0 h6 fw-light">درحال ضبط</span>
                                </div>
                                <!-- Icon -->
                                <div class="icon-lg rounded-circle bg-primary text-white mb-0"><i class="fas fa-user-graduate fa-fw"></i></div>
                            </div>
                        </div>
                    </div>

                    <!-- Counter item -->
                    <div class="col-md-6 col-xxl-3">
                        <div class="card card-body bg-success bg-opacity-10 p-4 h-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Digit -->
                                <div>
                                    <div class="d-flex">
                                        <h3 class=" mb-2 fw-bold">
                                            <div id="clock"></div>

                                            <script>
                                                function updateClock() {
                                                    const now = new Date();
                                                    const hours = now.getHours().toString().padStart(2, '0');
                                                    const minutes = now.getMinutes().toString().padStart(2, '0');
                                                    const seconds = now.getSeconds().toString().padStart(2, '0');

                                                    document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
                                                }

                                                setInterval(updateClock, 1000);
                                                updateClock(); // برای نمایش سریع در لحظه اول
                                            </script>

                                            </h3>
                                    </div>
                                    <span class="mb-0 h6 mt-4">
                                        <?php $time=time(); echo dateFormat($time); ?>
                                    </span>
                                </div>
                                <!-- Icon -->
                                <div class="icon-lg rounded-circle bg-success text-white mb-0"><i class="bi bi-stopwatch-fill fa-fw"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Counter boxes END -->

                <!-- Chart and Ticket START -->
                <div class="row g-4 mb-4">


                    <!-- Chart START -->

                    <div class="col-xxl-12">
                        <div class="card shadow h-100">

                            <!-- Card header -->
                            <div class="card-header p-4 border-bottom">
                                <h5 class="card-header-title">آمار فروش</h5>
                            </div>

                            <!-- Card body -->
                            <div class="card-body">
                                <div class="table-responsive border-0 rounded-3">
                                    <table class="table table-dark-gray align-middle p-4 mb-0 table-hover">
                                        <thead>
                                        <tr>
                                            <th>تصویر شاخص</th>
                                            <th>نام دوره</th>
                                            <th>مبلغ</th>
                                            <th>تعداد فروش/تعداد دانشجو</th>
                                            <th>وضعیت</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $resultcart=$link->query('SELECT * FROM courses');
//                                        $resultcart = $link->query("SELECT cart.*, courses.course_title as course_title , courses.course_price as price ,courses.course_image as course_image , courses.status as course_status FROM cart join courses on cart.course_id=courses.id");
                                        while ($cart = $resultcart->fetch_assoc()) {
                                            echo '<tr>';
                                            echo '<td><div class="w-60px"><img class="rounded" src="files/courses/'.$cart['course_image'].'"></div></td>';
                                            echo '<td>' . $cart['course_title'] . '</td>';
                                            echo '<td>' . priceFormat($cart['course_price']) . ' تومان</td>';
                                            $countstudent = $link->query("SELECT count(*) as count FROM cart join courses on cart.course_id=courses.id where cart.course_id=".$cart['id']);
                                            $count=$countstudent->fetch_assoc();
                                            echo '<td class="text-center">' . $count['count'] . '</td>';
                                            echo '<td>' . ($cart['status'] == 1 ? '<span class="btn btn-success btn-xs">فعال</span>' : '<span class="btn btn-danger btn-xs">غیر فعال</span>') . '</td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Chart END -->


                </div>
                <!-- Chart and Ticket END -->


            </div>
            <!-- Page main content END -->
        <?php


    }

?>





<?php
require_once 'modules/admin/includes/footer.php';
}
?>