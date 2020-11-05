<?php

require  $_SERVER['DOCUMENT_ROOT'] . '/controllers/adminCategoryController.php';

$adminCategoryController = new AdminCategoryController;

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
                Вы редактируете категорию:<?php echo $adminCategoryController->currentCategory['categoryName'] ?>
            </div>
            <form action="changecategory.php" method="POST">
            <textarea class="hidden" name="categoryId" rows="1"><?php echo $adminCategoryController->currentCategory['categoryId']?></textarea>
                <div class="change__field-name">
                    Изменить название категории
                </div>
                <textarea name="newCategoryName" cols="30" rows="1" required><?php echo $adminCategoryController->currentCategory['categoryName']?></textarea>
                <div class="change__field-name">
                    Изменить краткое описание категории
                </div>
                <textarea name="newCategoryShortDescr" cols="30" rows="5" required><?php echo $adminCategoryController->currentCategory['categoryShortDescr']?></textarea>
                <div class="change__field-name">
                    Изменить полное описание категории
                </div>
                <textarea name="newCategoryFullDescr" cols="30" rows="5" required><?php echo $adminCategoryController->currentCategory['categoryFullDescr']?></textarea>
                <div class="change__field-name">
                    Изменить активность категории
                </div>
                <select name="newCategoryFlagActive">
                 <?php 
                 if($adminCategoryController->currentCategory['flag_active'] == 1)
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
                <button type="submit" name="saveCategory">Сохранить изменения</button>
                <a href="http://catalog-site.ru/views/admin/index.php?categoryPage=1" class="nav__link nav__link--update-category">Назад</a>
            </form>
            <div class="change__errmsg">
                <?php echo $adminCategoryController->changeCategoryMessage; ?>
            </div>
        </div>
     </div>
    </div>
</body>

</html>