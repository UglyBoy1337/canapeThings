<?php 

    require  $_SERVER['DOCUMENT_ROOT'] . '/components/Controller.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/components/Model.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/models/Category.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/models/Good.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/models/GoodCategory.php';

    class ProductController extends Controller{

        public $product;
        public $productcategories;

        function __construct() {
            if(empty($_GET) && empty($_POST)) { 
                $this->init(); 
            }else{
                $this->parseQuery();
            }
        }

        function init(){
            header('Location: http://catalog-site.ru/views/404.php');exit;
        }

        function parseQuery(){

            $categoryGoodModel = new GoodCategoryModel;
            $productModel = new GoodModel;

            $productId = null;

            if(isset($_GET['id']) && $_GET['id'] >= 1 && $_GET['id']  && is_numeric($_GET['id']))
            {
                $productId = $_GET['id'];
            }else{header('Location: http://catalog-site.ru/views/404.php');exit;}
            $product = $productModel->findProduct($productId);
            if($product == false || $product['flag_active'] == 0){header('Location: http://catalog-site.ru/views/404.php');exit;}
            $this->product = $product;
            $this->productcategories = $categoryGoodModel->findProductCategory($productId);
        }

    }
    
?>
