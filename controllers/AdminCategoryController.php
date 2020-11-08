<?php

include_once  $_SERVER['DOCUMENT_ROOT'] . '/components/Controller.php';
include_once  $_SERVER['DOCUMENT_ROOT'] . '/components/Model.php';
include_once  $_SERVER['DOCUMENT_ROOT'] . '/models/Category.php';
include_once  $_SERVER['DOCUMENT_ROOT'] . '/models/Good.php';

class AdminCategoryController extends Controller
{
    public $categories = [];
    public $pagesCategoryCount;
    public $currentPage = 1;
    public $categoryCreateMsg;
    public $currentCategory;
    public $changeCategoryMessage;

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
        $categoryModel = new CategoryModel;
        $goodModel = new GoodModel;
        $itemsOnPage = 3;
        $this->pagesCategoryCount = $categoryModel->getCategoryCountPagesAdmin($itemsOnPage);
        if ($this->pagesCategoryCount <= 0) { include $_SERVER['DOCUMENT_ROOT'] . '/views/404.php';exit; }
        $page = $this->currentPage;
        $from = ($page - 1) * $itemsOnPage;
        $categories = $categoryModel->findCategoryPaginationPagesAdmin($from, $itemsOnPage);
        foreach($categories as $key => $value){
            $categories[$key]['isExists'] = $goodModel->findGoodsOnCategoryAdminExists($value['categoryId']) != null ? true : false;        
        }
        $this->categories = $categories;
        $this->render(1);
        }

    function parseQuery()
    {
        if(isset($_GET['categoryPage'])){ 
            $this->render($_GET['categoryPage']);
        }
        if(isset($_GET['change'])){ 
            $this->changeCategory($_GET['category']);
        }
        if(isset($_POST['category__addCategory'])){ 
            $this->createCategory();
        }
        if(isset($_POST['saveCategory'])){ 
            $this->saveCaetgory($_POST['categoryId']);
        }  
    }

    function render($pageId)
    {
        $categoryModel = new CategoryModel;
        $goodModel = new GoodModel;
        $itemsOnPage = 3;
        $this->pagesCategoryCount = $categoryModel->getCategoryCountPagesAdmin($itemsOnPage);
        if($pageId >= 1 && $pageId <= $this->pagesCategoryCount){ 
            $this->currentPage = $pageId;
        }else{
            include $_SERVER['DOCUMENT_ROOT'] . '/views/404.php';exit;
        }
        if ($this->pagesCategoryCount <= 0 || $pageId > $this->pagesCategoryCount) {  
            include $_SERVER['DOCUMENT_ROOT'] . '/views/404.php';exit; 
        }
        $from = ((int)$pageId - 1) * $itemsOnPage;
        $categories = $categoryModel->findCategoryPaginationPagesAdmin($from, $itemsOnPage);
        foreach($categories as $key => $value){
            $categories[$key]['isExists'] = $goodModel->findGoodsOnCategoryAdminExists($value['categoryId']) != null ? true : false;
        }
        $this->categories = $categories;
        include_once $_SERVER['DOCUMENT_ROOT'] . '/views/admin/index.php';
    }

    function createCategory(){
        $categoryModel = new CategoryModel;
        $newCategory = [
            'name' => $_POST['categoryName'],
            'shortDescr' => $_POST['categoryShortDescr'],
            'fullDescr' => $_POST['categoryFullDescr'],
            'flag' => $_POST['categoryFlagActive']
        ];
        if( $categoryModel->validate($newCategory) && $categoryModel->createNewCategory($newCategory)){
            $this->categoryCreateMsg = "Категория успешно добавлена!";
        }else{
            $this->categoryCreateMsg = "Категория не добавлена!";
        }
        $_POST = NULL;
        $this->render(1);
    }

    function changeCategory($id)
    {
        $categoryModel = new CategoryModel;
        $findCategory = $categoryModel->findCategory($id);
        if($findCategory == null){
            include $_SERVER['DOCUMENT_ROOT'] . '/views/404.php';exit;
        }else{
            $this->currentCategory = $findCategory;
        }
        include_once $_SERVER['DOCUMENT_ROOT'] . '/views/admin/changecategory.php';
    }

    function saveCaetgory($id){
        $categoryModel = new CategoryModel;
        $categoryId = $_POST['categoryId'];
        $saveCategory = [
            'id' => $_POST['categoryId'],
            'name' => $_POST['newCategoryName'],
            'shortDescr' => $_POST['newCategoryShortDescr'],
            'fullDescr' => $_POST['newCategoryFullDescr'],
            'flag' => $_POST['newCategoryFlagActive']
        ];
        if($categoryModel->validate($saveCategory) && $categoryModel->updateCategory($saveCategory)) { 
            $this->changeCategoryMessage = "Категория успешно сохранена";
        }else{
            $this->changeCategoryMessage = "Категория не сохранена, проверьте данные";
        }
        $this->currentCategory = $categoryModel->findCategory($categoryId);
        $_POST = null;
        include_once $_SERVER['DOCUMENT_ROOT'] . '/views/admin/changecategory.php';
        }
    }

?>