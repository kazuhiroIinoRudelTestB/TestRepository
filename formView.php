<script>

</script>
<?php

$error = "";
$check ;

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
    <link rel="stylesheet" href="./stylesView.css">
</head>
<body>

<header>
    <div class="header-logo-menu">
        <div id="nav-drawer">
            <input id="nav-input" type="checkbox" class="nav-unshown">
            <label id="nav-open" for="nav-input"><span></span></label>
            <label class="nav-unshown" id="nav-close" for="nav-input"></label>
            <div id="nav-content">ハンバーガーテスト</div>
        </div>
        <div class="logo-erea"></div>
        <div id="tabMenu">
           <ul>
               <li id="test_A">testA</li>
               <li id="test_B">testB</li>
               <li id="test_C">testC</li>
           </ul>
            <div class="tabNode" id="tabNode_A">テストAノード</div>
            <div class="tabNode" id="tabNode_B">テストBノード</div>
            <div class="tabNode" id="tabNode_C">テストCノード</div>
        </div>
    </div>
</header>
    <div class="slider_Menu">
        <div class="slider_Space">
            <div class="output_content drop_slider" id="slider_yellow"></div>
            <div class="output_content" id="slider_red"></div>
            <div class="output_content" id="slider_blue"></div>
            <div class="hidden_content" id="slider_green"></div>
            <div class="hidden_content" id="slider_black"></div>
        </div>
        <div class="slider_Controler">
            <div class="slider_operation current_controler" id="slider_left"></div>
            <div class="slider_operation" id="slider_center"></div>
            <div class="slider_operation" id="slider_right"></div>
        </div>


    </div>
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
                print("<div class=\"textdata\">". $row['textdata']. "</div>");
                print("</div>");

         }

        }catch(PDOException $e){
            print('ERROR:'.$e->getMessage());
            die();
        }
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        var sliderSelect = "left";
        $('#tabMenu').find("li").on('click',function(){
            $('#tabMenu').children(".tabNode").removeClass('tab-show');
            $("#tabNode"+$(this).attr('id').replace(/test/,"")).addClass('tab-show');
            $('#tabMenu').find("li").removeClass('tab-active');
            $(this).addClass('tab-active');
        });


        //関数化してリファクタリングする！
        //animateの透過処理を利用してスムーズにフェードアウトさせる！

        //nth-childでslider_Spaceクラスのセレクタをインデックスで指定し、
        //左右に無限スクロールをさせた方がよいかも、、。
        $('#slider_left').on('click',function () {
            //console.log($(".slider_Space:nth-child(3).val());
            if(sliderSelect === "center") {

                $("#slider_yellow").removeClass('hidden_content');
                $("#slider_yellow").addClass('output_content');
                $("#slider_green").fadeOut(400).animate({'left': '20px'});
                $("#slider_yello").fadeIn(400).animate({'right': '20px'});
                $("#slider_green").addClass('hidden_content');
                $("#slider_green").removeClass('output_content');
                $("#slider_center").removeClass('current_controler');
                $("#slider_left").addClass('current_controler');
                sliderSelect = "left";
                console.log(sliderSelect);
            }else if(sliderSelect === "right"){
                $("#slider_yellow").removeClass('hidden_content');
                $("#slider_yellow").addClass('output_content');
                $("#slider_black").fadeOut(400).animate({'left': '20px'});
                $("#slider_yellow").fadeIn(400).animate({'right': '20px'});
                $("#slider_black").addClass('hidden_content');
                $("#slider_black").removeClass('output_content');
                $("#slider_right").removeClass('current_controler');
                $("#slider_left").addClass('current_controler');
                sliderSelect = "left";
                console.log(sliderSelect);
            }
        });

        $('#slider_center').on('click',function () {
            //console.log($(".slider_Space:nth-child(3).val());
            if(sliderSelect === "left") {
                $("#slider_green").removeClass('hidden_content');
                $("#slider_green").addClass('output_content');
                $("#slider_yellow").fadeOut(400).animate({'left': '20px'});
                $("#slider_green").fadeIn(400).animate({'right': '20px'});
                $("#slider_yello").addClass('hidden_content');
                $("#slider_yello").removeClass('output_content');
                $("#slider_left").removeClass('current_controler');
                $("#slider_center").addClass('current_controler');
                sliderSelect = "center";
                console.log(sliderSelect);
            }else if(sliderSelect === "right"){
                $("#slider_red").removeClass('hidden_content');
                $("#slider_red").addClass('output_content');
                $("#slider_black").fadeOut(400).animate({'left': '20px'});
                $("#slider_red").fadeIn(400).animate({'right': '20px'});
                $("#slider_black").addClass('hidden_content');
                $("#slider_black").removeClass('output_content');
                $("#slider_right").removeClass('current_controler');
                $("#slider_center").addClass('current_controler');
                sliderSelect = "center";
                console.log(sliderSelect);
            }
        });

        $('#slider_right').on('click',function () {
            //console.log($(".slider_Space:nth-child(3).val());
            if(sliderSelect === "left") {
                $("#slider_black").removeClass('hidden_content');
                $("#slider_black").addClass('output_content');
                $("#slider_yellow").fadeOut(400).animate({'left': '20px'});
                $("#slider_black").fadeIn(400).animate({'right': '20px'});
                $("#slider_yellow").addClass('hidden_content');
                $("#slider_yellow").removeClass('output_content');
                $("#slider_left").removeClass('current_controler');
                $("#slider_right").addClass('current_controler');

                sliderSelect = "right";
                console.log(sliderSelect);
            }else if(sliderSelect === "center"){
                $("#slider_black").removeClass('hidden_content');
                $("#slider_black").addClass('output_content');
                $("#slider_red").fadeOut(400).animate({'left': '20px'});
                $("#slider_black").fadeIn(400).animate({'right': '20px'});
                $("#slider_red").addClass('hidden_content');
                $("#slider_red").removeClass('output_content');
                $("#slider_center").removeClass('current_controler');
                $("#slider_right").addClass('current_controler');
                sliderSelect = "right";
                console.log(sliderSelect);
            }
        });


    </script>
</body>
</html>
