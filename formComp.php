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

    $error = empty($error) ? formCheck($title,"タイトル","40") : $error;

    $error = empty($error) ? formCheck($textdata,"メッセージ","140") : $error;




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
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <form action="form.php" method="post" >

        <?php

            if(empty($error)){
                print("投稿に成功しました<br/>");
            }else{
                Print("$error<br/>");
            }
        ?>
        <div class="inputFormatText">
            お名前      <input type="text" name="contributor_name" class="nameTextBox" value=""><br/>
            タイトル <input type="text" name="title" class="titleTextBox" value="">
            <input type="submit" name="submit" class="submit" value="投稿する">
            <br/>
            メッセージ<br/>
            <textarea  name="textdata" class="messageTextBox" rows="4" cols="100" value=""></textarea><br/>
        </div>
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
            print("<div class=\"formtextbox\">");
            print("<div class=\"title\">".$row['title'] ." </div>");
            print("<div class=\"otherText\"> 投稿者： </div>");
            print("<div class=\"contributorname\">" . $row['contributorname'] . " </div>");
            print("<div class=\"postedday\">投稿日：" . date('Y/m/d(D) G:i',strtotime($row['Contributiondate']))." </div>");
            print("<div class=\"id_color\">No ". $row['id']. "</div></br>");
            print("<div class=\"postIcon\"><img src=\"./taro.png\" width=\"140\" height=\"140\" ></div>");
            print("<div class=\"\">". $row['textdata']. "</div>");
            print("</div>");

     }

    }catch(PDOException $e){
        print('ERROR:'.$e->getMessage());
        die();
    }
?>
</body>
</html>
