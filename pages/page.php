<?php
defined('site') or die('ACCESS DENIED!');
require_once 'includes/header.php';
if(isset($_GET['id'])){
    switch (cleanId($_GET['id'])){
        case '83':
            require_once 'pages/blog.php';
            break;
        case '63':
            require_once 'pages/about_us.php';
            break;
        case '64':
            require_once 'pages/contact_us.php';
            break;
    }
}

$resultpage=$link->query("select * from pages where menu_id=".cleanId($_GET['id']));
if($resultpage->num_rows>0){
    $rowpage=$resultpage->fetch_assoc();
    $array = array(83,63,64);
    if(!in_array($rowpage['menu_id'],$array)){
    ?>

        <div class="container">
            <div class="row mb-4">
                <div class="bg-light p-4 text-center rounded-3 mb-4 ">
                    <h1 class="m-0 fs-2"><?php echo $rowpage['title']; ?></h1>
                </div>
                <div class="d-flex flex-row-reverse justify-content-center align-items-center ">
                    <img style="max-height:350px " class="col-6 rounded-3" src="files/pages/<?php echo $rowpage['image']; ?>">
                    <div class="col-6 pe-4 "><?php echo $rowpage['content']; ?></div>
                </div>
            </div>
        </div>


<?php
}
}
else{?>
    <div class="container">
        <div class="content d-flex justify-content-center align-items-center">
            <div class="me-9">
                <h3>صفحه در حال ساخت ...</h3>
            </div>
            <img src="assets/images/element/coming-soon.svg" class="w-800px">
        </div>
    </div>
<?php
}

require_once 'includes/footer.php';

?>