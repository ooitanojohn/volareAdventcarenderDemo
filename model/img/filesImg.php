<?php

/**
 * _FILES を受け取り　プロパティとして保持
 *@param array $FILES
 */
class FILES{
    private array $FILES;
    public function __construct($FILES){
        $this->FILES = $FILES;
    }
    /**
     * ファイルアップロード
     * 引数 $FILESの 一時保存dir 保存先dir+ファイル保存名
     * @return boolean
     */
    public function uploadFile()
    {
        return move_uploaded_file($this->FILES['file']['tmp_name'], 'img/' . $this->FILES['file']['name']);
    }
    /**
     * win sijsにエンコード
     * 引数 グローバル変数$_FILEの[name],変更先の文字コード,変更元の文字コード
     * @return string
     */
    public function jpEncode()
    {
        //日本語に変更
        return mb_convert_encoding($this->FILES['file']['tmp_name'], 'sjis', 'utf8');
    }

    /**
     * サムネイル作成
     * 引数 ファイル名 , 元画像dir, 保存先dir, 画像サイズ
     * @return boolean
     */
    public function imgCompress()
    {
        //◎画像サイズを取得 + dir指定
        $img_size = getimagesize('img/' . $this->FILES['file']['tmp_name'],);
        // 圧縮比率 h×w 100:150 + hxw指定
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
        switch ($ext) {
            case 'jpg':
                $img_in = imagecreatefromjpeg('img/' . $this->FILES['file']['name']);
                break;
            case 'png':
                //◎画像ファイルのコピーおよび画像ファイルの縮小拡大(png)
                $img_in = imagecreatefrompng('img/' . $this->FILES['file']['name']);
                break;
            case 'gif':
                $img_in = imagecreatefromgif('img/' . $this->FILES['file']['name']);
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
        //画像ファイルの書き出し + dir指定
        switch ($ext) {
            case 'jpg':
                $boolean = Imagejpeg($img_out, 'img/thumb_' . $this->FILES['file']['name']);
                break;
            case 'png':
                $boolean = Imagepng($img_out, 'img/thumb_' . $this->FILES['file']['name']);
                break;
            case 'gif':
                $boolean = Imagegif($img_out, 'img/temp/thumb_' . $this->FILES['file']['name']);
                break;
            default:
                break;
        }
        //◎画像加工を行った後は、メモリを開放すること
        ImageDestroy($img_in);
        ImageDestroy($img_out);
        return $boolean;
    }
}






