<?php

require  $_SERVER['DOCUMENT_ROOT'] . '/models/Category.php';
require  $_SERVER['DOCUMENT_ROOT'] . '/models/Good.php';
require  $_SERVER['DOCUMENT_ROOT'] . '/models/GoodCategory.php';

$errmsg = "Не удалось выполнить обновление, проверьте корректность входных данных";
$succmsg = "Товар успешно обновлен!";

if(isset($_POST['saveProduct']))
{
    $productId = $_POST['productId'];
    $newProductName = $_POST['newProductName'];
    $newProductShortDescr = $_POST['newProductShortDescr'];
    $newProductFullDescr = $_POST['newProductFullDescr'];
    $newProductActiveFlag = $_POST['newProductActiveFlag'];
    $newProductAmount = $_POST['newProductAmount'];
    $newProductOrder = $_POST['newProductOrder'];
    $newCategories = $_POST['checkCategories'];

    $result = updateProduct($productId,$newProductName,$newProductShortDescr,$newProductFullDescr,$newProductActiveFlag,$newProductAmount,$newProductOrder,$newCategories);

    if($result == true)
    {
        header('Location: http://catalog-site.ru/admin/changeproduct.php?id=' . $_POST['productId'] . "&succ");
    }
    else{
        header('Location: http://catalog-site.ru/admin/changeproduct.php?id=' . $_POST['productId'] . "&err");
    }

}
else
{
    if (isset($_GET['id']) && $_GET['id'] >= 1 && is_numeric($_GET['id'])) {
        $currentProductId = $_GET['id'];
    } else {
        header('Location: http://catalog-site.ru/views/404.php');
        exit;
    }  

    $currentProduct = findProduct($currentProductId);
    $categories = getAllCategoryObj();
    $currentProductCategories = findProductCategory($currentProductId);
}


?>