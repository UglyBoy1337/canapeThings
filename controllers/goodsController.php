<?php 

include_once  $_SERVER['DOCUMENT_ROOT'] . '/components/Controller.php';
include_once  $_SERVER['DOCUMENT_ROOT'] . '/components/Model.php';
include_once  $_SERVER['DOCUMENT_ROOT'] . '/models/Category.php';
include_once  $_SERVER['DOCUMENT_ROOT'] . '/models/Good.php';

class GoodsController extends Controller{

    public $categoryPagesCount;
    public $goods;
    public $categoryName;
    public $categoryFullDescr;
    public $goodCountPages;
    public $currentPage = 1;

    function __construct() {
        if(empty($_GET) && empty($_POST)) { 
            $this->init(); 
        }else{
            $this->parseQuery();
        }
    }

    function init(){ include $_SERVER['DOCUMENT_ROOT'] . '/views/404.php';exit; }

    function parseQuery()
    {
        $categoryModel = new CategoryModel;
        $goodModel = new GoodModel;
        $itemsOnPage = 3;
        $this->goodCountPages = $goodModel->getGoodsCountPages($itemsOnPage,$_GET['category']);
        $this->categoryPagesCount = $categoryModel->findActiveCategoryCount();
        $categoryPage= $_GET['category'];
        $this->currentPage = $_GET['page'];
        if($categoryPage == null || $this->currentPage == null || is_numeric($categoryPage) == false || is_numeric($this->currentPage) == false){
            include $_SERVER['DOCUMENT_ROOT'] . '/views/404.php';exit;
        }
        $from = ($this->currentPage - 1) * $itemsOnPage;
        $this->goods = $goodModel->findGoodsOnCategory($from,$itemsOnPage, $_GET['category']);   
        if($this->goods == null || $this->goods == false){
            include $_SERVER['DOCUMENT_ROOT'] . '/views/404.php';exit;
        } 
        $this->categoryName = $categoryModel->findCategoryName($categoryPage);
        $this->categoryFullDescr = $categoryModel->findCategoryFullDescr($categoryPage);
        include_once $_SERVER['DOCUMENT_ROOT'] . '/views/about.php';
    }

}

?>