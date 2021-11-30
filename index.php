<?php
// 定数
require_once '../../const.php';
// sql関連
require_once 'model/sql/CRUD.php';
// img関連
require_once 'model/img/FILES.php';
require_once 'model/img/IMG.php';
// CRUD インスタンス作成
$CRUD = new CRUD();
// FILES インスタンス作成
// $FILES = new FILES($_FILES);
// IMG　インスタンス作成
$IMG = new IMG($_FILES);
// 一覧表示
$imgList = $CRUD->sqlRead();
// ボタン送信
if (isset($_POST['submit'])) {
    //日本語に変更 PDOでは不要
    //$_FILES['file']['name'] = $IMG->jpEncode();
    // 投稿
    $CRUD->sqlCreate($_POST['msg'], $_FILES['file']['name']);
    // ファイルアップロード
    if ($IMG->uploadFile()) {
        // サムネイル作成
        // 画像サイズを指定
        list($imgSize,$thumb_width,$thumb_height) = $IMG->ImgSize();
        // 圧縮コピー処理
        $IMG->imgCompress($imgSize,$thumb_width,$thumb_height);
    }
    header('Location:index.php');
    exit;
}

require_once 'view/index.php';
