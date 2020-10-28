<?php

require '../controllers/categoryController.php';
require '../controllers/goodsController.php';
require '../controllers/goods_categoryController.php';

$itemsOnPage = 3;
$pagesCategoryCount = getCategoryCountPagesAdmin($itemsOnPage);
$page = 1;

if ($pagesCategoryCount <= 0) {header('Location: http://catalog-site.ru/?categoryPage=1');exit;}

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
            header('Location: http://catalog-site.ru/404.php');
        }
    }
}

$from = ($page - 1) * $itemsOnPage;
$categories = findCategoryPaginationPagesAdmin($from, $itemsOnPage);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/default.css">
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

    <div class="b-main">
        <div class="main__wrapper">
            <?php foreach ($categories as $category) 
            { ?>
                <div class="b-item">
                    <div class="item__img">
                        <img src="../img/default-good.png" alt="default photo">
                    </div>
                    <div class="item__title">
                        <?php echo $category['categoryName'] ?>
                    </div>
                    <div class="item__shortdescr">
                        <?php echo $category['categoryShortDescr'] ?>
                    </div>
                    <?php if(findGoodsOnCategoryAdminExists($category['categoryId']))
                    {
                    ?>
                    <div class="item__about">
                        <a href="http://catalog-site.ru/admin/changegoods.php?category=<?php echo $category['categoryId'] . "&page=1" ?>">Добавить товары</a>
                    </div>
                    <?php 
                    } 
                    ?>
                    <div class="item__about">
                        <a href="http://catalog-site.ru/admin/changecategory.php?category=<?php echo $category['categoryId']?>">Редактировать</a>
                    </div>
                </div>
            <?php
            }
            if ($pagesCategoryCount > 1)
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

        <div class="b-new-category">
            <div class="new-category__wrapper">
                <div class="new-category__title">
                    Форма добавления новой категории
                </div>
                <form action="index.php" method="POST">
                    <div class="new-category__subtitle">Имя категории:</div>
                    <input type="text" required placeholder="Введите имя категории" name="categoryName">
                    <div class="new-category__subtitle">Краткое описание категории:</div>
                    <input type="text" required placeholder="Краткое описание категории" name="categoryShortDescr">
                    <div class="new-category__subtitle">Полное описание категории:</div>
                    <input type="text" required placeholder="Полное описание категории" name="categoryFullDescr">
                    <div class="new-category__subtitle">Активность категории:</div>
                    <select name="categoryFlagActive">
                        <option value="1">Активна</option>
                        <option value="0">Не активна</option>
                    </select>
                    <button type="submit" name="category__addCategory">Добавить категорию</button>
                    <div class="new-category__errmsg">
                        <?php if($createCategoryResult == null || false){echo $errmsg;}else{echo $succmsg;} ?>
                    </div>
                </form>
            </div>
        </div>

    </div>
</body>

</html>