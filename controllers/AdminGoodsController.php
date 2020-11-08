<?php

include_once  $_SERVER['DOCUMENT_ROOT'] . '/components/Controller.php';
include_once  $_SERVER['DOCUMENT_ROOT'] . '/components/Model.php';
include_once  $_SERVER['DOCUMENT_ROOT'] . '/models/Category.php';
include_once  $_SERVER['DOCUMENT_ROOT'] . '/models/Good.php';

class AdminGoodsController extends Controller
{
    public $goods = [];
    public $pagesCategoryCount;
    public $categoryName;
    public $categoryFullDescr;
    public $currentPage = 1;
    public $goodCreateMsg;
    public $categories;

    function __construct() 
    {
    if(empty($_GET) && empty($_POST)) { 
        $this->init(); 
    }else{
        $this->parseQuery();
    }
    }

    function init()
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/views/404.php';exit; 
    }

    function parseQuery()
    {
        if(isset($_POST['goodAdd'])) { 
            $this->goodAdd($_POST['categoryId']); 
        }
        if(isset($_GET['category'])) { 
            $this->render($_GET['category']);
        }
    }

    function render($categoryId)
    {
        $categoryModel = new CategoryModel;
        $goodModel = new GoodModel;
        $itemsOnPage = 3;
        $this->currentPage = $_GET['page'];
        $this->pagesCategoryCount = $goodModel->getGoodsCountPages($itemsOnPage,$_GET['category']);
        if ($this->pagesCategoryCount <= 0 || !isset($_GET['category']) 
            || !isset($_GET['page']) || $this->currentPage > $this->pagesCategoryCount || $this->currentPage <= 0){  
            include $_SERVER['DOCUMENT_ROOT'] . '/views/404.php';exit; 
        }
        $from = ($this->currentPage - 1) * $itemsOnPage;
        $this->goods = $goodModel->findGoodsOnCategoryAdmin($from,$itemsOnPage, $_GET['category']);
        $this->categoryName = $categoryModel->findCategoryName($_GET['category']);
        $this->categoryFullDescr = $categoryModel->findCategoryFullDescr($_GET['category']);
        $this->categories = $categoryModel->getAllCategoryObj();
        include_once $_SERVER['DOCUMENT_ROOT'] . '/views/admin/changegoods.php';
    }

    function goodAdd($id)
    {
        $goodModel = new GoodModel;
        $categoryModel = new CategoryModel;
        $product = [
            'idCategory' => $id,
            'name' => $_POST['goodName'], 
            'shortDescr' =>$_POST['goodShortDescr'],
            'fullDescr' => $_POST['goodFullDescr'],
            'flag' => $_POST['goodActiveFlag'],
            'amount' => $_POST['goodAmount'],
            'order' => $_POST['goodOrder'],
            'categories' => $_POST['checkCategories']
        ];
        if($goodModel->validate($product) && $goodModel->addNewGood($product)){
            $this->goodCreateMsg = "Товар успешно добавлен";
        }
        else{
            $this->goodCreateMsg = "Товар не добавлен";
        }
        $_GET['page'] = 1;
        $_GET['category'] = $id;
        $_POST = null;
        include_once $_SERVER['DOCUMENT_ROOT'] . '/views/admin/changegoods.php';
    }

}

?>