<?php 

include_once $_SERVER['DOCUMENT_ROOT'] . '/db/db_connect.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/special/headers.php';

class GoodModel extends Model
{
    function init()
    {
        return "hello";
    }

    function findGoodsOnCategory($from, $to, $category)
    {
        global $pdo;
        $query = "SELECT * FROM `goods`,`goods_category` WHERE goods.goodId = goods_category.goods_id AND goods_category.category_id = $category AND flag_active = 1 LIMIT $from,$to";
        $goods = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
        return $goods;
    }
    
    function findGoodsOnCategoryAdmin($from, $to, $category)
    {
        global $pdo;
        $query = "SELECT * FROM `goods`,`goods_category` WHERE goods.goodId = goods_category.goods_id AND goods_category.category_id = $category LIMIT $from,$to";
        $goods = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
        return $goods;
    }
    
    function findGoodsOnCategoryAdminExists($categoryId)
    {
        global $pdo;
        $query = "SELECT * FROM `goods`,`goods_category` WHERE goods.goodId = goods_category.goods_id AND goods_category.category_id = $categoryId AND flag_active = 1";
        $goods = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
        return $goods;
    }
    
    function getGoodsCountPages($itemsOnPage,$category)
    {
        global $pdo;
        $query = "SELECT COUNT(*) FROM `goods`,`goods_category` WHERE goods.goodId = goods_category.goods_id AND goods_category.category_id = $category AND flag_active = 1";
        $stmt = $pdo->query($query);
        while ($row = $stmt->fetch()) {
            $total = $row;
        }
        return ceil($total["COUNT(*)"]/$itemsOnPage);
    }
    
    function findProduct($productId)
    {
        global $pdo;
        $query = "SELECT * FROM `goods` WHERE goodId = $productId";
        $product = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
        return $product[0];
    }
    
    function addNewGood($product)
    {
        global $pdo;
        $query = "INSERT INTO `goods`(`goodName`, `goodShortDescr`, `goodFullDescr`, `flag_active`, `goodAmount`, `flag_order`) VALUES ('" .
        $product['name'] . "','" .
        $product['shortDescr'] . "','" . 
        $product['fullDescr'] . "','" . 
        $product['flag'] . "','" . 
        $product['amount'] . "','" . 
        $product['order'] . "'" . ")";
        $result = $pdo->query($query);
        if($result == true){
            $query = "SELECT MAX(goodId) FROM `goods`";
            $stmt = $pdo->query($query);
            while ($row = $stmt->fetch()) {
                $goodId = $row;
            }
            $goodId = $goodId['MAX(goodId)'];
            if($product['categories'] != null && count($product['categories']) >= 1){
                $query = "INSERT INTO `goods_category`(`goods_id`, `category_id`) VALUES";
                foreach ($product['categories'] as $key=>$value){
                    $query .= "(" . $goodId .",{$value})";  
                    if ($key+1 < count($product['categories'])) {
                        $query .= ", ";
                    }
                }
                $result = $pdo->query($query);
            }else{
                $query = "INSERT INTO `goods_category`(`goods_id`, `category_id`) VALUES($goodId[0],1)";
                $result = $pdo->query($query);
            }
        }
        return $result;
    }
    
    function updateProduct($product)
    {
        global $pdo;
        if($product['categories'] <= 0 || count($product['categories']) == null){ 
            $product['categories'] = ['0'=>'1'];
        }
        $query = "UPDATE goods SET goodName = " . "'"   .  $product['name'] . 
                            "',goodShortDescr ='" .  $product['shortDescr'] . 
                            "',goodFullDescr ='"  .  $product['fullDescr'] .
                            "',flag_active ='"    .  $product['flag'] . 
                            "',goodAmount ='"     .  $product['amount'] .
                            "',flag_order ='"     .  $product['order'] . 
                            "' WHERE goodId ='"   .  $product['id'] . "'";
        $result = $pdo->query($query);
        $query = "DELETE FROM `goods_category` WHERE goods_id = " . $product['id'];
        $result = $pdo->query($query);
        $query = "INSERT INTO `goods_category`(`goods_id`, `category_id`) VALUES";
        foreach ($product['categories'] as $key=>$value) {
            $query .= "(" . $product['id'] . ",{$value})";
            if ($key+1 < count($product['categories'])){
                $query .= ", ";
            }
            echo(count($product['categories']));
        }
        $result = $pdo->query($query);
        return $result;
    }

    function validate($product)
    {
        if(!empty($product['name']) && !empty($product['shortDescr']) && 
           !empty($product['fullDescr']) && ($product['flag'] == 1 || 
           $product['flag'] == 0) && ($product['amount'] >= 0) 
           && ($product['order'] == 1 || $product['order'] == 0)){
            return true;
        }
        return false;
    }

}

?>