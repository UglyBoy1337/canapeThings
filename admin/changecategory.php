<?php

require "../controllers/categoryController.php";
require "../controllers/goodsController.php";
require "../controllers/goods_categoryController.php";

$categoryCount = findCategoryCount();
$errmsg = "Не удалось выполнить обновление, проверьте корректность входных данных";
$succmsg = "Категория успешно обновлена!";

if(isset($_POST['saveCategory']))
{
    $newCategoryName = $_POST['newCategoryName'];
    $newCategoryShortDescr = $_POST['newCategoryShortDescr'];
    $newCategoryFullDecr = $_POST['newCategoryFullDescr'];
    $newCategoryFlagActive = $_POST['newCategoryFlagActive'];
    $categoryId = $_POST['categoryId'];

    $result = updateCategory($categoryId,$newCategoryName,$newCategoryShortDescr,$newCategoryFullDecr,$newCategoryFlagActive);

    if($result == true)
    {
        header('Location: http://catalog-site.ru/admin/changecategory.php?category=' . $_POST['categoryId'] . "&succ");
    }
    else{
        header('Location: http://catalog-site.ru/admin/changecategory.php?category=' . $_POST['categoryId'] . "&err");
    }

}
else
{
    if (isset($_GET['category']) && $_GET['category'] >= 1 && $_GET['category']  && is_numeric($_GET['category']) && $_GET['category'] <= $categoryCount) {
        $currentCategory = $_GET['category'];
    } else {
        header('Location: http://catalog-site.ru/404.php');
        exit;
    }  

    $categoryObj = findCategory($currentCategory);
}


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

    <div class="b-change">
        <div class="change__wrapper">
            <div class="change__title">
                Вы редактируете категорию:<?php echo $categoryObj['categoryName'] ?>
            </div>
            <form action="changecategory.php" method="POST">
            <textarea class="hidden" name="categoryId" rows="1"><?php echo $categoryObj['categoryId']?></textarea>
                <div class="change__field-name">
                    Изменить название категории
                </div>
                <textarea name="newCategoryName" cols="30" rows="1" required><?php echo $categoryObj['categoryName']?></textarea>
                <div class="change__field-name">
                    Изменить краткое описание категории
                </div>
                <textarea name="newCategoryShortDescr" cols="30" rows="5" required><?php echo $categoryObj['categoryShortDescr']?></textarea>
                <div class="change__field-name">
                    Изменить полное описание категории
                </div>
                <textarea name="newCategoryFullDescr" cols="30" rows="5" required><?php echo $categoryObj['categoryFullDescr']?></textarea>
                <div class="change__field-name">
                    Изменить активность категории
                </div>
                <select name="newCategoryFlagActive">
                 <?php 
                 if($categoryObj['flag_active'] == 1)
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
                <a href="http://catalog-site.ru/admin/index.php?categoryPage=1" class="nav__link nav__link--update-category">Назад</a>
            </form>
            <div class="change__errmsg">
                <?php if(isset($_GET['succ'])) {echo $succmsg;} elseif(isset($_GET['err'])) echo $errmsg; ?>
            </div>
        </div>
     </div>
    </div>
</body>

</html>