<?php

    require  $_SERVER['DOCUMENT_ROOT'] . '/components/Controller.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/components/Model.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/models/Category.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/models/Good.php';

    class AdminCategoryController extends Controller{

        public $categories = [];
        public $pagesCategoryCount;
        public $currentPage = 1;
        public $categoryCreateMsg;
        public $currentCategory;
        public $changeCategoryMessage;

        function __construct() {
            if(empty($_GET) && empty($_POST)) { 
                $this->init(); 
            }else{
                $this->parseQuery();
            }
        }

        function init(){

            $categoryModel = new CategoryModel;
            $goodModel = new GoodModel;

            $itemsOnPage = 3;
            $this->pagesCategoryCount = $categoryModel->getCategoryCountPagesAdmin($itemsOnPage);

            if ($this->pagesCategoryCount <= 0) {header('Location: http://catalog-site.ru/view/404.php');exit;}
                
            $page = $this->currentPage;

            $from = ($page - 1) * $itemsOnPage;
            $categories = $categoryModel->findCategoryPaginationPagesAdmin($from, $itemsOnPage);

            foreach($categories as $key => $value){

                $categories[$key]['isExists'] = $goodModel->findGoodsOnCategoryAdminExists($value['categoryId']) != null ? true : false;
                
            }

            $this->categories = $categories;
        }

        function parseQuery(){

            if(isset($_GET['categoryPage'])){ $this->render($_GET['categoryPage']);}
            if(isset($_POST['category__addCategory'])){ $this->createCategory();}
            if(isset($_GET['change'])){ $this->changeCategory($_GET['category']);}
            if(isset($_POST['saveCategory'])){ $this->saveCaetgory($_GET['category']);}
            
        }

        function render($pageId){

            $categoryModel = new CategoryModel;
            $goodModel = new GoodModel;

            $itemsOnPage = 3;

            $this->pagesCategoryCount = $categoryModel->getCategoryCountPagesAdmin($itemsOnPage);

            if($pageId >= 1 && $pageId <= $this->pagesCategoryCount){ $this->currentPage = $pageId;}else{
                header('Location: http://catalog-site.ru/views/404.php'); exit;
            }

            if ($this->pagesCategoryCount <= 0 || $pageId > $this->pagesCategoryCount) { header('Location: http://catalog-site.ru/views/404.php'); exit; }
            
            $from = ((int)$pageId - 1) * $itemsOnPage;

            $categories = $categoryModel->findCategoryPaginationPagesAdmin($from, $itemsOnPage);

            foreach($categories as $key => $value){

                $categories[$key]['isExists'] = $goodModel->findGoodsOnCategoryAdminExists($value['categoryId']) != null ? true : false;
                
            }

            $this->categories = $categories;
        }

        function createCategory(){

            $categoryModel = new CategoryModel;

            $categoryName = $_POST['categoryName'];
            $categoryShortDescr = $_POST['categoryShortDescr'];
            $categoryFullDescr = $_POST['categoryFullDescr'];
            $flag_active = $_POST['categoryFlagActive'];

            $createCategoryResult = $categoryModel->createNewCategory($categoryName,$categoryShortDescr,$categoryFullDescr,$flag_active);

            if(createCategoryResult){
                $this->categoryCreateMsg = "Категория успешно добавлена!";
            }else{
                $this->categoryCreateMsg = "Категория не добавлена!";
            }

            $this->render(1);

        }

        function changeCategory($id){
            $categoryModel = new CategoryModel;
            $findCategory = $categoryModel->findCategory($id);

            if($findCategory == null){
                header('Location: http://catalog-site.ru/views/404.php'); exit;
            }else{
                $this->currentCategory = $findCategory;
            }
        }

        function saveCaetgory($id){

            $categoryModel = new CategoryModel;

            $newCategoryName = $_POST['newCategoryName'];
            $newCategoryShortDescr = $_POST['newCategoryShortDescr'];
            $newCategoryFullDecr = $_POST['newCategoryFullDescr'];
            $newCategoryFlagActive = $_POST['newCategoryFlagActive'];
            $categoryId = $_POST['categoryId'];

            $result = $categoryModel->updateCategory($categoryId,$newCategoryName,$newCategoryShortDescr,$newCategoryFullDecr,$newCategoryFlagActive);

            if($result) { $this->changeCategoryMessage = "Категория успешно сохранена";}else{$this->changeCategoryMessage = "Категория не сохранена, проверьте данные";}

            $this->currentCategory = $categoryModel->findCategory($categoryId);
        }


    }

?>