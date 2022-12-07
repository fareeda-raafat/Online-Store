<?php

//-------------------------- Frontend Function ---------------------------

function getAll($table, $order)
{

    global $conn;
    $stmt = $conn->prepare("SELECT * FROM $table ORDER BY $order DESC");
    $stmt->execute();
    $all = $stmt->fetchAll();
    return $all;
}


function getCats()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM categories");
    $stmt->execute();
    $cats = $stmt->fetchAll();
    return $cats;
}

function getItems($where, $value)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM items WHERE $where = ?");
    $stmt->execute(array($value));
    $items = $stmt->fetchAll();
    return $items;
}

function getComments($value)
{
    global $conn;
    $stmt = $conn->prepare("SELECT Comment FROM comments WHERE user_id = ?");
    $stmt->execute(array($value));
    $items = $stmt->fetchAll();
    return $items;
}



function getStatus($name)
{
    global $conn;

    $stmt = $conn->prepare("SELECT Username , RegStatus FROM users WHERE  Username= ? AND RegStatus=0");
    $stmt->execute(array($name));
    $count = $stmt->rowCount();

    return $count;
}

// function to check if this value item exist or not in DB by return its count
function checkItem($item, $table, $value)
{
    global $conn;
    $sql = $conn->prepare("SELECT $item FROM $table WHERE $item = ?");
    $sql->execute(array($value));
    $counter = $sql->rowCount();
    return $counter;
}



function redirectFun($MSG, $url = null, $second = 3)
{

    if ($url === null) {
        $url = 'index.php';
        $link = 'HomePage';
    } else {
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
            $url = $_SERVER['HTTP_REFERER'];
            $link = 'Previous Page';
        } else {
            $url = 'index.php';
            $link = 'HomePage';
        }
    }
    echo  $MSG;
    echo '<div class="alert alert-info"> You Will Directed To  ' . $link . ' After  ' . $second . '   seconds</div>';
    header('refresh:' . $second . ';url=' . $url);
}








// --------------------------------------------- Backend Functions ----------------------- 
function getTitle()
{
    global $pageTitle;

    if (isset($pageTitle)) {
        echo $pageTitle;
    } else {
        echo 'Defult';
    }
}




// function to count exist item in DB

function countItem($item, $table)
{
    global $conn;
    $sql = $conn->prepare("SELECT COUNT($item) FROM $table");
    $sql->execute();
    return $sql->fetchColumn();
}

//function to get latest item fron DB

function getLatest($item, $table, $order, $limit = 5)
{
    global $conn;
    $stmnt = $conn->prepare("SELECT $item FROM $table ORDER BY $order DESC LIMIT $limit");
    $stmnt->execute();
    $rows = $stmnt->fetchAll();
    return $rows;
}
