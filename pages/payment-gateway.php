<?php
// دریافت اطلاعات از فرم
$amount = isset($_SESSION['price']) ? intval($_SESSION['price']) : 0;
$courses = isset($_POST['courses']) ? $_POST['courses'] : '';

// اطلاعات درخواست پرداخت
$data = array(
    "merchant_id" => "XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX", // مرچنت کد سندباکس
    "amount" => $amount * 10, // تبدیل به ریال (تومان به ریال)
    "callback_url" => "http://localhost/BitClass/index.php?page=result_pay&courses=".$courses,    "description" => "پرداخت دوره های آموزشی",
    "metadata" => [
        "email" => $_SESSION['email'], // ایمیل کاربر از سشن
//        "mobile" => $_SESSION['mobile'] // موبایل کاربر از سشن
    ],
);

$jsonData = json_encode($data);
$ch = curl_init('https://sandbox.zarinpal.com/pg/v4/payment/request.json');
// 🔥 راه حل 1: غیرفعال کردن بررسی SSL (فقط برای محیط لوکال)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // غیرفعال کردن بررسی گواهی SSL
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // غیرفعال کردن بررسی هاست

// سایر تنظیمات cURL
curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonData)
]);

$result = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);
$result = json_decode($result, true);

if ($err) {
    die("cURL Error: " . $err); // نمایش خطا (در صورت وجود)
} elseif (empty($result['errors'])) {
    if ($result['data']['code'] == 100) {
        // انتقال کاربر به درگاه پرداخت
// جایگزین کردن header() با JavaScript redirect
        echo '<script>window.location.href = "https://sandbox.zarinpal.com/pg/StartPay/'.$result['data']['authority'].'"</script>';
} else {
    die("زرین پال خطا داد: " . $result['errors']['message']);
}
?>































<?php
//defined('site') or die('ACCESS DENIED!');
//require_once 'includes/header.php';
//if(isset($_GET['action'])){
//    switch($_GET['action']){
//        case 'payed':
//            $link->query("UPDATE cart SET `status`=1 WHERE user_id=".$_SESSION['login']);
//            if($link->errno == 0) {
//                echo '<script>window.location="index.php?page=result_pay";</script>';
//                $_SESSION['pay_status']=true;
//
////                echo '<div class="alert alert-success">پرداخت با موفقیت انجام شد</div>';
//            } else {
//                echo '<script>window.location="index.php?page=result_pay";</script>';
//                $_SESSION['pay_status']=false;
//            }
//        break;
//        case 'paynot':
//            echo '<script>window.location="index.php?page=result_pay";</script>';
//            $_SESSION['pay_status']=false;
//        break;
//    }
//}
//?>
<!--    <div class="row col-lg-6 mx-auto text-center my-3  mx-auto">-->
<!--    --><?php //if(isset($message)){
//        echo $message;
//    } ?>
<!--        <div class=" card card-body shadow p-4">-->
<!--            <h4>درگاه پرداخت اینترنتی</h4>-->
<!--            <hr>-->
<!--            <form class="row g-3 pt-4">-->
<!--                 Card number -->-->
<!--                <div class="col-12 row mb-4">-->
<!--                    <label class="col-sm-4 col-form-label text-start ps-4">شماره کارت <span class="text-danger">*</span></label>-->
<!--                    <div class="col-sm-8">-->
<!--                        <input type="text" class="form-control" placeholder="xxxx xxxx xxxx xxxx">-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-12 row mb-4">-->
<!--                    <label class="col-sm-4 col-form-label text-start ps-4">شماره شناسایی دوم (CVV2) <span class="text-danger">*</span></label>-->
<!--                    <div class="col-sm-7">-->
<!--                        <input type="text" class="form-control">-->
<!--                    </div>-->
<!--                    <div class="col-sm-1 p-2">-->
<!--                        <i class="bi bi-grid-3x3-gap text-secondary h4"></i>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-12 row mb-4">-->
<!--                    <label class="col-sm-4 col-form-label text-start ps-4">تاریخ انقضای کارت<span class="text-danger">*</span></label>-->
<!--                    <div class="col-sm-3">-->
<!--                        <input type="text" class="form-control" placeholder="ماه">-->
<!--                    </div>-->
<!--                    <div class="col-sm-3">-->
<!--                        <input type="text" class="form-control" placeholder="سال">-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-12 row mb-4">-->
<!--                    <label class="col-sm-4 col-form-label text-start ps-4">کد امنیتی<span class="text-danger">*</span></label>-->
<!--                    <div class="col-sm-3">-->
<!--                        <input type="text" class="form-control">-->
<!--                    </div>-->
<!--                    <div class="col-sm-4 ">-->
<!--                        <h4 class="text-decoration-line-through ">123456</h4>-->
<!--                    </div>-->
<!--                    <div class="col-sm-1 p-2">-->
<!--                        <i class="bi bi-arrow-clockwise text-secondary h4"></i>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-12 row mb-4">-->
<!--                    <label class="col-sm-4 col-form-label text-start ps-4">رمز دوم کارت<span class="text-danger">*</span></label>-->
<!--                    <div class="col-sm-4">-->
<!--                        <input type="text" class="form-control">-->
<!--                    </div>-->
<!--                    <div class="col-sm-3">-->
<!--                        <a href="#" class="btn btn-info">دریافت رمز پویا</a>-->
<!--                    </div>-->
<!--                    <div class="col-sm-1 p-2">-->
<!--                        <i class="bi bi-grid-3x3-gap text-secondary h4"></i>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-12 row mb-4">-->
<!--                    <label class="col-sm-4 col-form-label text-start ps-4">ایمیل<span class="text-danger">*</span></label>-->
<!--                    <div class="col-sm-8">-->
<!--                        <input type="text" class="form-control">-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-12 row ">-->
<!--                    <label class="col-sm-4 col-form-label "></label>-->
<!--                    <div class="col-sm-8 row">-->
<!--                        <div class="col-sm-8">-->
<!--                            <a href="index.php?page=payment&action=payed" class="btn btn-totalprimary col-12">پرداخت</a>-->
<!--                        </div>-->
<!--                        <div class="col-sm-4">-->
<!--                            <a href="index.php?page=payment&action=paynot" class="btn btn-totalsecondary col-12">انصراف</a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <hr>-->
<!--                <div class="col-12 row my-2">-->
<!--                    <label class="col-sm-4 col-form-label ">مبلغ قابل پرداخت:</label>-->
<!--                    <div class="col-sm-8 row">-->
<!--                       <h4 class="text-success">--><?php //echo priceFormat($_POST['total_price']).' تومان'; ?><!--</h4>-->
<!---->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--            </form>-->
<!---->
<!--        </div>-->
<!--    </div>-->
<?php
}
require_once 'includes/footer.php';
?>
