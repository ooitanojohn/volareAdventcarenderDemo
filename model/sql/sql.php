<?php
require_once '../../../../const.php';

// 定数は中でも有効
/**
 *
 */
class CRUD{

    private object $link;
    // sql 接続
    public function __construct(){
        try {
            $link = new PDO('mysql:dbname=' . DB_NAME . ';host=' . HOST . ';charset=utf8mb4', USER_ID, PASSWORD);
            $this->link = $link;
        } catch (PDOException $err) {
            exit('DB接続エラー:' . $err->getMessage());
        }
    }
    public function getMessage(){
        return $this->link;
    }
    // read
    public function sqlRead(){
        $pdo = $this->link->query("SELECT * from m_msg");
    return $pdo->fetchAll(PDO::FETCH_NAMED);
    }
    // create
    public function sqlCreate($msg, $file_name)
    {
        $sql = "INSERT INTO m_msg (msg,img) VALUES (:msg,:img)";
        $pdo = $this->link->prepare($sql);
        $pdo->bindValue(':msg', $msg, PDO::PARAM_STR);
        $pdo->bindValue(':img', $file_name, PDO::PARAM_STR);
        $pdo->execute();
    }
}
$link = new CRUD();
var_dump($link);
var_dump($link->getMessage());
var_dump($link->sqlRead());
// var_dump($link->sqlCreate());
/**
 *sql接続
 返り値 DBリンクobj
 */
function sqlLink()
{
    try {
        return new PDO('mysql:dbname=' . DB_NAME . ';host=' . HOST . ';charset=utf8mb4', USER_ID, PASSWORD);
    } catch (PDOException $err) {
        exit('DB接続エラー:' . $err->getMessage());
    }
}
/**
 * 一覧表示
 * 引数 DBリンクobj
 * 返り値 リスト一覧
 */
function sqlRead($link)
{
    $pdo = $link->query("SELECT * from m_msg");
    return $pdo->fetchAll(PDO::FETCH_NAMED);
}

/**
 * 投稿
 * 引数 DBリンクobj,メッセージ,ファイル名
 */
function sqlCreate($link, $msg, $file_name)
{
    $sql = "INSERT INTO m_msg (msg,img) VALUES (:msg,:img)";
    $pdo = $link->prepare($sql);
    $pdo->bindValue(':msg', $msg, PDO::PARAM_STR);
    $pdo->bindValue(':img', $file_name, PDO::PARAM_STR);
    $pdo->execute();
}
