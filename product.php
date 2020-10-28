<?php

require './controllers/categoryController.php';
require './controllers/goodsController.php';
require './controllers/goods_categoryController.php';

if(isset($_GET['id']) && $_GET['id'] >= 1 && $_GET['id']  && is_numeric($_GET['id']))
{
    $productId = $_GET['id'];
}
else{header('Location: http://catalog-site.ru/404.php');exit;}

$product = findProduct($productId = $_GET['id']);

if($product == false || $product['flag_active'] == 0){header('Location: http://catalog-site.ru/404.php');exit;}

$productcategories = findProductCategory($productId);

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

    <div class="b-product">
        <div class="product__wrapper">
            <div class="product__title">
                <?php echo $product['goodName'] ?>
            </div>
            <div class="product__img">
                <img src="img/default-good.png" alt="Фото товара">
            </div>
            <div class="product__fulldescr">
                <p>Полное описание товара</p>
                <?php echo $product['goodFullDescr'] ?>
            </div>
            <div class="product__counts">
                <p>Кол-во товара на складе</p>
                <?php echo $product['goodAmount'] ?>
            </div>
            <div class="product__order">
                <p>Возможность заказать в случае отсутсвия</p>
                <?php if($product['flag_order'] == 1){echo "Есть";}else{echo "Нет";}?>
            </div>
            <div class="product__categories">
               <p>Все категории в которых есть товар</p>
               <?php 
                    foreach($productcategories as $category)
                    {
                    ?>
                    <a href="http://catalog-site.ru/about.php?category=<?php echo $category['categoryId'];?>&page=1"><?php echo $category['categoryName'];?></a>
                    <?php
                    }
                    ?>
                <a href="http://catalog-site.ru/about.php?category=2&page=1" class="nav__link nav__link--product">Назад</a>
            </div>
        </div>
    </div>

</body>

</html>


