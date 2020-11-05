<?php

    require  $_SERVER['DOCUMENT_ROOT'] . '/controllers/AdminCategoryController.php';

    $adminController = new AdminCategoryController;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" href="../../css/default.css">
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
            <?php foreach ($adminController->categories as $category) 
            { ?>
                <div class="b-item">
                    <div class="item__img">
                        <img src="../../img/default-good.png" alt="default photo">
                    </div>
                    <div class="item__title">
                        <?php echo $category['categoryName'] ?>
                    </div>
                    <div class="item__shortdescr">
                        <?php echo $category['categoryShortDescr'] ?>
                    </div>
                    <?php if($category['isExists'] == 1)
                    {
                    ?>
                    <div class="item__about">
                        <a href="http://catalog-site.ru/views/admin/changegoods.php?change&category=<?php echo $category['categoryId'] . "&page=1" ?>">Добавить товары</a>
                    </div>
                    <?php 
                    } 
                    ?>
                    <div class="item__about">
                        <a href="http://catalog-site.ru/views/admin/changecategory.php?change&category=<?php echo $category['categoryId']?>">Редактировать</a>
                    </div>
                </div>
            <?php
            }
            if ($adminController->pagesCategoryCount > 1)
            {
            ?>
                <form action="index.php" method="GET">
                    <?php if ($adminController->currentPage > 1) { ?>
                        <a href="?categoryPage=<?php echo $adminController->currentPage - 1; ?>" class="main__link main__link--left">&#9668PrevPage</a>
                    <?php
                    } ?>
                    <?php if ($adminController->currentPage < $adminController->pagesCategoryCount) { ?>
                        <a href="?categoryPage=<?php echo $adminController->currentPage + 1; ?>" class="main__link main__link--right">NextPage&#9658</a>
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
                        <?php echo $adminController->categoryCreateMsg ?>
                    </div>
                </form>
            </div>
        </div>

    </div>
</body>

</html>