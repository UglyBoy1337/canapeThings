<?php

require  $_SERVER['DOCUMENT_ROOT'] . '/db/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/special/headers.php';

function getCategoryCountPages($itemsOnPage){  

    global $db_link;

    $query = "SELECT COUNT(*) FROM `category` WHERE flag_active = 1";

    $result = mysqli_query($db_link,$query);

    $total = mysqli_fetch_row($result);

    $total[0] = $total[0] <= 0 ? 1 : $total[0];

    return ceil($total[0]/$itemsOnPage);
}

function getCategoryCountPagesAdmin($itemsOnPage){

    global $db_link;

    $query = "SELECT COUNT(*) FROM `category`";

    $result = mysqli_query($db_link,$query);

    $total = mysqli_fetch_row($result);

    $total[0] = $total[0] <= 0 ? 1 : $total[0];

    return ceil($total[0]/$itemsOnPage);
}

function findCategoryPaginationPages($from , $to){

    global $db_link;

    $query = "SELECT * FROM `category` WHERE flag_active = 1 LIMIT $from,$to";

    $result = mysqli_query($db_link,$query);

    $categories = mysqli_fetch_all($result,MYSQLI_ASSOC);

    return $categories;
}

function findCategoryPaginationPageOrder($from , $to, $condition)
{
    global $db_link;

    switch($condition)
    {
        case "a-z":
            $query = "SELECT * FROM `category` WHERE flag_active = 1 ORDER BY categoryName LIMIT $from,$to";
        break;
        case "z-a":
            $query = "SELECT * FROM `category` WHERE flag_active = 1 ORDER BY categoryName DESC LIMIT $from,$to";
        break;
    }

    $result = mysqli_query($db_link,$query);

    $categories = mysqli_fetch_all($result,MYSQLI_ASSOC);

    return $categories;
}


function findCategoryPaginationPagesAdmin($from , $to){

    global $db_link;

    $query = "SELECT * FROM `category` LIMIT $from,$to";

    $result = mysqli_query($db_link,$query);

    $categories = mysqli_fetch_all($result,MYSQLI_ASSOC);

    return $categories;
}

function findCategoryName($id){

    global $db_link;

    $query = "SELECT `categoryName` from category WHERE categoryId = $id";

    $result = mysqli_query($db_link,$query);

    $categoryName = mysqli_fetch_assoc($result);

    return $categoryName['categoryName'];
}

function findActiveCategoryCount(){

    global $db_link;

    $query = "SELECT COUNT(*) FROM `category` WHERE flag_active = 1";

    $result = mysqli_query($db_link,$query);

    $total = mysqli_fetch_row($result);

    return $total[0];
}

function findActiveCategoryCountAdmin(){

    global $db_link;

    $query = "SELECT COUNT(*) FROM `category`";

    $result = mysqli_query($db_link,$query);

    $total = mysqli_fetch_row($result);

    return $total[0];
}

function findCategory($id){

    global $db_link;

    $query = "SELECT * FROM `category` WHERE categoryId = $id";

    $result = mysqli_query($db_link,$query);

    $category = mysqli_fetch_all($result,MYSQLI_ASSOC);

    return $category[0];
}

function findCategoryCount(){

    global $db_link;

    $query = "SELECT COUNT(*) FROM `category`";

    $result = mysqli_query($db_link,$query);

    $total = mysqli_fetch_row($result);

    return $total[0];
}

function updateCategory($id,$categoryName,$categoryShortDescr,$categoryFullDescr,$flag_active){

    global $db_link;

    $categoryName =  mysqli_real_escape_string($db_link,$categoryName);

    $categoryShortDescr = mysqli_real_escape_string($db_link,$categoryShortDescr);

    $categoryFullDescr = mysqli_real_escape_string($db_link,$categoryFullDescr);

    $flag_active = mysqli_real_escape_string($db_link,$flag_active);

    if(!empty($categoryName) && !empty($categoryShortDescr) && !empty($categoryFullDescr) && ($flag_active == 1 || $flag_active == 0) )
    {
        $query = "UPDATE `category` SET categoryName = '$categoryName', categoryShortDescr = '$categoryShortDescr', categoryFullDescr = '$categoryFullDescr', flag_active = '$flag_active' WHERE categoryId = '$id'";
     
        $result = mysqli_query($db_link,$query);

        return $result;
    }

    return false;

}

function findCategoryFullDescr($id){

    global $db_link;

    $query = "SELECT categoryFullDescr FROM `category` WHERE categoryId = $id";

    $result = mysqli_query($db_link,$query);

    $categoryFullDescr = mysqli_fetch_all($result,MYSQLI_ASSOC);

    return $categoryFullDescr[0]['categoryFullDescr'];
}

function getAllCategoryObj(){

    global $db_link;

    $query = "SELECT * FROM `category`";

    $result = mysqli_query($db_link,$query);

    $categories = mysqli_fetch_all($result,MYSQLI_ASSOC);

    return $categories;
}

function createNewCategory($categoryName,$categoryShortDescr,$categoryFullDescr,$flag_active){

    global $db_link;

    $categoryName = mysqli_real_escape_string($db_link,$categoryName);

    $categoryShortDescr = mysqli_real_escape_string($db_link,$categoryShortDescr);

    $categoryFullDescr = mysqli_real_escape_string($db_link,$categoryFullDescr);

    $flag_active = mysqli_real_escape_string($db_link,$flag_active);

    if(!empty($categoryName) && !empty($categoryShortDescr) && !empty($categoryFullDescr) && ($flag_active == 1 || $flag_active == 0) )
    {
        $query = "INSERT INTO category(categoryName,categoryShortDescr,categoryFullDescr,flag_active) VALUES('$categoryName','$categoryShortDescr','$categoryFullDescr','$flag_active')";
     
        $result = mysqli_query($db_link,$query);

        return $result;
    }
    return false;
}

?>