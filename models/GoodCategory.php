<?php 

include_once  $_SERVER['DOCUMENT_ROOT'] . '/db/db_connect.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/special/headers.php';

class GoodCategoryModel extends Model{

    function init()
    {
        return "hello";
    }
    
    function findProductCategory($productId)
    {
        global $pdo;
        $query = "SELECT category_id FROM `goods_category` WHERE $productId = goods_category.goods_id";
        $categoriesObj = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
        foreach($categoriesObj as $category){
           foreach($category as $key => $val){
               $categoriesId .= $val . ",";
           }
        }
       $categoriesId = substr($categoriesId,0,mb_strlen($categoriesId)-1);
       $query = "SELECT categoryId, categoryName FROM `category` WHERE categoryId IN ($categoriesId)";
       $categories = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
       return $categories;
    }
    
    function validate($obj){ }
}

?>
