<?php
defined('site') or die('ACCESS DENIED!');
?>
<style>
    .icon-selection {
        display: flex;
        flex-wrap: wrap;
    }

    .icon-option {
        margin: 5px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .icon-option:hover {
        background-color: #e0e0e0;
    }

    .icon-option.selected {
        border-color: #007bff;
        background-color: #007bff;
        color: white;
    }  </style>

<div class="page-content-wrapper border">

    <!-- Title -->
    <div class="row mb-3">
        <div class="col-12">
            <h1 class="h3 mb-0 fs-5">درآمدها</h1>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Earning item -->
        <div class="col-sm-6 col-lg-4">
            <div class="p-4 bg-primary bg-opacity-10 rounded-3">
                <?php
                $total_price_cart = $link->query("SELECT cart.*,users.username as username , courses.course_title as course , courses.course_price as price FROM cart join users on cart.user_id=users.id join courses on cart.course_id=courses.id where cart.status=1");
                $total_price=0;
                while ($row_price = $total_price_cart->fetch_assoc()) {
                    $total_price=$total_price+$row_price['price'];
                }
                ?>
                <h6>فروش کل</h6>
                <h2 class="mb-0 fs-4 text-primary"><?php echo priceFormat($total_price) ; ?> تومان</h2>
            </div>
        </div>

        <!-- Earning item -->
        <div class="col-sm-6 col-lg-4">
            <div class="p-4 bg-purple bg-opacity-10 rounded-3">
                <?php
                $paynot_price_cart = $link->query("SELECT cart.*,users.username as username , courses.course_title as course , courses.course_price as price FROM cart join users on cart.user_id=users.id join courses on cart.course_id=courses.id where cart.status=0");
                $pay_not_price=0;
                while ($row_price = $paynot_price_cart->fetch_assoc()) {
                    $pay_not_price=$pay_not_price+$row_price['price'];
                }
                ?>
                <h6>در انتظار پرداخت
                </h6>
                <h2 class="mb-0 fs-4 text-purple"><?php echo priceFormat($pay_not_price) ; ?> تومان</h2>
            </div>
        </div>

        <!-- Earning item -->
        <div class="col-sm-6 col-lg-4">
            <div class="p-4 bg-orange bg-opacity-10 rounded-3">
                <h6>درآمدهای این ماه</h6>
                <h2 class="mb-0 fs-4 text-orange">420,000 تومان</h2>
            </div>
        </div>
    </div> <!-- Row END -->

    <!-- All review table START -->
    <div class="card bg-transparent border">

        <!-- Card header START -->
        <div class="card-header bg-light border-bottom">
            <h5 class="mb-0">تاریخچه فاکتور</h5>
        </div>
        <!-- Card header END -->

        <!-- Card body START -->
        <div class="card-body pb-0">
            <!-- Table START -->
            <div class="table-responsive border-0 rounded-3">
                <table class="table table-dark-gray align-middle p-4 mb-0 table-hover">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>دانشجو</th>
                        <th>نام دوره خریداری شده</th>
                        <th>مبلغ</th>
                        <th>وضعیت پرداخت</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $resultcart = $link->query("SELECT cart.*,users.username as username , courses.course_title as course , courses.course_price as price FROM cart join users on cart.user_id=users.id join courses on cart.course_id=courses.id order by cart.id DESC ");
                    $num = 1; // برای شماره گذاری ردیف‌ها

                    while ($cart = $resultcart->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $num++ . '</td>';
                        echo '<td>' . $cart['username'] . '</td>';
                        echo '<td>' . $cart['course'] . '</td>';
                        echo '<td>' . priceFormat($cart['price']) . ' تومان</td>';
                        switch ($cart['status']) {
                            case 0:
                                echo '<td><span class="btn btn-danger btn-sm">پرداخت نشده</span></td>';
                                break;
                            case 1:
                                echo '<td><span class="btn btn-success btn-sm">پرداخت شده</span></td>';
                                break;
                        }
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <!-- Table END -->
        </div>
        <!-- Card body END -->

        <!-- Card footer START -->
        <div class="card-footer bg-transparent">
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
    <!-- All review table END -->
</div>


