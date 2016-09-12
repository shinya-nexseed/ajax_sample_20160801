<?php
    // DBとの接続
    $db = mysqli_connect('localhost', 'root', '', 'todo');
    mysqli_set_charset($db, 'utf8');

    $sql = sprintf('SELECT * FROM tasks WHERE id=%s',
          $_POST['task_id']
      );

    $record = mysqli_query($db, $sql);

    if ($task = mysqli_fetch_assoc($record)) {

        // string型で取得したデータをbool型に変換(キャスト)する
        $completed = (bool)$task['completed']; // true(1) か false(0)

        // 値を反転させる 三項演算子
        // $completed = ($completed == true) ? false : true;
        $completed = !$completed;

        $sql = sprintf('UPDATE tasks SET completed=%d WHERE id=%s',
              $completed,
              $task['id']
          );

        mysqli_query($db, $sql);

        $data = array(
              'id' => $task['id'],
              'title' => $task['title'],
              'completed' => $completed
          );

        header("Content-type: text/plain; charset=UTF-8");
        //ここに何かしらの処理を書く（DB登録やファイルへの書き込みなど）

        echo json_encode($data);
    }

?>
