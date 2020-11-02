<?php

require  $_SERVER['DOCUMENT_ROOT'] . '/models/Category.php';
require  $_SERVER['DOCUMENT_ROOT'] . '/models/Good.php';

$itemsOnPage = 3;
$pagesCategoryCount = getCategoryCountPagesAdmin($itemsOnPage);
$page = 1;

if ($pagesCategoryCount <= 0) {header('Location: http://catalog-site.ru/admin/index?categoryPage=1');exit;}

if (isset($_GET['categoryPage']) && $_GET['categoryPage'] >= 1 && $_GET['categoryPage'] <= $pagesCategoryCount && is_numeric($_GET['categoryPage'])) {
    $page = $_GET['categoryPage'];
} else {
    if (isset($_POST['category__addCategory'])) { 

        $categoryName = $_POST['categoryName'];
        $categoryShortDescr = $_POST['categoryShortDescr'];
        $categoryFullDescr = $_POST['categoryFullDescr'];
        $flag_active = $_POST['categoryFlagActive'];
        $errmsg = "Не удалось выполнить добавление, проверьте корректность входных данных";
        $succmsg = "Категория успешно добавлена!";
        
        $createCategoryResult = createNewCategory($categoryName,$categoryShortDescr,$categoryFullDescr,$flag_active);
    } 
    else {
        if (isset($_GET['categoryPage'])) {
            header('Location: http://catalog-site.ru/views/404.php');
        }
    }
}

 $from = ($page - 1) * $itemsOnPage;
 $categories = findCategoryPaginationPagesAdmin($from, $itemsOnPage);

if(isset($_GET['change']) || isset($_POST['saveCategory'])){
    $categoryCount = findCategoryCount();
$errmsg = "Не удалось выполнить обновление, проверьте корректность входных данных";
$succmsg = "Категория успешно обновлена!";

if(isset($_POST['saveCategory']))
{
    $newCategoryName = $_POST['newCategoryName'];
    $newCategoryShortDescr = $_POST['newCategoryShortDescr'];
    $newCategoryFullDecr = $_POST['newCategoryFullDescr'];
    $newCategoryFlagActive = $_POST['newCategoryFlagActive'];
    $categoryId = $_POST['categoryId'];

    $result = updateCategory($categoryId,$newCategoryName,$newCategoryShortDescr,$newCategoryFullDecr,$newCategoryFlagActive);

    if($result == true)
    {
        header('Location: http://catalog-site.ru/admin/changecategory.php?change&category=' . $_POST['categoryId'] . "&succ");
    }
    else{
        header('Location: http://catalog-site.ru/admin/changecategory.php?change&category=' . $_POST['categoryId'] . "&err");
    }

}
else
{
    if (isset($_GET['category']) && $_GET['category'] >= 1 && $_GET['category']  && is_numeric($_GET['category']) && $_GET['category'] <= $categoryCount) {
        $currentCategory = $_GET['category'];
    } else {
        header('Location: http://catalog-site.ru/views/404.php');
        exit;
    }  

    $categoryObj = findCategory($currentCategory);
}
}

?>