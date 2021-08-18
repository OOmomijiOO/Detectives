<!DOCTYPE HTML>
<html lang="ja">
    <head><meta charset="UTF-8">
    <title>Mission5-1</title>
</head>
<body>
    <?php
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    #MySQLのデータベースに接続
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    #テーブル作成 
    $sql = "CREATE TABLE IF NOT EXISTS `mission5-1`"
    ."("
    ."id INT AUTO_INCREMENT PRIMARY KEY," 
    ."name char(32)," 
    ."comment TEXT," 
    ."date char(32)"
    .");";
    $stmt = $pdo->query($sql);
    
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
        $sql = $pdo -> prepare("INSERT INTO `mission5-1` (id, name, comment,date) VALUES(:id, :name, :comment,:date)");
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
            
            $sql = 'UPDATE `mission5-1` set name=:name,comment=:comment,date=:date where id=:id';
            $stmt = $pdo -> prepare($sql);
            $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
            $stmt -> bindParam(':name', $name, PDO::PARAM_STR);
            $stmt -> bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt -> bindParam(':date', $date, PDO::PARAM_STR);
            $stmt -> execute();
        } 
    }
    #削除番号が入力された場合
    elseif(!empty($_POST["delete"]) and !empty($_POST["pass2"]))
    { 
        $delete=$_POST["delete"];
        $pass2=$_POST["pass2"];
        
        $sql = 'delete from `mission5-1` where id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $delete, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    #編集選択機能
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

    ?>
     <form action="" method="POST">
    <dl>【投稿フォーム】
    <dt>名前
    :<input type="text" name="name" placeholder="名前" value="<?php if(!empty($editname)){echo $editname;} ?>">
    <dt>コメント
    :<input type="text" name="comment" placeholder="コメント" value="<?php if(!empty($editcom)){echo $editcom;} ?>">
    <dt>パスワード
    :<input type="text" name="pass1" placeholder="パスワード" "<?php if(!empty($editpass)){echo $editpass;} ?>">
    <dt><input type="submit" name="submit">
    <input type="hidden" name="editnumber" value="<?php if(!empty($editnum)){echo $editnum;} ?>">
    <br>
    <dl>【削除フォーム】
    <dt>削除番号
    :<input type="text" name="delete" placeholder="対象削除番号">
    <dt>パスワード
    :<input type="text" name="pass2" placeholder="パスワード" >
    <dt><input type="submit" name="delete" value="削除">
    <br>
    <dl>【編集フォーム】
    <dt>編集番号
    :<input type="text" name="edit" placeholder="編集対象番号">
    <dt>パスワード
    :<input type="text" name="pass3" placeholder="パスワード" >
    <dt><input type="submit" name="submit" value="編集">
    </dl>
    </form>
    
    <?php
    $sql = 'SELECT * FROM `mission5-1`';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();

    foreach ($results as $nawdata)
    {
        #配列の中で使うのはテーブルのカラム名
        echo $nawdata['id'].',';
        echo $nawdata['name'].',';
        echo $nawdata['comment'];
        echo "<hr>";
    }
    ?>
</body>
</html>