


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

            $insertName = $_POST['user_name'];
            $insertTel = $_POST['user_tel'];
            $insertMail = $_POST['user_mail'];


            $sql = "insert into test(id,name,tel,mail,createdate) values(default,'$insertName','$insertTel','$insertMail',default);";

            $stmt = $pdo->query($sql);

            if($stmt==false){
                print"データ登録に失敗しました。";
                $pdo = NULL;
            }else{
                print("データ登録に成功しました。");
            }



/*            $stmt = $pdo->prepare('insert into test (id,name,tel,mail,createdate) values (
                                  default, :name , :tel , :mail ,default)');
            $resultA = $stmt->bindParam(':name',$insertName,PDO::PARAM_STR,255);
            $resultB = $stmt->bindParam(':tel',$insertTel,PDO::PARAM_STR,255);
            $resultC = $stmt->bindParam(':mail',$insertMail,PDO::PARAM_STR,255);

            if($resultA||$resultB||$resultC){
                print("代入に失敗しました。");
                print $stmt->debugDumpParams();
                $pdo = NULL;
                die();
            }


            $result=$stmt->execute();
            if($result) {
                print("登録に成功しました。");
                print $stmt->debugDumpParams();
                $pdo = NULL;
            }else {
                print("登録に失敗しました。");
                print $stmt->debugDumpParams();
                $pdo = NULL;
            }*/
        }catch(PDOException $e){
            print('ERROR:'.$e->getMessage());
            die();
        }
    ?>

    </pre>
    <a href = "memberlist.php">現在の会員情報</a>
</body>
</form>
</body>
</html>
