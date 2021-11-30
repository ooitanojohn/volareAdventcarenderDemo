<?php
// 定数は中でも有効
/**
 * クラスCRUD プロパティ DBリンク
 * @param object $link
 */
class CRUD{

    private object $link;
    // sql 接続
    public function __construct(){
        try {
            $link = new PDO('mysql:dbname=' . DB_NAME . ';host=' . HOST .PORT.';charset=utf8', USER_ID, PASSWORD);
            $this->link = $link;
        } catch (PDOException $err) {
            exit('DB接続エラー:' . $err->getMessage());
        }
    }
    /**
     * read 返り値 m_msgリスト一覧
     * @return array
     * */
    public function sqlRead(){
        $pdo = $this->link->query("SELECT * from m_msg");
        return $pdo->fetchAll(PDO::FETCH_NAMED);
    }
    /**
     * create 引数 一言 ファイル名
     * @param string $msg
     * @param string $file_name
    */
    public function sqlCreate($msg, $file_name)
    {
        $sql = "INSERT INTO m_msg (msg,img) VALUES (:msg,:img)";
        $pdo = $this->link->prepare($sql);
        $pdo->bindValue(':msg', $msg, PDO::PARAM_STR);
        $pdo->bindValue(':img', $file_name, PDO::PARAM_STR);
        $pdo->execute();
    }
}

/**
 * DB接続 環境ini読み込んで設定
*/
class MyPDO extends PDO
{
    public function __construct($file = 'my.ini')
    {
        // my.ini ファイルを読み込めなかったら例外errMsg
        if (!$settings = parse_ini_file($file, TRUE)) throw new exception('Unable to open ' . $file . '.');
        // port 3308で接続不可の場合 3306 で接続する
        $dns = $settings[database][driver] .
        ':host=' . $settings[database][host] .
        ((!empty($settings[database][3308])) ? (';port=' . $settings[database][3306]) : '') .
        ';dbname=' . $settings[database][schema];
        // 接続
        parent::__construct($dns, $settings[database][username], $settings[database][password]);
    }
}

// $file = 'C:/xampp/mysql/bin/my.ini';
// $iniFile = parse_ini_file($file, TRUE);
// var_dump($iniFile);
// $iniPath = php_ini_loaded_file();
// var_dump($iniPath);