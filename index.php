<?php

require './controllers/categoryController.php';
require './controllers/goodsController.php';

$itemsOnPage = 3;
$pagesCategoryCount = getCategoryCountPages($itemsOnPage);
$page = 1;

if ($pagesCategoryCount <= 0) {header('Location: http://catalog-site.ru/?categoryPage=1');exit;}

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
            header('Location: http://catalog-site.ru/404.php');
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/default.css">
    <title>catalog-site</title>
</head>

<body>
    <div class="b-header">
        <div class="header__wrapper">
            <div class="header__title">
                CATALOG-SITE
            </div>
        </div>
    </div>

    <div class="b-sort">
        <div class="sort__wrapper">
            <form action="index.php" method="POST">
                <select name="orderBy">
                    <option value="a-z">Сортировка A-Z</option>
                    <option value="z-a">Сортировка Z-A</option>
                </select>
               <button type="submit" name="sortBy">Отсортировать</button>
               <button type="submit" name="default">Убрать сортировку</button>
            </form>
        </div>
    </div>

    <div class="b-main">
        <div class="main__wrapper">
            <?php foreach ($categories as $category) 
            { ?>
                <div class="b-item">
                    <div class="item__img">
                        <img src="img/default-good.png" alt="default photo">
                    </div>
                    <div class="item__title">
                        <?php echo $category['categoryName'] ?>
                    </div>
                    <div class="item__shortdescr">
                        <?php echo $category['categoryShortDescr'] ?>
                    </div>
                    <div class="item__about">
                        <a href="http://catalog-site.ru/about.php?category=<?php echo $category['categoryId'] . "&page=1" ?>">Подробнее</a>
                    </div>
                </div>
            <?php
            }
            if ($pagesCategoryCount > 1 && !isset($_POST['sortBy'])) 
            {
            ?>
                <form action="index.php" method="GET">
                    <?php if ($page > 1) { ?>
                        <a href="?categoryPage=<?php echo $page - 1; ?>" class="main__link main__link--left">&#9668PrevPage</a>
                    <?php
                    } ?>
                    <?php if ($page < $pagesCategoryCount) { ?>
                        <a href="?categoryPage=<?php echo $page + 1; ?>" class="main__link main__link--right">NextPage&#9658</a>
                    <?php
                    } ?>
                </form>
            <?php
            }
            ?>
        </div>
    </div>

    <div class="b-search">
        <div class="search__wrapper">
            <form action="index.php" method="POST">
                <div class="search__title">
                    Поиск информации о товаре по id
                </div>
                <div class="form__input-wrapper">
                    <div class="search__input-title">
                        Введите id товара:
                    </div>
                    <input type="number" name="search_id" required>
                    <button type="submit" name="search_product">Получить информацию</button>
                </div>
            </form>
            <?php if($productinfo != null && $productinfo['flag_active'] == 1)
            {
            ?>
            <div class="search__output-wrapper">
                <div class="search__output-id">
                    Номер товара (id) : <?php echo $productinfo['goodId'] ?>
                </div>
                <div class="search__output-name">
                    Имя товара: <?php echo $productinfo['goodName'] ?>
                </div>
                <div class="search__output-short-descr">
                    Краткое описание: <?php echo $productinfo['goodShortDescr'] ?>
                </div>
                <div class="search__output-full-descr">
                    Полное описание: <?php echo $productinfo['goodFullDescr'] ?>
                </div>
                <div class="search__output-amount">
                    Колличество на складе: <?php echo $productinfo['goodAmount'] ?>
                </div>
                <div class="search__output-order">
                    Возможно заказа со склада: <?php if($productinfo['flag_order'] == 1){echo "Есть";}else{echo "Нет";}?>
                </div>
            </div>
            <?php
            }
            else
            {
            ?>
            <div class="search__output-error">
             <?php echo $errmsg; ?>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>