<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/db/db_connect.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/special/headers.php';

class CategoryModel extends Model{

    function init(){
        return "hello";
    }
    
    function getCategoryCountPages($itemsOnPage)
    {  
        global $pdo;
        $query = "SELECT COUNT(*) FROM `category` WHERE flag_active = 1";
        $stmt = $pdo->query($query);
        while ($row = $stmt->fetch()){
            $total = $row;
        }
        $total["COUNT(*)"] = $total["COUNT(*)"] <= 0 ? 1 : $total["COUNT(*)"];
        return ceil($total["COUNT(*)"]/$itemsOnPage);
    }
    
    function getCategoryCountPagesAdmin($itemsOnPage)
    {
        global $pdo;
        $query = "SELECT COUNT(*) FROM `category`";
        $stmt = $pdo->query($query);
        while ($row = $stmt->fetch()){
            $total = $row;
        }
        $total["COUNT(*)"] = $total["COUNT(*)"] <= 0 ? 1 : $total["COUNT(*)"];
        return ceil($total["COUNT(*)"]/$itemsOnPage);
    }
    
    function findCategoryPaginationPages($from , $to)
    {
        global $pdo;
        $query = "SELECT * FROM `category` WHERE flag_active = 1 LIMIT $from,$to";
        $categories = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }
    
    function findCategoryPaginationPageOrder($from , $to, $condition)
    {
        global $pdo;
        switch($condition){
            case "a-z":
                $query = "SELECT * FROM `category` WHERE flag_active = 1 ORDER BY categoryName LIMIT $from,$to";
                break;
            case "z-a":
                $query = "SELECT * FROM `category` WHERE flag_active = 1 ORDER BY categoryName DESC LIMIT $from,$to";
                break;
        }
        $categories = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }
    
    
    function findCategoryPaginationPagesAdmin($from , $to)
    {
        global $pdo;
        $query = "SELECT * FROM `category` LIMIT $from,$to";
        $categories = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }
    
    function findCategoryName($id)
    {
        global $pdo;
        $query = "SELECT `categoryName` from category WHERE categoryId = $id";
        $categoryName = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
        return $categoryName[0]['categoryName'];
    }
    
    function findActiveCategoryCount()
    {
        global $pdo;
        $query = "SELECT COUNT(*) FROM `category` WHERE flag_active = 1";
        $stmt = $pdo->query($query);
        while ($row = $stmt->fetch()){
            $total = $row;
        }
        return $total["COUNT(*)"];
    }
    
    function findActiveCategoryCountAdmin()
    {
        global $pdo;
        $query = "SELECT COUNT(*) FROM `category`";
        $stmt = $pdo->query($query);
        while ($row = $stmt->fetch()){
            $total = $row;
        }
        return $total["COUNT(*)"];
    }
    
    function findCategory($id)
    {
        global $pdo;
        $query = "SELECT * FROM `category` WHERE categoryId = $id";
        $result = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
        return $result[0];
    }
    
    function findCategoryCount()
    {
        global $pdo;
        $query = "SELECT COUNT(*) FROM `category`";
        $stmt = $pdo->query($query);
        while ($row = $stmt->fetch()){
            $total = $row;
        }
        return $total["COUNT(*)"];
    }
    
    function updateCategory($saveCategory)
    {
        global $pdo;
        $query = "UPDATE `category` SET categoryName =" . "'" . 
        $saveCategory['name'] . "', categoryShortDescr = '" . 
        $saveCategory['shortDescr'] . "', categoryFullDescr = '" .
        $saveCategory['fullDescr'] . "', flag_active = '" . 
        $saveCategory['flag'] . "' WHERE categoryId =" .
        $saveCategory['id'];
        $result = $pdo->query($query);
        return $result;
    }
    
    function findCategoryFullDescr($id)
    {
        global $pdo;   
        $query = "SELECT categoryFullDescr FROM `category` WHERE categoryId = $id";
        $categoryFullDescr = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
        return $categoryFullDescr[0]['categoryFullDescr'];
    }
    
    function getAllCategoryObj()
    {
        global $pdo;
        $query = "SELECT * FROM `category`";
        $categories = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }
    
    function createNewCategory($newCategory)
    {
        global $pdo;
        $query = "INSERT INTO category(categoryName,categoryShortDescr,categoryFullDescr,flag_active) VALUES('" .
        $newCategory['name'] . "','" . 
        $newCategory['shortDescr'] . "','" . 
        $newCategory['fullDescr'] . "','" . 
        $newCategory['flag'] . "')"; 
        $result = $pdo->query($query);
        return $result;
    }

    function validate($category)
    {
        if(!empty($category['name']) && !empty($category['shortDescr']) && 
           !empty($category['fullDescr']) && ($category['flag'] == 1 || 
           $category['flag'] == 0) ){
            return true;     
        }
        return false;
    }
}

?>