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
                    <div class="item__img" data-id="<?php echo $good['goodId'] ?>">
                        <img src="../img/default-good.png" alt="default photo">
                    </div>
                    <div class="item__title">
                    <?php echo $good['goodName']?>
                    </div>
                    <div class="item__shortdescr">
                    <?php echo $good['goodShortDescr']?>
                    </div>
                    <div class="item__about">
                        <a href="?id=<?php echo $good['goodId']?>">Подробнее о товаре</a>
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
        <a href="/index.php" class="nav__link">Назад</a>
    </div>

    <div class="b-modalProduct">
        <div class="modalProduct__layout">
            <div class="modalProduct__title">Товар:</div>
            <div class="modalProduct__description">Полное описание:</div>
            <div class="modalProduct__categories">Категории:</div>
            <div class="modalProduct__isOrder">Возможность заказать в случае отстуствия:</div>
            <div class="modalProduct__count">Кол-во:</div>
            <svg class="modal__cross" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M23.954 21.03l-9.184-9.095 9.092-9.174-2.832-2.807-9.09 9.179-9.176-9.088-2.81 2.81 9.186 9.105-9.095 9.184 2.81 2.81 9.112-9.192 9.18 9.1z"/></svg>
        </div>
    </div>

    <div class="overlay" id="overlay-modal"></div>

    <script src="../js/libs/jquery.js"></script>
    <script src="../js/showProduct.js"></script>
</body>

</html>