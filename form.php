<?php

$error = "";

function formCheck($check_data,$data_name,$dataLenLimit) {

    if($check_data === ""){
        return " $data_name が入力されていません";
    }else if(mb_strlen($check_data) > $dataLenLimit){
        return " $data_name は $dataLenLimit 文字以内で書き込んでください";
    }
}

if(isset($_POST["submit"])){


    $contributor_name = $_POST["contributor_name"];
    $title = $_POST["title"];
    $textdata = $_POST["textdata"];


    $error = formCheck($contributor_name,"お名前","20");
    if(empty($error)){

        $error =  formCheck($title,"タイトル","40");
    }
    if(empty($error)){
        $error = formCheck($textdata,"メッセージ","140");
    }

/*    if($contributor_name === ""){
        $result[] = "お名前が入力されていません";
        $error_flag = True;
    }else if(mb_strlen($contributor_name) > 3){
        $result['nameOver'] = "お名前は20文字以内で書き込んでください";
        $error_flag = True;
    }else if($title === ""){
        $result['titleNull'] = "タイトルが入力されていません";
        $error_flag = True;
    }else if(mb_strlen($title) > 5){
        $result['titleOver'] = "タイトルは40文字以内で書き込んでください";
        $error_flag = True;
    }else if($textdata === ""){
        $result['textdataNull'] = "メッセージが入力されていません";
        $error_flag = True;
    }else if(mb_strlen($textdata) > 5){
        $result['textOver'] = "メッセージは140文字以内で書き込んでください";
        $error_flag = True;
    }*/


    if(empty($error)) {
        try {
            $dsn = 'mysql:dbname=rudel_mysql_test;charset=utf8mb4;host=localhost';
            $user = 'root';
            $password = '';

            $pdo = new PDO($dsn,$user,$password);


            $sql = "INSERT INTO `boarddata` (`id`, `contributorname`, `title`, `textdata`, `Contributiondate`)
         VALUES (DEFAULT, '$contributor_name', '$title', '$textdata', CURRENT_TIMESTAMP);";


            $stmt = $pdo->query($sql);

            if ($stmt == false) {
                $error= "投稿に失敗しました。";
                $pdo = NULL;
            } else {
                $pdo = NULL;
            }


        } catch (PDOException $e) {
            print('ERROR:' . $e->getMessage());
            $error= "投稿に失敗しました";

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

        if(empty($error)){
            print("投稿に成功しました<br/>");
        }else{
            Print("$error<br/>");
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
