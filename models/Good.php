<?php 

require $_SERVER['DOCUMENT_ROOT'] . '/db/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/special/headers.php';

class GoodModel extends Model{

    function init(){
        return "hello";
    }

    function findGoodsOnCategory($from, $to, $category){

        global $db_link;
    
        $query = "SELECT * FROM `goods`,`goods_category` WHERE goods.goodId = goods_category.goods_id AND goods_category.category_id = $category AND flag_active = 1 LIMIT $from,$to";
    
        $result = mysqli_query($db_link,$query);
    
        $goods = mysqli_fetch_all($result,MYSQLI_ASSOC);
    
        return $goods;
    }
    
    function findGoodsOnCategoryAdmin($from, $to, $category){
    
        global $db_link;
    
        $query = "SELECT * FROM `goods`,`goods_category` WHERE goods.goodId = goods_category.goods_id AND goods_category.category_id = $category LIMIT $from,$to";
    
        $result = mysqli_query($db_link,$query);
    
        $goods = mysqli_fetch_all($result,MYSQLI_ASSOC);
    
        return $goods;
    }
    
    function findGoodsOnCategoryAdminExists($categoryId){
    
        global $db_link;
    
        $query = "SELECT * FROM `goods`,`goods_category` WHERE goods.goodId = goods_category.goods_id AND goods_category.category_id = $categoryId AND flag_active = 1";
    
        $result = mysqli_query($db_link,$query);
    
        $goods = mysqli_fetch_all($result,MYSQLI_ASSOC);
    
        return $goods;
    }
    
    function getGoodsCountPages($itemsOnPage,$category){
    
        global $db_link;
    
        $query = "SELECT COUNT(*) FROM `goods`,`goods_category` WHERE goods.goodId = goods_category.goods_id AND goods_category.category_id = $category AND flag_active = 1";
    
        $result = mysqli_query($db_link,$query);
    
        $total = mysqli_fetch_row($result);
    
        return ceil($total[0]/$itemsOnPage);
    }
    
    function findProduct($productId){
    
        global $db_link;
    
        $query = "SELECT * FROM `goods` WHERE goodId = $productId";
    
        $result = mysqli_query($db_link,$query);
    
        $product = mysqli_fetch_all($result,MYSQLI_ASSOC);
    
        return $product[0];
    }
    
    function addNewGood($idCategory, $goodName, $goodShortDescr, $goodFullDescr,$goodFlagAcitve, $goodAmount,$goodCanOrder,$goodCategories){
    
        global $db_link;
    
        $goodName =  mysqli_real_escape_string($db_link,$goodName);
    
        $goodShortDescr = mysqli_real_escape_string($db_link,$goodShortDescr);
    
        $goodFullDescr = mysqli_real_escape_string($db_link,$goodFullDescr);
    
        if($idCategory >= 1 && !empty($goodName) && !empty($goodShortDescr) && !empty($goodFullDescr) && ($goodFlagAcitve == 1 || $goodFlagAcitve == 0) && ($goodAmount >= 0) && ($goodCanOrder == 1 || $goodCanOrder == 0))
        {
            $query = "INSERT INTO `goods`(`goodName`, `goodShortDescr`, `goodFullDescr`, `flag_active`, `goodAmount`, `flag_order`) VALUES ('$goodName','$goodShortDescr','$goodFullDescr',$goodFlagAcitve,$goodAmount,$goodCanOrder)";
         
            $result = mysqli_query($db_link,$query);
    
            if($result == true)
            {
                $query = "SELECT MAX(goodId) FROM `goods`";
    
                $result = mysqli_query($db_link,$query);
    
                $goodId = mysqli_fetch_row($result);
    
                if($goodCategories != null && count($goodCategories) >= 1)
                {
                    $query = "INSERT INTO `goods_category`(`goods_id`, `category_id`) VALUES";
                    foreach ($goodCategories as $key=>$value) {
                    $query .= "($goodId[0],{$value})";
                
                    if ($key+1 < count($goodCategories)) {
                      $query .= ", ";
                    }
                    }
            
                    $result = mysqli_query($db_link,$query);
                }
                else{
                    $query = "INSERT INTO `goods_category`(`goods_id`, `category_id`) VALUES($goodId[0],1)";
                    $result = mysqli_query($db_link,$query);
                }
    
                return $result;
            }
    
            return false;
        }
    
        return false;
    }
    
    function updateProduct($productId,$newProductName,$newProductShortDescr,$newProductFullDescr,$newProductActiveFlag,$newProductAmount,$newProductOrder,$newCategories){
    
        global $db_link;
    
        $newProductName =  mysqli_real_escape_string($db_link,$newProductName);
    
        $newProductShortDescr = mysqli_real_escape_string($db_link,$newProductShortDescr);
    
        $newProductFullDescr = mysqli_real_escape_string($db_link,$newProductFullDescr);
    
        if($productId >= 1 && !empty($newProductName) && !empty($newProductShortDescr) && !empty($newProductFullDescr) && ($newProductActiveFlag == 1 || $newProductActiveFlag == 0) && ($newProductAmount >= 0) && ($newProductOrder == 1 || $newProductOrder == 0)){
    
            if($newCategories <= 0 || count($newCategories) == null){ $newCategories = ['0'=>'1'];}
    
                $query = "UPDATE `goods` SET goodName = '$newProductName', goodShortDescr = '$newProductShortDescr', goodFullDescr = '$newProductFullDescr', flag_active = '$newProductActiveFlag', goodAmount = '$newProductAmount', flag_order = '$newProductOrder' WHERE goodId = '$productId'";
    
                $result = mysqli_query($db_link,$query);
    
                $query = "DELETE FROM `goods_category` WHERE goods_id = $productId";
    
                $result = mysqli_query($db_link,$query);
    
                $query = "INSERT INTO `goods_category`(`goods_id`, `category_id`) VALUES";
    
                    foreach ($newCategories as $key=>$value) {
                    $query .= "($productId,{$value})";
                
                    if ($key+1 < count($newCategories)) {
                      $query .= ", ";
                    }
                    }
                    $result = mysqli_query($db_link,$query);
                return $result;
        }
        return false;
    }

}

?>