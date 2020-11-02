<?php 
    
    require  $_SERVER['DOCUMENT_ROOT'] . '/models/Category.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/models/Good.php';

    /* config */ 
    $itemsOnPage = 3;
    $pagesCategoryCount = getCategoryCountPages($itemsOnPage);
    $page = 1;

    if ($pagesCategoryCount <= 0) {header('Location: http://catalog-site.ru/views/index?categoryPage=1');exit;}

    if (isset($_GET['categoryPage']) && $_GET['categoryPage'] >= 1 && $_GET['categoryPage'] <= $pagesCategoryCount && is_numeric($_GET['categoryPage'])) {
        $page = $_GET['categoryPage'];
        $itemsOnPage = 3;
        $from = ($page - 1) * $itemsOnPage;
        $categories = findCategoryPaginationPages($from, $itemsOnPage);
    } else {
        if (isset($_POST['search_product'])) {
            $id = $_POST['search_id'];
            $errmsg = "Данного товара не существует";
                if(is_numeric($id))
                {
                    $productinfo = findProduct($id);
                    $itemsOnPage = 3;
                    $from = ($page - 1) * $itemsOnPage;
                    $categories = findCategoryPaginationPages($from, $itemsOnPage);
                }
        } else {
            if(isset($_POST['sortBy']))
            {
                $itemsOnPage = 10;
                $from = ($page - 1) * $itemsOnPage;
        
                    if($_POST['orderBy'] == "a-z")
                    {
                        $categories = findCategoryPaginationPageOrder($from,$itemsOnPage,"a-z");
                    }
                    else
                    {
                        $categories = findCategoryPaginationPageOrder($from,$itemsOnPage,"z-a");
                    }
        
                }
            if(isset($_GET['categoryPage'])) {
                header('Location: http://catalog-site.ru/views/404.php');
            }
                if(isset($_POST['default']))
                {
                    $itemsOnPage = 3;
                    $from = ($page - 1) * $itemsOnPage;
                    $categories = findCategoryPaginationPages($from, $itemsOnPage);
                }
                if(!isset($_POST['sortBy']) && !isset($_POST['default']))
                {
                    $itemsOnPage = 3;
                    $from = ($page - 1) * $itemsOnPage;
                    $categories = findCategoryPaginationPages($from, $itemsOnPage);
                }
            }
        }


?>