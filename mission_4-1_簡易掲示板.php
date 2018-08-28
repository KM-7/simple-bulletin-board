<html>

<head>
<title>mission4-1</title>
<meta charset="UTF-8">
</head>

<body>

<h1><font color="#191970">簡易掲示板</font></h1>


<?php
//データベースに接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO ($dsn,$user,$password);


//削除機能
if (!empty($_POST['delete']) and !empty($_POST['pass_delete'])){
	$id=$_POST['delete'];
	$deleteP=$_POST['pass_delete'];
	$nm="null";

	$sql="select * from mission4 where id=$id";
	$results=$pdo->query($sql);

		foreach ($results as $row){
			if ($row['password']==$deleteP){
		  	  	$sql="update mission4 set name='$nm'where id=$id";
				$result=$pdo->query($sql);
			}else{
			  echo "パスワードが違います。";
			}
		}
	$stmt = $pdo->query($sql);
}


//編集機能(選択)
//もし編集フォームから値が、パスワード欄からはパスワードが送信されたら編集処理(選択)を行う
if (!empty($_POST['edit']) and !empty($_POST['pass_edit'])){
	$editN=$_POST['edit'];
	$editP=$_POST['pass_edit'];

	$sql="select * from mission4 where id=$editN";
	$results=$pdo->query($sql);

		foreach ($results as $row){
			if ($row['password']==$editP){
		  	  $e_No=$row['id'];
		  	  $en=$row['name'];
		  	  $ec=$row['comment'];
			}else{
			  echo "パスワードが違います。";
			}
		}
$stmt = $pdo->query($sql);
}

//編集機能(実行)
//もし編集中番号が空でないなら編集処理(実行)を行う
if (!empty($_POST['edit_number']) and !empty($_POST['NAME']) and !empty($_POST['comment'])){
  $EN=$_POST['edit_number'];

  $id=$EN;
  $nm=$_POST['NAME'];
  $kome=$_POST['comment'];
  $dt=date("Y/m/d H:i:s");
  $pw=$_POST['password'];
	if (!empty($pw)){
	  $sql="update mission4 set name='$nm',comment='$kome',date='$dt',password='$pw' where id=$EN";
	  $result=$pdo->query($sql);
	}elseif(empty($pw)){
	  echo "パスワードが未入力です。<br />";
	  echo "編集を中止しました。編集対象番号とパスワードの入力からやり直してください。";
	}
}elseif(!empty($_POST['edit_number']) and (empty($_POST['NAME']) or empty($_POST['comment']))){
  echo "名前、もしくはコメントが未入力です。<br />";
  echo "編集を中止しました。編集対象番号とパスワードの入力からやり直してください。";
}

//入力機能
if (!empty($_POST['NAME']) and !empty($_POST['comment']) and !empty($_POST['password']) and empty($_POST['edit_number'])){
	$sql=$pdo->prepare("INSERT INTO mission4 (name,comment,date,password)VALUES(:name,:comment,:date,:password)");

	$sql->bindParam(':name',$name,PDO::PARAM_STR);
	$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
	$sql->bindParam(':date',$date,PDO::PARAM_STR);
	$sql->bindParam(':password',$password,PDO::PARAM_STR);


	$name=$_POST['NAME'];
	$comment=$_POST['comment'];
	$date=date("Y/m/d H:i:s");
	$password=$_POST['password'];

	$sql->execute();
}elseif(!empty($_POST['NAME']) and (empty($_POST['comment']) or empty($_POST['password']))){
  echo "コメント、またはパスワードが未入力です。<br />";
  echo "名前、コメント、パスワードの全てを入力したうえで送信してください。";
}elseif(!empty($_POST['comment']) and (empty($_POST['NAME']) or empty($_POST['password']))){
  echo "名前、またはパスワードが未入力です。<br />";
  echo "名前、コメント、パスワードの全てを入力したうえで送信してください。";
}elseif(!empty($_POST['password']) and (empty($_POST['NAME']) or empty($_POST['comment']))){
  echo "名前、またはコメントが未入力です。<br />";
  echo "名前、コメント、パスワードの全てを入力したうえで送信してください。";
}
?>



<form action="mission_4-1.php" method="post">
<input type="text" name="NAME" placeholder="名前" value="<?php echo $en;?>"><br>
<input type="text" name="comment" placeholder="コメント" value="<?php echo $ec;?>"><br>
<input type="text" name="password" placeholder="パスワード">
<input type="submit" value="送信"><br>
<input type="hidden" name="edit_number" value="<?php echo $e_No;?>">
<br>
<input type="text" name="delete" placeholder="削除対象番号"><br>
<input type="text" name="pass_delete"  placeholder="パスワード">
<input type="submit" value="削除"><br>
<br>
<input type="text" name="edit" placeholder="編集対象番号"><br>
<input type="text" name="pass_edit" placeholder="パスワード">
<input type="submit" value="編集">
</form>



<?php
//データベースに再び接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO ($dsn,$user,$password);

//表示機能
	$sql='SELECT*FROM mission4';
	$results=$pdo->query($sql);
	foreach ($results as $row){
		if ($row['name'] == "null"){
		   continue;
		}
	  	  echo $row['id'].',';
	  	  echo $row['name'].',';
	  	  echo $row['comment'].',';
	  	  echo $row['date'].'<br>';
	}

?>

</body>

</html>