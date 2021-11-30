<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="css/dist.css"> -->
    <link rel="stylesheet" href="css/import.css">
    <title>upload.php</title>
</head>

<body class="font-sankou ctn w-9/12">
    <header class="ctn py-10 text-4xl">
        <h1 class="font-mono font-size ">課題NO.3</h1>
    </header>
    <main class="ctn h-screen">
        <article class="ctn">
            <h2 class="text-xl pb-5">サムネイル作成</h2>
            <form method="post" enctype="multipart/form-data" class="pb-5">
                <label for="file-L" class="label-gray-700 block pb-3">ファイル選択:</label>
                <input type="file" id="file-L" name="file" class="mt-1 w-9/12 mb-3">
                <label for="msg-L" class="label-gray-700 block pb-3">メッセージ:</label>
                <div class=" mt-1 w-full mb-5">
                    <input type="text" id="msg-L" name="msg" class="w-6/12 mr-3">
                    <button type="submit" name="submit" class="btn">登録</button>
                </div>
            </form>
            <ul class="flex flex-wrap">
                <?php foreach ($imgList as $img) : ?>
                    <li class="px-3 pb-3">
                        <div style="width:150px;height:100px;" class="border flx-cen">
                            <p><img src="img/thumb_<?php echo $img['img'] ?>" alt="写真" height="" width=""></p>
                        </div>
                        <p class="text-center"><?php echo $img['msg'] ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </article>
    </main>
    <footer class="ctn">
        <p class="text-center text-xl divide-gray-700">ph24</p>
    </footer>
</body>

</html>