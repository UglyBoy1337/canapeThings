<?php

require './controllers/categoryController.php';
require './controllers/goodsController.php';

$itemsOnPage = 3;
$categoryPagesCount = findActiveCategoryCount();

if ($categoryPagesCount <= 0) {header('Location: http://catalog-site.ru/404.php');exit;}

if (isset($_GET['category']) && $_GET['category'] >= 1 && $_GET['category'] <= $categoryPagesCount+1 && is_numeric($_GET['category']) 
&& isset($_GET['page']) && $_GET['page'] >= 1 && $_GET['page'] <= getGoodsCountPages($itemsOnPage,$_GET['category']) 
&& is_numeric($_GET['page']))
{

    $categoryPage= $_GET['category'];
    $goodsPage = $_GET['page'];
    
} else {
    header('Location: http://catalog-site.ru/404.php');
    exit;
}

$from = ($goodsPage - 1) * $itemsOnPage;
$goods = findGoodsOnCategory($from,$itemsOnPage, $_GET['category']);

$categoryName = findCategoryName($categoryPage);
$categoryFullDescr = findCategoryFullDescr($categoryPage);

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

    <div class="b-main">
        <div class="main__wrapper">
            <div class="main__title">
                Вы находитесь в категории товаров:<?php echo $categoryName ?>
            </div>
            <div class="main__subtitle">
                <span>Полное описание категории:</span> <?php echo $categoryFullDescr?>
            </div>
            <?php foreach ($goods as $good)
            { ?>
                <div class="b-item">
                    <div class="item__img">
                        <img src="img/default-good.png" alt="default photo">
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
            if(getGoodsCountPages($itemsOnPage,$_GET['category']) > 1){
            ?>
                 <form action="index.php" method="GET">
                     <?php if($goodsPage > 1) 
                     { ?>
                    <a href="?category=<?php echo $_GET['category']?>&page=<?php echo $goodsPage-1;?>" class="main__link main__link--left">&#9668PrevPage</a>
                     <?php 
                     } ?>
                     <?php if($goodsPage < getGoodsCountPages($itemsOnPage,$_GET['category']))
                     { ?>
                    <a href="?category=<?php echo $_GET['category']?>&page=<?php echo $goodsPage+1;?>" class="main__link main__link--right">NextPage&#9658</a>
                     <?php 
                     } ?>
                </form>
            <?php
            }?>
        </div>
        <a href="http://catalog-site.ru/index.php" class="nav__link">Назад</a>
    </div>

</body>

</html>