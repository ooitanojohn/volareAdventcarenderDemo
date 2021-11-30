<?php
/**
 * IMGクラス 基本的には継承で各グローバルクラスから値を
 */
class IMG extends FILES{
    /**
     *画像サイズ比率計算関数 引数 ファイル名 ※1 ,※2
    *@param string $file_name
    *@return array [$img_size,$thumb_width,$thumb_height]
    */
    function ImgSize(){
        //※1 画像サイズを取得 + dir指定
        $img_size = getimagesize('img/' . $this->FILES['file']['name']);
        // ※2 圧縮比率 h×w 100:150 + hxw指定
        if ($img_size[1] / 100 > $img_size[0] / 150) {
            $thumb_width = $img_size[0] / ($img_size[1] / 100);
            $thumb_height = $img_size[1] / ($img_size[1] / 100);
            return [$img_size,intval($thumb_width),intval($thumb_height)];
        } else {
            $thumb_height = $img_size[1] / ($img_size[0] / 150);
            $thumb_width = $img_size[0] / ($img_size[0] / 150);
            return [$img_size,intval($thumb_width),intval($thumb_height)];
        }
    }
    /**
     * サムネイル作成
     * 引数 ファイル名 , 元画像dir, 保存先dir, 画像サイズ
     * @param int $img_size
     * @param int $thumb_width, $thumb_height
     */
    public function imgCompress($img_size,$thumb_width,$thumb_height)
    {
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
                $boolean = Imagegif($img_out, 'img/thumb_' . $this->FILES['file']['name']);
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