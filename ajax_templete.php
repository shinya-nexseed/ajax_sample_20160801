<?php
    $db = mysqli_connect('localhost', 'root', '', 'todo');
    mysqli_set_charset($db, 'utf8');

    $sql = 'SELECT * FROM tasks';

    $tasks = mysqli_query($db, $sql);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8" />
    <title>jQuery & Ajax & PHP Example</title>

    <link rel="stylesheet" href="css/style.css">
    <script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
    <script>
    $(document).ready(function()
    {

        /**
         * 送信ボタンクリック
         */
        $('a').click(function()
        {
            //POSTメソッドで送るデータを定義します var data = {パラメータ名 : 値};
            var id = $(this).attr('id');
            console.log(id);

            var data = {task_id : id};

            /**
             * Ajax通信メソッド
             * @param type  : HTTP通信の種類
             * @param url   : リクエスト送信先のURL
             * @param data  : サーバに送信する値
             */
            $.ajax({
                type: "POST",
                url: "send_templete.php",
                data: data,
                /**
                 * Ajax通信が成功した場合に呼び出されるメソッド
                 */
                success: function(data, dataType)
                {
                    //successのブロック内は、Ajax通信が成功した場合に呼び出される

                    //PHPから返ってきたデータの表示
                    // alert(data);

                    // jsonデータをjsの配列データに変換してvar dataに代入
                    var data = JSON.parse(data);

                    // clickしたinputタグを取得し、スタイルの変更やチェックのon/offを切り替える
                    var element = document.getElementById(data['id']);
                    element.checked = data['completed'];

                    // if (data['completed']) {
                    //     element.nextSibling.classList.add('checked');
                    // } else {
                    //     element.nextSibling.classList.remove('checked');
                    // };

                    element.nextSibling.classList.toggle('checked');
                },
                /**
                 * Ajax通信が失敗した場合に呼び出されるメソッド
                 */
                error: function(XMLHttpRequest, textStatus, errorThrown)
                {
                    //通常はここでtextStatusやerrorThrownの値を見て処理を切り分けるか、単純に通信に失敗した際の処理を記述します。

                    //this;
                    //thisは他のコールバック関数同様にAJAX通信時のオプションを示します。

                    //エラーメッセージの表示
                    alert('Error : ' + errorThrown);
                }
            });

            //サブミット後、ページをリロードしないようにする
            return false;
        });
    });
    </script>
</head>
<body>
    <h1>jQuery & Ajax & PHP Example</h1>
    <form method="post">
        <?php while($task = mysqli_fetch_assoc($tasks)): ?>
            <?php if($task['completed']): // ture (1) だったら ?>
                <input type="checkbox" id="<?php echo $task['id']; ?>" checked="check"><span class="checked"><?php echo $task['title']; ?></span><br>
            <?php else: ?>
                <input type="checkbox" id="<?php echo $task['id']; ?>"><span><?php echo $task['title']; ?></span><br>
            <?php endif; ?>
        <?php endwhile; ?>
    </form>
    <a href="#" id="1">1のタスク更新</a>
</body>
</html>
