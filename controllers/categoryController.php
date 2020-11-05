<?php 
    
    require  $_SERVER['DOCUMENT_ROOT'] . '/components/Controller.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/components/Model.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/models/Category.php';
    require  $_SERVER['DOCUMENT_ROOT'] . '/models/Good.php';

    class CategoryController extends Controller{

        public $categories = [];
        public $productInfo = [];
        public $pagesCategoryCount;
        public $currentPage = 1;
        public $errmsg = "";
        
        function __construct() {
            if(empty($_GET) && empty($_POST)) { 
                $this->init(); 
            }else{
                $this->parseQuery();
            }
        }
        
        function init(){

            $page = $this->currentPage;
            $itemsOnPage = 3;
            
            $categoryModel = new CategoryModel;
            
            $this->pagesCategoryCount = $categoryModel->getCategoryCountPages($itemsOnPage);
            
            if ($this->pagesCategoryCount <= 0) { header('Location: http://catalog-site.ru/views/404.php'); exit; }
                
            $from = ($page - 1) * $itemsOnPage;
                
            $this->categories = $categoryModel->findCategoryPaginationPages($from, $itemsOnPage);
        }

        function parseQuery(){
            if(isset($_GET['categoryPage'])){ $this->render($_GET['categoryPage']);}
            if (isset($_POST['search_product'])){ $this->searchProduct($_POST['search_id']);}
            if (isset($_POST['sortBy']) || isset($_POST['sortDefault'])){ $this->sortBy($_POST['orderBy']);}
        }

        function searchProduct($id){

            $goodModel = new GoodModel;
            $categoryModel = new CategoryModel;

            if(is_numeric($id) && $id >= 0){
                $prodInf = $goodModel->findProduct($id);

                if($prodInf == null) { $this->errmsg = "Ошибка поиска товара"; }else{
                    $this->productinfo = $prodInf;
                }
            }
            
            $this->render(1);

        }

        function sortBy($orederBy){

            $categoryModel = new CategoryModel;

            $page = 1;
            $itemsOnPage = 10;
            $from = ($page - 1) * $itemsOnPage;
                    
            if($_POST['orderBy'] == "a-z" && $_POST['sortDefault'] != 'true')
            {
                $this->categories = $categoryModel->findCategoryPaginationPageOrder($from,$itemsOnPage,"a-z");
            }elseif($_POST['orderBy'] == 'z-a' && $_POST['sortDefault'] != 'true')
            {
                $this->categories = $categoryModel->findCategoryPaginationPageOrder($from,$itemsOnPage,"z-a");
            }elseif($_POST['sortDefault'] == 'true'){
                $this->render(1);
            }       
        }

        function render($pageId){

            $categoryModel = new CategoryModel;
            $itemsOnPage = 3;
            
            $this->pagesCategoryCount = $categoryModel->getCategoryCountPages($itemsOnPage);

            if($pageId >= 1 && $pageId <= $this->pagesCategoryCount){ $this->currentPage = $pageId;}else{
                header('Location: http://catalog-site.ru/views/404.php'); exit;
            }
            
            if ($this->pagesCategoryCount <= 0 || $pageId > $this->pagesCategoryCount) { header('Location: http://catalog-site.ru/views/404.php'); exit; }
                
            $from = ((int)$pageId - 1) * $itemsOnPage;
                
            $this->categories = $categoryModel->findCategoryPaginationPages($from, $itemsOnPage);

        }

    }


?>