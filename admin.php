<?php
 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/AdminCategoryController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/AdminGoodsController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/AdminProductController.php';

    if(isset($_POST['categoryName'])){
        $AdminCategoryController = new AdminCategoryController;
    }

    if(empty($_GET) && empty($_POST)){
        $AdminCategoryController = new AdminCategoryController;   
    }

    if(isset($_POST['saveCategory'])){
        $AdminCategoryController = new AdminCategoryController;
    }

    if(isset($_GET['categoryPage'])){
        $AdminCategoryController = new AdminCategoryController; 
    }

   if(isset($_GET['page']) || isset($_POST['goodAdd'])){
        $adminGoodController = new AdminGoodsController;
   }else{
        if(isset($_GET['change']) && isset($_GET['category'])){
            $AdminCategoryController = new AdminCategoryController;
        }
    }

    if(isset($_GET['id']) || isset($_POST['saveProduct'])){
        $adminProductController = new AdminProductController;
    }

?>