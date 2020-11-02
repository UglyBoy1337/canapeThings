<?php 
    require  $_SERVER['DOCUMENT_ROOT'] . '/models/Good.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/models/Category.php';

    $itemsOnPage = 3;
    $categoryPagesCount = findActiveCategoryCount();

    if ($categoryPagesCount <= 0) {header('Location: http://catalog-site.ru/views/404.php');exit;}

        if (isset($_GET['category']) && $_GET['category'] >= 1 && $_GET['category'] <= $categoryPagesCount+1 && is_numeric($_GET['category']) 
        && isset($_GET['page']) && $_GET['page'] >= 1 && $_GET['page'] <= getGoodsCountPages($itemsOnPage,$_GET['category']) 
        && is_numeric($_GET['page']))
        {
            $categoryPage= $_GET['category'];
            $goodsPage = $_GET['page'];
            
        } else {header('Location: http://catalog-site.ru/views/404.php');exit;
    }

    $from = ($goodsPage - 1) * $itemsOnPage;
    $goods = findGoodsOnCategory($from,$itemsOnPage, $_GET['category']);

    $categoryName = findCategoryName($categoryPage);
    $categoryFullDescr = findCategoryFullDescr($categoryPage);
?>