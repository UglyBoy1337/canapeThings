<?php

    require  $_SERVER['DOCUMENT_ROOT'] . '/components/Controller.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/components/Model.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/models/Category.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/models/Good.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/models/GoodCategory.php';

    class AdminProductController extends Controller{

        public $currentProduct;
        public $categories;
        public $currentProductCategories;
        public $productSaveMessage;

        function __construct() {
            if(empty($_GET) && empty($_POST)) { 
                $this->init(); 
            }else{
                $this->parseQuery();
            }
        }

        function init(){ header('Location: http://catalog-site.ru/views/404.php');exit; }

        function parseQuery(){
            if(isset($_GET['id'])){ $this->changeProduct($_GET['id']);}
            if(isset($_POST['saveProduct'])){ $this->saveProduct($_POST['productId']);};
        }

        function changeProduct($id){

            $categoryModel = new CategoryModel;
            $goodModel = new GoodModel;
            $goodCategory = new GoodCategoryModel;

            $this->currentProduct = $goodModel->findProduct($id);
            if($this->currentProduct == null) { $this->init();}
            $this->categories = $categoryModel->getAllCategoryObj();
            $this->currentProductCategories = $goodCategory->findProductCategory($id);
        }

        function saveProduct($id){

            $categoryModel = new CategoryModel;
            $goodModel = new GoodModel;
            $goodCategory = new GoodCategoryModel;

            $productId = $id;
            $newProductName = $_POST['newProductName'];
            $newProductShortDescr = $_POST['newProductShortDescr'];
            $newProductFullDescr = $_POST['newProductFullDescr'];
            $newProductActiveFlag = $_POST['newProductActiveFlag'];
            $newProductAmount = $_POST['newProductAmount'];
            $newProductOrder = $_POST['newProductOrder'];
            $newCategories = $_POST['checkCategories'];

            $result = $goodModel->updateProduct($productId,$newProductName,$newProductShortDescr,$newProductFullDescr,$newProductActiveFlag,$newProductAmount,$newProductOrder,$newCategories);

            if($result == true)
            {
                $this->productSaveMessage = "Товар успешно обновлен!";
            }
            else{
                $this->productSaveMessage = "Не удалось выполнить обновление, проверьте корректность входных данных";
            }

            $this->changeProduct($id);

        }

    }

?>