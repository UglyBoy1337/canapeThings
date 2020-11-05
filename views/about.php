<?php

require  $_SERVER['DOCUMENT_ROOT'] . '/controllers/GoodsController.php';

$goodController = new GoodsController;

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
            <div class="main__title">
                Вы находитесь в категории товаров:<?php echo $goodController->categoryName ?>
            </div>
            <div class="main__subtitle">
                <span>Полное описание категории:</span> <?php echo $goodController->categoryFullDescr?>
            </div>
            <?php foreach ($goodController->goods as $good)
            { ?>
                <div class="b-item">
                    <div class="item__img">
                        <img src="../img/default-good.png" alt="default photo">
                    </div>
                    <div class="item__title">
                    <?php echo $good['goodName']?>
                    </div>
                    <div class="item__shortdescr">
                    <?php echo $good['goodShortDescr']?>
                    </div>
                    <div class="item__about">
                        <a href="product.php?id=<?php echo $good['goodId']?>">Подробнее о товаре</a>
                    </div>
                </div>
            <?php 
            } 
            if($goodController->goodCountPages > 1){
            ?>
                 <form action="index.php" method="GET">
                     <?php if($goodController->currentPage > 1) 
                     { ?>
                    <a href="?category=<?php echo $_GET['category']?>&page=<?php echo $goodController->currentPage-1;?>" class="main__link main__link--left">&#9668PrevPage</a>
                     <?php 
                     } ?>
                     <?php if($goodController->currentPage < $goodController->goodCountPages)
                     { ?>
                    <a href="?category=<?php echo $_GET['category']?>&page=<?php echo $goodController->currentPage+1;?>" class="main__link main__link--right">NextPage&#9658</a>
                     <?php 
                     } ?>
                </form>
            <?php
            }?>
        </div>
        <a href="http://catalog-site.ru/views/index.php" class="nav__link">Назад</a>
    </div>

</body>

</html>