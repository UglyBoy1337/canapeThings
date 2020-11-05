<?php 

require  $_SERVER['DOCUMENT_ROOT'] . '/db/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/special/headers.php';

class GoodCategoryModel extends Model{

    function init(){
        return "hello";
    }
    
    function findProductCategory($productId){

        global $db_link;
    
        $query = "SELECT category_id FROM `goods_category` WHERE $productId = goods_category.goods_id";
    
        $result = mysqli_query($db_link,$query);
    
        $categoriesObj = mysqli_fetch_all($result,MYSQLI_ASSOC);
    
        foreach($categoriesObj as $category)
        {
           foreach($category as $key => $val)
           {
               $categoriesId .= $val . ",";
           }
        }
    
       $categoriesId = substr($categoriesId,0,mb_strlen($categoriesId)-1);
    
       $query = "SELECT categoryId, categoryName FROM `category` WHERE categoryId IN ($categoriesId)";
    
       $result = mysqli_query($db_link,$query);
    
       $categories = mysqli_fetch_all($result,MYSQLI_ASSOC);
    
       return $categories;
    }
    
}

?>
