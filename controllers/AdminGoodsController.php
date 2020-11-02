<?php

require  $_SERVER['DOCUMENT_ROOT'] . '/models/Category.php';
require  $_SERVER['DOCUMENT_ROOT'] . '/models/Good.php';

$itemsOnPage = 3;
$categoryPagesCount = findActiveCategoryCountAdmin();

if ($categoryPagesCount <= 0) { header('Location: http://catalog-site.ru/views/404.php');exit;}

if (isset($_GET['category']) && $_GET['category'] >= 1 && $_GET['category'] <= $categoryPagesCount && is_numeric($_GET['category'])
&& isset($_GET['page']) && $_GET['page'] >= 1 && $_GET['page'] <= getGoodsCountPages($itemsOnPage,$_GET['category']) 
&& is_numeric($_GET['page']))
{
    $categoryPage= $_GET['category'];
    $goodsPage = $_GET['page'];
} 
else {
    if (isset($_POST['goodAdd'])) { 
        $categoryId = $_POST['categoryId'];
        $goodName = $_POST['goodName'];
        $goodShortDescr = $_POST['goodShortDescr'];
        $goodFullDescr = $_POST['goodFullDescr'];
        $goodFlagActive = $_POST['goodActiveFlag'];
        $goodAmount = $_POST['goodAmount'];
        $goodCanOrder = $_POST['goodOrder'];
        $goodCategories = $_POST['checkCategories'];
        
        $result = addNewGood($categoryId,$goodName,$goodShortDescr,$goodFullDescr,$goodFlagActive,$goodAmount,$goodCanOrder,$goodCategories);

        if($result == true)
        {
            header('Location: http://catalog-site.ru/admin/changegoods.php?category=' . $_POST['categoryId'] . "&page=1" . "&succ");
        }
        else{
            header('Location: http://catalog-site.ru/admin/changegoods.php?category=' . $_POST['categoryId'] . "&page=1" . "&err");
        }

    } 
    else
    {
        header('Location: http://catalog-site.ru/views/404.php');
        exit;
    }
}

$from = ($goodsPage - 1) * $itemsOnPage;
$goods = findGoodsOnCategoryAdmin($from,$itemsOnPage, $_GET['category']);

$categoryName = findCategoryName($categoryPage);
$categoryFullDescr = findCategoryFullDescr($categoryPage);

$errmsg = "Не удалось выполнить добавление, проверьте корректность входных данных";
$succmsg = "Товар успешно добавлен!";

$categories = getAllCategoryObj();

?>