<?php 

    require  $_SERVER['DOCUMENT_ROOT'] . '/models/Good.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/models/Category.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/models/GoodCategory.php';
    
    if(isset($_GET['id']) && $_GET['id'] >= 1 && $_GET['id']  && is_numeric($_GET['id']))
    {
        $productId = $_GET['id'];
    }
    else{header('Location: http://catalog-site.ru/views/404.php');exit;}

    $product = findProduct($productId = $_GET['id']);

    if($product == false || $product['flag_active'] == 0){header('Location: http://catalog-site.ru/views/404.php');exit;}

    $productcategories = findProductCategory($productId);

?>
