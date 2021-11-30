<?php

require_once '../../const.php';
try {
    $link = new PDO('mysql:dbname=' . DB_NAME . ';host=' . HOST . ';charset=utf8mb4', USER_ID, PASSWORD);
    //********************* SQL取得 **************************
    $pdo = $link->query("SELECT * from m_msg");
    $imgList = $pdo->fetchAll(PDO::FETCH_NAMED);
} catch (PDOException $err) {
    exit('DB接続エラー:' . $err->getMessage());
}
// ボタン送信時
if (isset($_POST['submit'])) {
    //日本語に変更
    require_once 'model/jpEncode.php';
    // $file_name = mb_convert_encoding($_FILES['file']['name'], 'sjis', 'utf8');
    $file_name = $_FILES['file']['name'];
    // sql create
    $sql = "INSERT INTO m_msg (msg,img) VALUES (:msg,:img)";
    $pdo = $link->prepare($sql);
    $pdo->bindValue(':msg', $_POST['msg'], PDO::PARAM_STR);
    $pdo->bindValue(':img', $file_name, PDO::PARAM_STR);
    $pdo->execute();
    //********************* 写真データ圧縮 **************************
    if (uploaded_file()) {
        //◎画像サイズを取得
        $img_size = getimagesize('img/' . $file_name);
        // 圧縮比率 h×w 100:150
        if ($img_size[1] / 100 > $img_size[0] / 150) {
            $thumb_width = $img_size[0] / ($img_size[1] / 100);
            $thumb_height = $img_size[1] / ($img_size[1] / 100);
        } else {
            $thumb_height = $img_size[1] / ($img_size[0] / 150);
            $thumb_width = $img_size[0] / ($img_size[0] / 150);
        }
        // 拡張子によって圧縮方法変更
        $ext = str_replace('image/', '', $_FILES['file']['type']);
        if ($ext === 'jpeg') {
            $ext = 'jpg';
        }
        //◎画像ファイルのコピーおよび画像ファイルの縮小拡大(png)
        switch ($ext) {
            case 'jpg':
                $img_in = imagecreatefromjpeg('img/' . $file_name);
                break;
            case 'png':
                $img_in = imagecreatefrompng('img/' . $file_name);
                break;
            case 'gif':
                $img_in = imagecreatefromgif('img/' . $file_name);
                break;
            default:
                break;
        }
        $img_out = ImageCreateTruecolor(intval($thumb_width), intval($thumb_height));
        // pngのみ透過等がある為設定
        if ($ext === 'png') {
            imagealphablending($img_out, false);
            imagesavealpha($img_out, true);
        }
        ImageCopyResampled($img_out, $img_in, 0, 0, 0, 0, $thumb_width, $thumb_height, $img_size[0], $img_size[1]);
        //画像ファイルの書き出し
        switch ($ext) {
            case 'jpg':
                Imagejpeg($img_out, 'img/thumb_' . $file_name);
                break;
            case 'png':
                Imagepng($img_out, 'img/thumb_' . $file_name);
                break;
            case 'gif':
                Imagegif($img_out, 'img/thumb_' . $file_name);
                break;
            default:
                break;
        }
        //◎画像加工を行った後は、メモリを開放すること
        ImageDestroy($img_in);
        ImageDestroy($img_out);
    }
    header('Location:index.php');
    exit;
}

require_once 'view/index.php';
