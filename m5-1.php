<!DOCTYPE HTML>
<html lang="ja">
    <head><meta charset="UTF-8">
    <title>Mission6-2</title>
</head>
<body>
    <?php
    $dsn = 'mysql:dbname=tb230154db;host=localhost';
    $user = 'tb-230154';
    $password = 'eKBmsEPJYm';
    #MySQLのデータベースに接続
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    #テーブル作成 
    $sql = "CREATE TABLE IF NOT EXISTS `mission6-2`"
    ."("
    ."id INT AUTO_INCREMENT PRIMARY KEY," 
    ."name char(32)," 
    ."comment TEXT," 
    ."date char(32)"
    .");";
    $stmt = $pdo->query($sql);
    
    if($_SERVER['REQUEST_METHOD']=='POST')
    {   
        if(isset($_POST['submit'])) 
        {
            if(empty($_POST['name']) or empty($_POST['comment']) or empty($_POST['pass1']))
            {echo "入力エラー<br>";}
            if(empty($_POST['name']))
            {echo "ー名前を入力してください。<br>";}
            if(empty($_POST['comment']))
            {echo "ーコメントを入力してください。<br>";}
            if(empty($_POST['pass1']))
            {echo "ーパスワードを入力してください。";}
            
        
            if(!empty($_POST["name"]) and !empty($_POST["comment"]))
            {
             
            
            #連想配列
            $name=$_POST["name"];
            $comment=$_POST["comment"];
            $date = date("Y/m/d H:i:s");
            $pass1=$_POST["pass1"];
            
            
                
                if(empty($_POST["editnumber"]))
                {
                
                #データを保存
                $sql = $pdo -> prepare("INSERT INTO `mission6-2` (id, name, comment,date) VALUES(:id, :name, :comment,:date)");
                $sql -> bindParam(':id', $id, PDO::PARAM_INT);
                $sql -> bindParam(':name', $name, PDO::PARAM_STR);        
                $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                $sql -> bindParam(':date', $date, PDO::PARAM_STR);
                $sql -> execute();
                }
                
                #編集実行機能
                else
                {
                    $id=$_POST["editnumber"];
                    
                    $sql = 'UPDATE `mission6-2` set name=:name,comment=:comment,date=:date where id=:id';
                    $stmt = $pdo -> prepare($sql);
                    $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt -> bindParam(':name', $name, PDO::PARAM_STR);
                    $stmt -> bindParam(':comment', $comment, PDO::PARAM_STR);
                    $stmt -> bindParam(':date', $date, PDO::PARAM_STR);
                    $stmt -> execute();
                } 
            }
        }
    }
   if($_SERVER['REQUEST_METHOD']=='POST')
    {   
        if(isset($_POST['deleteb'])) 
        {
            if(empty($_POST['name']) or empty($_POST['comment']) or empty($_POST['pass1']))
            {echo "入力エラー<br>";}
            if(empty($_POST['name']))
            {echo "ー削除番号を入力してください。<br>";}
            if(empty($_POST['pass1']))
            {echo "ーパスワードを入力してください。";} 
    
            if(!empty($_POST["delete"]) and !empty($_POST["pass2"]))
            { 
            $delete=$_POST["delete"];
            $pass2=$_POST["pass2"];
            
            $sql='delete from `mission5-1` where id=:id';
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(':id',$delete,PDO::PARAM_INT);
            $stmt->execute();
            }
        }
    }
        
    #編集選択機能
    if($_SERVER['REQUEST_METHOD']=='POST')
    {   
        if(isset($_POST['editb'])) 
        {
            if(empty($_POST['name']) or empty($_POST['comment']) or empty($_POST['pass1']))
            {echo "入力エラー<br>";}
            if(empty($_POST['comment']))
            {echo "ー編集番号を入力してください。<br>";}
            if(empty($_POST['pass1']))
            {echo "ーパスワードを入力してください。";}
            if(!empty($_POST["edit"]) and !empty($_POST["pass3"]))
            {
                
                
                $edit=$_POST["edit"];
                $pass3=$_POST["pass3"];
                $sql = 'SELECT * FROM `mission5-1`';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                
                foreach ($results as $result)
                {
                    if($result['id'] == $edit)
                    {
                        $editnum = $result['id']; 
                        $editname = $result['name'];
                        $editcom = $result['comment'];
                    }
                }
            }
        }
    }
    ?>
     <form action="" method="POST">
    <h2>【投稿フォーム】</h2>
    <p>名前:<br>
    <input type="text" name="name" placeholder="名前" 
        value="<?php if(!empty($editname)){echo $editname;} ?>"></p>
    <p>コメント:<br>
    <textarea name="comment" rows="5" cols="50" placeholder="コメント" 
        value="<?php if(!empty($editcom)){echo $editcom;} ?>"></textarea></p>
    <p>パスワード:<br>
    <input type="text" name="pass1" placeholder="パスワード" 
        value="<?php if(!empty($editpass)){echo $editpass;} ?>"></p>
    <input type="submit" name="submit">
    <input type="hidden" name="editnumber" 
        value="<?php if(!empty($editnum)){echo $editnum;} ?>">
  
    <h2>【削除フォーム】</h2>
    <p>削除番号:<br>
    <input type="text" name="delete" placeholder="削除対象番号"></p>
    <p>パスワード:<br>
    <input type="text" name="pass2" placeholder="パスワード" ></p>
    <input type="submit" name="deleteb" value="削除">

    <h2>【編集フォーム】</h2>
    <p>編集番号:<br>
    <input type="text" name="edit" placeholder="編集対象番号"></p>
    <p>パスワード:<br>
    <input type="text" name="pass3" placeholder="パスワード" ></p>
    <p><input type="submit" name="editb" value="編集"></p>
    </dl>
    </form>
    
    <?php
    $sql = 'SELECT * FROM `mission6-2`';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();

    foreach ($results as $nawdata)
    {
        #配列の中で使うのはテーブルのカラム名
        echo $nawdata['id']."   ";
        echo "名前：".$nawdata['name']."<br>";
        echo $nawdata['comment']."<br>";
        echo "更新日時：".$nawdata['date'];
        echo "<hr>";
    }
    ?>
</body>
</html>
