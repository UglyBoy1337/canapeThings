<?php

    require  $_SERVER['DOCUMENT_ROOT'] . '/components/Controller.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/components/Model.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/models/Category.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/models/Good.php';

    class AdminGoodsController extends Controller{

        public $goods = [];
        public $pagesCategoryCount;
        public $categoryName;
        public $categoryFullDescr;
        public $currentPage = 1;
        public $goodCreateMsg;
        public $categories;

        function __construct() {
            if(empty($_GET) && empty($_POST)) { 
                $this->init(); 
            }else{
                $this->parseQuery();
            }
        }

        function init(){ header('Location: http://catalog-site.ru/views/404.php');exit; }

        function parseQuery(){
            if(isset($_GET['category'])) { $this->render($_GET['category']); }
            if(isset($_POST['goodAdd'])) { $this->goodAdd($_POST['categoryId']); }
        }

        function render($categoryId)
        {
            $categoryModel = new CategoryModel;
            $goodModel = new GoodModel;

            $itemsOnPage = 3;

            $this->currentPage = $_GET['page'];

            $this->pagesCategoryCount = $goodModel->getGoodsCountPages($itemsOnPage,$_GET['category']);

            if ($this->pagesCategoryCount <= 0 || !isset($_GET['category']) || !isset($_GET['page']) || $this->currentPage > $this->pagesCategoryCount || $this->currentPage <= 0) { header('Location: http://catalog-site.ru/views/404.php');exit;}

            $from = ($this->currentPage - 1) * $itemsOnPage;

            $this->goods = $goodModel->findGoodsOnCategoryAdmin($from,$itemsOnPage, $_GET['category']);

            $this->categoryName = $categoryModel->findCategoryName($_GET['category']);

            $this->categoryFullDescr = $categoryModel->findCategoryFullDescr($_GET['category']);

            $this->categories = $categoryModel->getAllCategoryObj();
        }

        function goodAdd($id){

            $goodModel = new GoodModel;
            $categoryModel = new CategoryModel;

            $categoryId = $id;
            $goodName = $_POST['goodName'];
            $goodShortDescr = $_POST['goodShortDescr'];
            $goodFullDescr = $_POST['goodFullDescr'];
            $goodFlagActive = $_POST['goodActiveFlag'];
            $goodAmount = $_POST['goodAmount'];
            $goodCanOrder = $_POST['goodOrder'];
            $goodCategories = $_POST['checkCategories'];
            
            $result = $goodModel->addNewGood($categoryId,$goodName,$goodShortDescr,$goodFullDescr,$goodFlagActive,$goodAmount,$goodCanOrder,$goodCategories);

            if($result == true)
            {
               $this->goodCreateMsg = "Товар успешно добавлен";
            }
            else{
                $this->goodCreateMsg = "Товар не добавлен";
            }

            header('Location: http://catalog-site.ru/views/admin/changegoods.php?category=' . $id . '&page=1.php');
        }

    }


?>