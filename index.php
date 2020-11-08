<?php
 
    include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/CategoryController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/GoodsController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/ProductController.php';

    $CategoryConroller;
    $goodController;
    $ProductController;

    if(isset($_GET['categoryPage']) || empty($_GET)){
        $CategoryConroller = new CategoryController;
    }
    
    if(isset($_GET['category']) && isset($_GET['page'])){
        $goodController = new GoodsController;
    }

    if(isset($_GET['id'])){
        $ProductController = new ProductController;
    }


?>