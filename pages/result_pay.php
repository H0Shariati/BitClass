
<?php
require_once 'includes/header.php';

if (isset($_GET['Status']) && $_GET['Status'] == 'OK') {
    $authority = $_GET['Authority'];
    $courses = $_GET['courses'];
//    $amount=0;
//    $result = $link->query("SELECT courses.course_price as course_price,cart.* FROM courses join cart on cart.course_id=courses.id WHERE cart.id = ".$courses);
//    while ($row = $result->fetch_assoc()) {
//        $amount += $row['course_price'];
//    }
//

//    $amount = 0;
//    $course_ids = explode(',', $courses);
//    foreach ($course_ids as $id) {
//        $result = $link->query("SELECT course_price FROM courses WHERE id = ".$id);
//        if ($row = $result->fetch_assoc()) {
//            $amount += $row['course_price']; // جمع قیمت دوره‌ها
//        }
//    }
//    $amount_in_rials = $amount * 10; // تبدیل تومان به ریال
//    if ($amount_in_rials < 1000) { // حداقل 1000 ریال = 100 تومان
//        die("مبلغ پرداخت باید حداقل 100 تومان باشد");
//    }

    $data = array(
        "merchant_id" => "XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX",
        "amount" => $_SESSION['price']*10, // مقدار باید به ریال باشد
        "authority" => $authority
    );
    $jsonData = json_encode($data);
    $ch = curl_init('https://sandbox.zarinpal.com/pg/v4/payment/verify.json');

// 🔥 راه حل 1: غیرفعال کردن بررسی SSL (فقط برای محیط لوکال)
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // غیرفعال کردن بررسی گواهی SSL
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // غیرفعال کردن بررسی هاست
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonData)
    ));

    $result = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    $result = json_decode($result, true);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo '<div class="container text-center my-4 ">';
        if (empty($result['errors'])) {
            if ($result['data']['code'] == 100) {
                // پرداخت موفق
                $course_ids = explode(',', $courses);

                foreach ($course_ids as $id) {
                    $link->query("UPDATE cart SET `status`=1 WHERE user_id=".$_SESSION['login']);
                }
                echo '<i class="bi bi-check-circle fa-8x text-success"></i>';
                echo '<div class="text-success h4">پرداخت با موفقیت انجام شد</div>';
                echo '<a href="index.php" class="btn btn-totalprimary mt-4 mb-0">بازگشت به خانه</a>';
                echo '</div>';
//                echo '<script>toastr.success("پرداخت با موفقیت انجام شد");</script>';
//                echo '<script>setTimeout(function(){ window.location.href = "index.php?page=profile"; }, 3000);</script>';
            } elseif ($result['data']['code'] == 101) {
                echo '<i class="bi bi-check-circle fa-8x text-success"></i>';
                echo '<div class="text-success h4">پرداخت قبلا انجام شده است</div>';
                echo '<a href="index.php" class="btn btn-totalprimary mt-4 mb-0">بازگشت به خانه</a>';
                echo '</div>';
            } else {
                echo '<i class="bi bi-x-circle fa-8x text-danger"></i>';
                echo '<div class="text-danger h4">متاسفانه عملیات پرداخت به درستی انجام نشد</div>';
                echo '<a href="index.php" class="btn btn-totalprimary mt-4 mb-0">بازگشت به خانه</a>';
                echo '</div>';
            }
        } else {
            $result_raw = curl_exec($ch);
            if ($result_raw === false) {
                die('Curl error: ' . curl_error($ch));
            }
            echo '<pre>';
            print_r(json_decode($result_raw, true));
            echo '</pre>';
            die();
            echo '<i class="bi bi-x-circle fa-8x text-danger"></i>';
            echo '<div class="text-danger h4">خطا در بررسی پرداخت</div>';
            echo '<a href="index.php" class="btn btn-totalprimary mt-4 mb-0">بازگشت به خانه</a>';
            echo '</div>';
        }
    }
} else {
    echo '<script>toastr.error("پرداخت لغو شد");</script>';
    echo '<script>setTimeout(function(){ window.location.href = "index.php?page=cart"; }, 3000);</script>';
}
?>
</div>
<?php
require_once 'includes/footer.php';
?>








<?php
//defined('site') or die('ACCESS DENIED!');
//require_once 'includes/header.php';
//?>
<!--<div class="container text-center my-4 ">-->
<?php
//if (isset($_SESSION['pay_status'])){
//    switch ($_SESSION['pay_status']) {
//        case true:
//            echo '<i class="bi bi-check-circle fa-8x text-success"></i>';
//            echo '<div class="text-success h4">پرداخت با موفقیت انجام شد</div>';
//            echo '<a href="index.php" class="btn btn-totalprimary mt-4 mb-0">بازگشت به خانه</a>';
//            echo '</div>';
//        break;
//        case false:
//            echo '<i class="bi bi-x-circle fa-8x text-danger"></i>';
//            echo '<div class="text-danger h4">متاسفانه عملیات پرداخت به درستی انجام نشد</div>';
//            echo '<a href="index.php" class="btn btn-totalprimary mt-4 mb-0">بازگشت به خانه</a>';
//            echo '</div>';
//            break;
//    }
//}
//require_once 'includes/footer.php';
//?>
<!---->
