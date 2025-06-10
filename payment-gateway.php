<?php
?>
    <div class="row col-lg-6 mx-auto text-center my-3  mx-auto">

        <div class=" card card-body shadow p-4">
            <h4>درگاه پرداخت اینترنتی</h4>
            <hr>

            <form class="row g-3 pt-4">
                <!-- Card number -->
                <div class="col-12 row mb-4">
                    <label class="col-sm-4 col-form-label text-start ps-4">شماره کارت <span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" placeholder="xxxx xxxx xxxx xxxx">
                    </div>
                </div>
                <div class="col-12 row mb-4">
                    <label class="col-sm-4 col-form-label text-start ps-4">شماره شناسایی دوم (CVV2) <span class="text-danger">*</span></label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-sm-1 p-2">
                        <i class="bi bi-grid-3x3-gap text-secondary h4"></i>
                    </div>
                </div>
                <div class="col-12 row mb-4">
                    <label class="col-sm-4 col-form-label text-start ps-4">تاریخ انقضای کارت<span class="text-danger">*</span></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="ماه">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="سال">
                    </div>
                </div>
                <div class="col-12 row mb-4">
                    <label class="col-sm-4 col-form-label text-start ps-4">کد امنیتی<span class="text-danger">*</span></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-sm-4 ">
                        <h4 class="text-decoration-line-through ">123456</h4>
                    </div>
                    <div class="col-sm-1 p-2">
                        <i class="bi bi-arrow-clockwise text-secondary h4"></i>
                    </div>
                </div>
                <div class="col-12 row mb-4">
                    <label class="col-sm-4 col-form-label text-start ps-4">رمز دوم کارت<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-sm-3">
                        <a href="#" class="btn btn-info">دریافت رمز پویا</a>
                    </div>
                    <div class="col-sm-1 p-2">
                        <i class="bi bi-grid-3x3-gap text-secondary h4"></i>
                    </div>
                </div>
                <div class="col-12 row mb-4">
                    <label class="col-sm-4 col-form-label text-start ps-4">ایمیل<span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="col-12 row ">
                    <label class="col-sm-4 col-form-label "></label>
                    <div class="col-sm-8 row">
                        <div class="col-sm-8">
                            <a href="#" class="btn btn-totalprimary col-12">پرداخت</a>
                        </div>
                        <div class="col-sm-4">
                            <a href="#" class="btn btn-totalsecondary col-12">انصراف</a>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-12 row my-2">
                    <label class="col-sm-4 col-form-label ">مبلغ قابل پرداخت:</label>
                    <div class="col-sm-8 row">
                       <h4 class="text-success"><?php echo $_POST['total_price']; ?></h4>
                    </div>
                </div>

            </form>

        </div>
    </div>
<?php
require_once 'includes/footer.php';
?>
