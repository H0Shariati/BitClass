<?php
defined('site') or die('ACCESS DENIED!');
require_once 'includes/header.php';
if(isset($_GET['action'])){
    switch ($_GET['action']) {
        case 'delete':
            $link->query("DELETE FROM cart where id=".$_GET['id']);

            if($link->errno==0 && $link->affected_rows==1){
                $message = '<script>toastr.success("دوره ی مورد نظر از سبد خرید شما حذف شد.");</script>';
            }
            else if($link->errno==1451){
                $message = '<script>toastr.error("کلید خارجی");</script>';
            }
            else if($link->errno>0){
                $message = '<script>toastr.error("خطا در حذف دوره");</script>';
            }
        break;
    }
}
$resultcart=$link->query("SELECT courses.*,cart.* FROM cart JOIN courses ON cart.course_id=courses.id WHERE cart.user_id=".$_SESSION['login']." AND cart.status=0");

?>
    <section class="py-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bg-light p-4 text-center rounded-3">
                        <h1 class="m-0 fs-2">سبد خرید</h1>
                        <!-- Breadcrumb -->
                        <div class="d-flex justify-content-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-dots mb-0">
                                    <li class="breadcrumb-item"><a href="#">صفحه اصلی</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">سبد خرید</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
if($link->affected_rows!=0){
?>
    <section class="pt-5">
        <div class="container">
            <?php if(isset($message)){
                echo $message;
            } ?>

            <div class="row g-4 g-sm-5">
                <!-- Main content START -->
                <div class="col-lg-8 mb-4 mb-sm-0">
                    <div class="card card-body p-4 shadow">

                        <div class="table-responsive border-0 rounded-3">
                            <!-- Table START -->
                            <table class="table align-middle p-4 mb-0">
                                <!-- Table head -->
                                <!-- Table body START -->
                                <tbody class="border-top-0">
                                <?php
                                    $total_price=0;
                                    $num=0;
                                    while($cart_items=$resultcart->fetch_assoc()){
                                    ?>
                                    <tr>

                                        <!-- Course item -->
                                        <td><?php echo ++$num ; ?></td>
                                        <td>
                                            <div class="d-lg-flex align-items-center">
                                                <!-- Image -->
                                                <div class="w-100px w-md-80px mb-2 mb-md-0">
                                                    <img src="files/courses/<?php echo $cart_items['course_image'] ; ?>" class="rounded" alt="">
                                                </div>
                                                <!-- Title -->
                                                <h6 class="mb-0 ms-lg-3 mt-2 mt-lg-0">
                                                    <a  href="#"><?php echo $cart_items['course_title']; ?></a>
                                                </h6>
                                            </div>
                                        </td>

                                        <!-- Amount item -->
                                        <td class="text-center">
                                            <h5 class="text-success-emphasis mb-0"><?php echo priceFormat($cart_items['course_price']).' تومان'; ?></h5>
                                        </td>
                                        <!-- Action item -->
                                        <td>
                                            <a href="index.php?page=cart&action=delete&id=<?php echo $cart_items['id']; ?>" class="btn btn-danger-soft btn-sm mx-1"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                    $total_price += $cart_items['course_price'];
                                    $course_payed[] = $cart_items['id'];
                                    $_SESSION['price']=$total_price;

                                }  ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Main content END -->

                <!-- Right sidebar START -->
                <div class="col-lg-4">
                    <!-- Card total START -->
                    <div class="card card-body p-4 shadow">
                        <!-- Title -->
                        <h4 class="mb-3 fs-5">صورت حساب</h4>
                        <div class="mb-3">
                            <div class="input-group mt-2">
                                <input class="form-control form-control" placeholder="کد تخفیف">
                                <button type="button" class="btn btn-totalsecondary">اعمال</button>
                            </div>

                        </div>
                        <hr>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>انتخاب نحوه پرداخت</span>
                            </div>
                            <div class="input-group mt-2  d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input small" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                    <label class="form-check-label small" for="flexRadioDefault1">
                                        درگاه پرداخت آنلاین
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input small" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                    <label class="form-check-label small" for="flexRadioDefault1">
                                        کیف پول (موجودی: 0 تومان)
                                    </label>
                                </div>
                            </div>

                        </div>
                        <hr>

                        <!-- Price and detail -->
                        <ul class="list-group list-group-borderless mb-2">
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="h6 fw-light mb-0">مبلغ کل</span>
                                <span class="h6 fw-light mb-0 fw-bold"><?php echo priceFormat($total_price); ?> تومان</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="h6 fw-light mb-0">کد تخفیف</span>
                                <span class="text-danger">0%</span>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="h5 mb-0">مبلغ نهایی</span>
                                <span class="h5 mb-0"><?php echo priceFormat($total_price); ?> تومان</span>
                            </li>
                        </ul>

                        <!-- Button -->
                        <!-- Button -->
                        <!-- در فایل cart.php (یا صفحه سبد خرید) -->
                        <form action="index.php?page=payment" method="post">
                            <input type="hidden" name="amount" value="<?php echo $_SESSION['price']; ?>">
                            <input type="hidden" name="courses" value="<?php echo implode(',', $course_payed); ?>">
                            <button class="btn btn-totalprimary col-12" type="submit">پرداخت</button>
                        </form>

                        <!-- Content -->
                        <p class="small mb-0 mt-2 text-center">با تکمیل خرید خود، <a href="#"><strong>شرایط و قوانین سایت</strong></a> را خواهید پذیرفت.</p>

                    </div>
                    <!-- Card total END -->
                </div>
                <!-- Right sidebar END -->

            </div><!-- Row END -->
        </div>
    </section>
    <?php
}
elseif($link->affected_rows==0){
    ?>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <!-- Image -->
                    <img src="assets/images/element/cart.svg" class="h-150px h-md-200px mb-3" alt="">
                    <!-- Subtitle -->
                    <h2 class="fs-4">سبد خرید شما در حال حاضر خالی است!</h2>
                    <!-- info -->
                    <p class="mb-0">لطفاً تمام دوره های موجود را بررسی کنید و دوره هایی را خریداری کنید که نیازهای شما را برآورده می کند.</p>
                    <!-- Button -->
                    <a href="index.php" class="btn btn-totalprimary mt-4 mb-0">بازگشت به خانه</a>
                </div>
            </div>
        </div>
    </section>

    <?php
}
    ?>
<?php
require_once 'includes/footer.php';
?>