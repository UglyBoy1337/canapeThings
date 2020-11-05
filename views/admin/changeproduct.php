<?php

require  $_SERVER['DOCUMENT_ROOT'] . '/controllers/AdminProductController.php';

$adminProductController = new AdminProductController;

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

    <div class="b-change">
        <div class="change__wrapper">
            <div class="change__title">
                Вы редактируете товар:<?php echo $adminProductController->currentProduct['goodName'] ?>
            </div>
            <form action="changeproduct.php" method="POST">
            <textarea class="hidden" name="productId" rows="1"><?php echo $adminProductController->currentProduct['goodId']?></textarea>
                <div class="change__field-name">
                    Изменить название товара
                </div>
                <textarea name="newProductName" cols="30" rows="1" required><?php echo $adminProductController->currentProduct['goodName']?></textarea>
                <div class="change__field-name">
                    Изменить краткое описание товара
                </div>
                <textarea name="newProductShortDescr" cols="30" rows="5" required><?php echo $adminProductController->currentProduct['goodShortDescr']?></textarea>
                <div class="change__field-name">
                    Изменить полное описание товара
                </div>
                <textarea name="newProductFullDescr" cols="30" rows="5" required><?php echo $adminProductController->currentProduct['goodFullDescr']?></textarea>
                <div class="change__field-name">
                    Изменить активность товара
                </div>
                <select name="newProductActiveFlag">
                 <?php 
                 if($adminProductController->currentProduct['flag_active'] == 1)
                 {
                 ?>
                 <option value="1">Активна</option>
                 <option value="0">Не активна</option>
                 <?php }else
                 {
                 ?>  
                <option value="0">Не активна</option>
                <option value="1">Активна</option>
                <?php
                }
                ?>
                </select>
                <div class="change__field-name">
                    Изменить кол-во товара
                </div>
                <input type="number" value="<?php echo $adminProductController->currentProduct['goodAmount'] ?>" required placeholder="<?php echo $adminProductController->currentProduct['goodAmount']; ?>" name="newProductAmount">
                <div class="change__field-name">
                    Возможность заказать в случае отстуствия
                </div>
                <select name="newProductOrder">
                 <?php 
                 if($adminProductController->currentProduct['flag_order'] == 1)
                 {
                 ?>
                 <option value="1">Можно</option>
                 <option value="0">Нельзя</option>
                 <?php }else
                 {
                 ?>  
                <option value="0">Нельзя</option>
                <option value="1">Можно</option>
                <?php
                }
                ?>
                </select>
                <div class="change__title">Категории товара:</div>
                <?php foreach($adminProductController->categories as $category)
                    {
                        $isExists = false;
                        foreach($adminProductController->currentProductCategories as $currentcategory)
                        {
                           if($category['categoryName'] == $currentcategory['categoryName'])
                           {
                               $isExists = true;
                            ?>
                        <div class="new-goods__attr">
                        <input type="checkbox" checked id="<?php echo $category['categoryId'] ?>" name="checkCategories[]" value="<?php echo $category['categoryId'] ?>">
                        <label for="<?php echo $category['categoryId'] ?>"><?php echo $category['categoryName']?></label>
                        </div>
                        <?php 
                           }
                        }
                        if($isExists != true){
                        ?>
                        <div class="new-goods__attr">
                        <input type="checkbox" id="<?php echo $category['categoryId'] ?>" name="checkCategories[]" value="<?php echo $category['categoryId'] ?>">
                        <label for="<?php echo $category['categoryId'] ?>"><?php echo $category['categoryName']?></label>
                        </div>
                        <?php
                        }
                      }
                    ?>
                <button type="submit" name="saveProduct">Сохранить изменения</button>
                <a href="http://catalog-site.ru/views/admin/index.php?categoryPage=1" class="nav__link nav__link--update-category">Назад</a>
            </form>
            <div class="change__errmsg">
                <?php echo $adminProductController->productSaveMessage ?>
            </div>
        </div>
     </div>
    </div>
</body>

</html>