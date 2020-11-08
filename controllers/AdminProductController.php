<?php

include_once  $_SERVER['DOCUMENT_ROOT'] . '/components/Controller.php';
include_once  $_SERVER['DOCUMENT_ROOT'] . '/components/Model.php';
include_once  $_SERVER['DOCUMENT_ROOT'] . '/models/Category.php';
include_once  $_SERVER['DOCUMENT_ROOT'] . '/models/Good.php';
include_once  $_SERVER['DOCUMENT_ROOT'] . '/models/GoodCategory.php';

class AdminProductController extends Controller
{
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

    function init(){ include $_SERVER['DOCUMENT_ROOT'] . '/views/404.php';exit; }

    function parseQuery(){
        if(isset($_GET['id'])){ 
            $this->changeProduct($_GET['id']);
        }
        if(isset($_POST['saveProduct'])){ 
            $this->saveProduct($_POST['productId']);
        };
    }

    function changeProduct($id)
    {
        $categoryModel = new CategoryModel;
        $goodModel = new GoodModel;
        $goodCategory = new GoodCategoryModel;
        $this->currentProduct = $goodModel->findProduct($id);
        if($this->currentProduct == null) { $this->init();}
        $this->categories = $categoryModel->getAllCategoryObj();
        $this->currentProductCategories = $goodCategory->findProductCategory($id);
        include_once $_SERVER['DOCUMENT_ROOT'] . '/views/admin/changeProduct.php';
    }

    function saveProduct($id){
        $categoryModel = new CategoryModel;
        $goodModel = new GoodModel;
        $goodCategory = new GoodCategoryModel;
        $product = [
            'id' => $id,
            'name' => $_POST['newProductName'], 
            'shortDescr' =>$_POST['newProductShortDescr'],
            'fullDescr' => $_POST['newProductFullDescr'],
            'flag' => $_POST['newProductActiveFlag'],
            'amount' => $_POST['newProductAmount'],
            'order' => $_POST['newProductOrder'],
            'categories' => $_POST['checkCategories']
        ];
        if( $goodModel->validate($product) && $goodModel->updateProduct($product)){
            $this->productSaveMessage = "Товар успешно обновлен!";
        }
        else{
            $this->productSaveMessage = "Не удалось выполнить обновление, проверьте корректность входных данных";
        }
        $this->changeProduct($id);
    }

}

?>