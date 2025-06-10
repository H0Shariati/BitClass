<?php
defined('site') or die('ACCESS DENIED!');
require_once 'modules/admin/includes/header-sidebar.php';
if(isset($_POST['edit'])){
    $errors=[];
    if(mb_strlen($_POST['title'])<3) {
        $errors['title']='مقدار عنوان نباید کمتر از 3 کاراکتر باشد';
    }
    if(!isset($_POST['status']) || !in_array($_POST['status'],['0','1'])) {
        $errors['status']='مقدار فیلد وضعیت نامعتبر می باشد';
    }
    if(count($errors)==0){

        $link->query("UPDATE menu SET menu_title='".$link->real_escape_string($_POST['title'])."', submenu='".(int)$_POST['submenu']."', sort='".(int)$_POST['sort']."', status='".(int)$_POST['status']."' WHERE id=".$_GET['id']);

        if($link->errno==0 ){
            $message = '<script>toastr.success("ویرایش با موفقیت انجام شد");</script>';
            echo '<script>window.location="index.php?page=admin&section=menu";</script>';
        }
        else{
            $message = '<script>toastr.error("خطا در ویرایش اطلاعات");</script>';
        }
    }

}
$rowresult=$link->query("select * from menu where id=".$_GET['id']);
if($rowresult->num_rows>0){
    $rowupdate=$rowresult->fetch_assoc();

}

else{
    $message='<div class="alert alert-success">عملیات با خطا مواجع شد</div>';

}
?>

<div class="page-content-wrapper border">

    <!-- Title -->
    <div class="row">
        <div class="col-12 mb-3">
            <h1 class="h3 mb-2 mb-sm-0 fs-5">ایجاد منو جدید</h1>
        </div>
    </div>

    <div class=" row g-4 mb-4 my-1">
        <div class="col-xxl-8">
            <div class="card shadow mb-2">



                <!-- Card body -->
                <div class="card-body">
                    <?php
                    if(isset($message)){
                        echo $message;
                    }
                    ?>
                    <form method="post">

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">عنوان منو</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="title" value="<?php if(isset($rowupdate)) echo $rowupdate['menu_title'];?>">
                                <?php
                                if(isset($errors['title'])){
                                    echo '<div class="alert alert-danger">'.$errors['title'].'</div>';
                                }
                                ?>
                            </div>
                        </div><br>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">سر منو</label>
                            <div class="col-sm-10">
                                <select class="form-select"  name="submenu">
                                    <option value="0">بدون سر منو</option>
                                    <?php
                                    $resultmenu=$link->query("select * from menu");
                                    while($rowmenu=$resultmenu->fetch_assoc()){
                                        echo '<option';
                                        if(isset($rowupdate)){
                                            if($rowmenu['id']==$rowupdate['submenu']){
                                                echo ' selected ';
                                            }
                                        }
                                        echo ' value="'.$rowmenu['id'].'">'.$rowmenu['menu_title'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div><br>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">اولویت بندی</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="sort" value="<?php if(isset($rowupdate)) echo $rowupdate['sort'];?>">
                            </div>
                        </div><br>
                        <div class="mb-3 ">
                            <label class="col-sm-2 col-form-label">وضعیت منو</label>

                            <div class="form-check form-check-inline">
                                <input type="radio" name="status" value="1" id="st1" <?php if(isset($rowupdate) && $rowupdate['status']==1) echo ' checked ' ?> >
                                <label class="form-check-label" for="st1">فعال</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="status" value="0" id="st0" <?php if(isset($rowupdate) && $rowupdate['status']==0) echo ' checked ' ?>>
                                <label class="form-check-label" for="st0">غیرفعال</label>
                            </div>
                            <?php
                            if(isset($errors['status'])){
                                echo '<div class="alert alert-danger">'.$errors['status'].'</div>';
                            }
                            ?>
                        </div>


                        <div class="col-12 text-end">
                            <input type="submit" name="edit" value="ویرایش" class="btn btn-success ">
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once 'modules/admin/includes/footer.php';
?>