<?php 

    require  $_SERVER['DOCUMENT_ROOT'] . '/components/Controller.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/components/Model.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/models/Category.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/models/Good.php';

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

        function init(){ header('Location: http://catalog-site.ru/views/404.php');exit; }

        function parseQuery(){
            
            $categoryModel = new CategoryModel;
            $goodModel = new GoodModel;

            $itemsOnPage = 3;

            $this->goodCountPages = $goodModel->getGoodsCountPages($itemsOnPage,$_GET['category']);

            $this->categoryPagesCount = $categoryModel->findActiveCategoryCount();
        
            if (isset($_GET['category']) && $_GET['category'] >= 1 && $_GET['category'] <= $this->categoryPagesCount+1 && is_numeric($_GET['category']) 
            && isset($_GET['page']) && $_GET['page'] >= 1 && $_GET['page'] <= $this->goodCountPages
            && is_numeric($_GET['page']))
            {
                $categoryPage= $_GET['category'];
                $this->currentPage = $_GET['page'];
            
            } else { header('Location: http://catalog-site.ru/views/404.php');exit;}

            $from = ($this->currentPage - 1) * $itemsOnPage;
            $this->goods = $goodModel->findGoodsOnCategory($from,$itemsOnPage, $_GET['category']);
            
            $this->categoryName = $categoryModel->findCategoryName($categoryPage);
            $this->categoryFullDescr = $categoryModel->findCategoryFullDescr($categoryPage);
        }

    }

?>