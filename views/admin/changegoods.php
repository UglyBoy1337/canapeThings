<?php

include $_SERVER['DOCUMENT_ROOT'] . '/admin.php';

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
            <div class="main__title">
                Вы находитесь в категории товаров:<?php echo $adminGoodController->categoryName ?>
            </div>
            <div class="main__subtitle">
                <span>Полное описание категории:</span> <?php echo $adminGoodController->categoryFullDescr?>
            </div>
            <?php foreach ($adminGoodController->goods as $good)
                { 
                ?>
                <div class="b-item">
                    <div class="item__img">
                        <img src="../../img/default-good.png" alt="default photo">
                    </div>
                    <div class="item__title">
                    <?php echo $good['goodName']?>
                    </div>
                    <div class="item__shortdescr">
                    <?php echo $good['goodShortDescr']?>
                    </div>
                    <div class="item__about">
                        <a href="admin.php?id=<?php echo $good['goodId']?>">Редактировать товар</a>
                    </div>
                </div>
            <?php
            } 
            if($adminGoodController->pagesCategoryCount > 1)
            {
            ?>
                 <form action="index.php" method="GET">
                     <?php if($adminGoodController->currentPage > 1) 
                     { ?>
                    <a href="?category=<?php echo $_GET['category']?>&page=<?php echo $adminGoodController->currentPage -1 ;?>" class="main__link main__link--left">&#9668PrevPage</a>
                     <?php 
                     } ?>
                     <?php if($adminGoodController->currentPage < $adminGoodController->pagesCategoryCount)
                     { ?>
                    <a href="?category=<?php echo $_GET['category']?>&page=<?php echo $adminGoodController->currentPage+1;?>" class="main__link main__link--right">NextPage&#9658</a>
                     <?php 
                     } ?>
                </form>
            <?php
            }
            ?>
        </div>

        <div class="b-new-goods">
            <div class="new-goods__wrapper">
                <div class="new-goods__title">
                    Форма добавления нового товара
                </div>
                <form action="admin.php" method="POST">
                <textarea class="hidden" name="categoryId" rows="1"><?php echo $_GET['category'] ?></textarea>
                    <div class="new-goods__subtitle">Имя товара:</div>
                    <input type="text" required placeholder="Введите имя товара" name="goodName">
                    <div class="new-goods__subtitle">Краткое описание товара:</div>
                    <input type="text" required placeholder="Краткое описание товара" name="goodShortDescr">
                    <div class="new-goods__subtitle">Полное описание товара:</div>
                    <input type="text" required placeholder="Полное описание товара" name="goodFullDescr">
                    <div class="new-goods__subtitle">Кол-во товара:</div>
                    <input type="number" required placeholder="Кол-во товара на складе" name="goodAmount">
                    <div class="new-goods__subtitle">Активность товара:</div>
                    <select name="goodActiveFlag">
                        <option value="1">Активен</option>
                        <option value="0">Не активен</option>
                    </select>
                    <div class="new-goods__subtitle">Возможность заказать в случае отсутствия:</div>
                    <select name="goodOrder">
                        <option value="1">Есть</option>
                        <option value="0">Нет</option>
                    </select>
                    <div class="new-goods__subtitle">Категории товара:</div>
                    <?php foreach($adminGoodController->categories as $category)
                    {
                    ?>
                    <div class="new-goods__attr">
                        <input type="checkbox" id="<?php echo $category['categoryId'] ?>" name="checkCategories[]" value="<?php echo $category['categoryId'] ?>">
                        <label for="<?php echo $category['categoryId'] ?>"><?php echo $category['categoryName']?></label>
                    </div>
                    <?php } ?>
                    <button type="submit" name="goodAdd">Добавить товар</button>
                    <div class="new-goods__errmsg">
                    <?php echo $adminGoodController->goodCreateMsg?>
                    </div>
                </form>
            </div>
        </div>

        <a href="/admin.php" class="nav__link">Назад</a>
    </div>

</body>

</html>