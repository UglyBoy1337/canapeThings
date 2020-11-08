<?php

    include $_SERVER['DOCUMENT_ROOT'] . '/index.php';

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

    <div class="b-sort">
        <div class="sort__wrapper">
            <form action="index.php" method="POST">
                <select name="orderBy">
                    <option value="a-z">Сортировка A-Z</option>
                    <option value="z-a">Сортировка Z-A</option>
                </select>
               <button type="submit" name="sortBy">Отсортировать</button>
               <button type="submit" name="sortDefault" value="true">Убрать сортировку</button>
            </form>
        </div>
    </div>

    <div class="b-main">
        <div class="main__wrapper">
            <?php foreach ($CategoryConroller->categories as $category) 
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
                    <div class="item__about">
                        <a href="?category=<?php echo $category['categoryId'] . "&page=1" ?>">Подробнее</a>
                    </div>
                </div>
            <?php
            }
            if ($CategoryConroller->pagesCategoryCount > 1 && !isset($_POST['sortBy'])) 
            {
            ?>
                <form action="index.php" method="GET">
                    <?php if ($CategoryConroller->currentPage > 1) { ?>
                        <a href="?categoryPage=<?php echo $CategoryConroller->currentPage - 1; ?>" class="main__link main__link--left">&#9668PrevPage</a>
                    <?php
                    } ?>
                    <?php if ($CategoryConroller->currentPage < $CategoryConroller->pagesCategoryCount) { ?>
                        <a href="?categoryPage=<?php echo $CategoryConroller->currentPage + 1; ?>" class="main__link main__link--right">NextPage&#9658</a>
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
            <?php if($CategoryConroller->productinfo != null && $CategoryConroller->productinfo['flag_active'] == 1)
            {
            ?>
            <div class="search__output-wrapper">
                <div class="search__output-id">
                    Номер товара (id) : <?php echo $CategoryConroller->productinfo['goodId']; ?>
                </div>
                <div class="search__output-name">
                    Имя товара: <?php echo $CategoryConroller->productinfo['goodName'] ?>
                </div>
                <div class="search__output-short-descr">
                    Краткое описание: <?php echo $CategoryConroller->productinfo['goodShortDescr'] ?>
                </div>
                <div class="search__output-full-descr">
                    Полное описание: <?php echo $CategoryConroller->productinfo['goodFullDescr'] ?>
                </div>
                <div class="search__output-amount">
                    Колличество на складе: <?php echo $CategoryConroller->productinfo['goodAmount'] ?>
                </div>
                <div class="search__output-order">
                    Возможно заказа со склада: <?php if($CategoryConroller->productinfo['flag_order'] == 1){echo "Есть";}else{echo "Нет";}?>
                </div>
            </div>
            <?php
            }
            else
            {
            ?>
            <div class="search__output-error">
                <?php echo $CategoryConroller->errmsg;?>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>