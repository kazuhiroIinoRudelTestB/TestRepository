<?php

$result = array();

if(isset($_POST["submit"])){


    $contributor_name = $_POST["contributor_name"];
    $title = $_POST["title"];
    $textdata = $_POST["textdata"];
    $error_flag = False;

    if($contributor_name === ""){
        $result['nameNull'] = "お名前が入力されていません";
        $error_flag = True;
    }else if(mb_strlen($contributor_name) > 20){
        $result['nameOver'] = "お名前は20文字以内で書き込んでください";
        $error_flag = True;
    }else if($title === ""){
        $result['titleNull'] = "タイトルが入力されていません";
        $error_flag = True;
    }else if(mb_strlen($title) > 40){
        $result['titleOver'] = "タイトルは40文字以内で書き込んでください";
        $error_flag = True;
    }else if($textdata === ""){
        $result['textdataNull'] = "メッセージが入力されていません";
        $error_flag = True;
    }else if(mb_strlen($textdata) > 140){
        $result['textOver'] = "メッセージは140文字以内で書き込んでください";
        $error_flag = True;
    }

    if($error_flag == False) {
        try {
            $dsn = 'mysql:dbname=rudel_mysql_test;charset=utf8mb4;host=localhost';
            $user = 'root';
            $password = '';

            $pdo = new PDO($dsn,$user,$password);


            $sql = "INSERT INTO `boarddata` (`id`, `contributorname`, `title`, `textdata`, `Contributiondate`)
         VALUES (DEFAULT, '$contributor_name', '$title', '$textdata', CURRENT_TIMESTAMP);";


            $stmt = $pdo->query($sql);

            if ($stmt == false) {
                $result["insertError"] = "投稿に失敗しました。";
                $pdo = NULL;
            } else {
                $result["success"] = "投稿しました。" ;
                $pdo = NULL;
            }


        } catch (PDOException $e) {
            print('ERROR:' . $e->getMessage());
            $result["connectError"] = "データベースの接続に失敗しました。";

        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RudelTest3</title>
</head>
<body>
<h1>掲示板ページ</h1>
<form action="form.php" method="post" >

    <?php
        foreach($result as $result_message){
            print("$result_message<br/>");
        }
    ?>
    お名前:     <input type="text" name="contributor_name" value=""><br/>
    タイトル: <input type="text" name="title" value="">
    <input type="submit" name="submit" value="投稿する">
    <br/>
    メッセージ:   <input type="text" name="textdata" value=""><br/>
</form>
<br/><br/>

<?php
    $dsn = 'mysql:dbname=rudel_mysql_test;charset=utf8mb4;host=localhost';
    $user='root';
    $password = '';

    try{

        $pdo = new PDO($dsn,$user,$password);
        $sql = 'select * from boarddata';
        $stmt = $pdo->query($sql);

        foreach ($stmt as $row){
            print($row['id']."\n");
            print($row['contributorname']."\t");
            print($row['title']."\t");
            print($row['textdata']."\t");
            print($row['Contributiondate']."<br/><br/>");
        }

    }catch(PDOException $e){
        print('ERROR:'.$e->getMessage());
        die();
    }
?>
</body>
</html>
