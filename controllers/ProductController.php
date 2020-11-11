<?php 

include_once  $_SERVER['DOCUMENT_ROOT'] . '/components/Controller.php';
include_once  $_SERVER['DOCUMENT_ROOT'] . '/components/Model.php';
include_once  $_SERVER['DOCUMENT_ROOT'] . '/models/Category.php';
include_once  $_SERVER['DOCUMENT_ROOT'] . '/models/Good.php';
include_once  $_SERVER['DOCUMENT_ROOT'] . '/models/GoodCategory.php';

class ProductController extends Controller
{
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
        include_once $_SERVER['DOCUMENT_ROOT'] . '/views/404.php';exit;
    }

    function parseQuery(){
        if(isset($_GET['id'])){
            $this->render($_GET['id']);
        }
        if(isset($_GET['modalId'])){
            $this->getData($_GET['modalId']);
        }
    }

    function render($productId){
        $categoryGoodModel = new GoodCategoryModel;
        $productModel = new GoodModel;
        $product = $productModel->findProduct($productId);
        if($product == false || $product['flag_active'] == 0){
            include $_SERVER['DOCUMENT_ROOT'] . '/views/404.php';exit; 
        }
        $this->product = $product;
        $this->productcategories = $categoryGoodModel->findProductCategory($productId);
        include_once $_SERVER['DOCUMENT_ROOT'] . '/views/product.php';
    }

    function getData($productId){
        $categoryGoodModel = new GoodCategoryModel;
        $productModel = new GoodModel;
        
        $product = $productModel->findProduct($productId);
        if($product == false || $product['flag_active'] == 0){
            return false;
        }
        $categoryObject = $categoryGoodModel->findProductCategory($productId);
        $categories = [];
        foreach($categoryObject as $category){
            array_push($categories, $category['categoryName']);
        }

        $product['categories'] = $categories;
        echo json_encode($product, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    }

}
    
?>
