<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RudelTest1</title>
</head>
<body>
<pre>
    <?php
    $dsn = 'mysql:dbname=rudel_mysql_test;charset=utf8mb4;host=localhost';
    $user='root';
    $password = '';

    try{

        $pdo = new PDO($dsn,$user,$password);
        $sql = 'select * from test';
        $stmt = $pdo->query($sql);

        print("ID\t");
        print("名前\t");
        print("電話番号\t");
        print("メール\t");
        print("登録日付\n");

        foreach ($stmt as $row){
         print($row['id']."\t");
         print($row['name']."\t");
         print($row['tel']."\t");
         print($row['mail']."\t");
         print($row['createdate']."\n");

        }



    }catch(PDOException $e){
        print('ERROR:'.$e->getMessage());
        die(); //スクリプトを終了するとリファレンスにあるが、phpの処理のみが終了するのか？
    }

    ?>
</pre>
</body>
</html>
