<?php
//セッションの情報の初期化
session_start();

/*
POSTに値が入っている場合はtrue入っていない場合はfalse
!をつけていない場合は値が入っている場合false入っていない場合true
全ての入力フォームが空でもArray(配列)だけはPOSTの中にある
*/
if(!empty($_POST)){
  //エラー項目の確認
  if($_POST['name'] == ''){
    $error['name'] = 'blank';
  }
  if($_POST['email'] == ''){
    $error['email'] = 'blank';
  }
  if(strlen($_POST['password']) < 4){
    $error['password'] = 'length';
  }
  if($_POST['password'] == ''){
    $error['password'] = 'blank';
  }
  $fileName = $_FILES['image']['name'];
  if(!empty($fileName)){
    //ファイルの名前の後ろから３文字を変数に代入
    $ext = substr($fileName, -3);
    if($ext != 'jpg' && $ext != 'gif'){
      $error['image'] = 'type';
    }
  }

  if(empty($error)){
    //画像アップロード
    $image = date('YmdHis') . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], 'member_picture/' . $image);

    $_SESSION['join'] = $_POST;
    $_SESSION['join']['image'] = $image;
    header('Location: check.php');
    exit();
  }
}

//書き直し
if($_REQUEST['action'] == 'rewrite'){
  $_POST = $_SESSION['join'];
  //画像は再び値を返せないので!emptyで$errorが入るようにしてやる
  $error['rewrite'] = true;
}

 ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet"
  href="css/style.css" type="text/css" />
  <title>snsサンプル</title>
</head>
<body>
<!-- 会員登録ページ -->
<p>次のフォームに必要事項をご記入ください。</p>
<form action="" method="post" enctype="multipart/form-data">
  <dl>
    <dt>ニックネーム<span class="required">必須</span></dt>
    <dd>
      <input type="text" name="name" size="35" maxlength="255"
      value="<?php
      //isset()値が入っている時というif文
      if(isset($_POST['name'])){
      echo htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
      }
      ?>" />
      <?php if($error['name'] == 'blank'): ?>
        <p><span class="error">* ニックネームを入力してください</span></p>
      <?php endif;?>
    </dd>
    <dt>メールアドレス<span class="required">必須</span></dt>
    <dd>
      <input type="text" name="email" size="35" maxlength="255"
      value="<?php
      if(isset($_POST['email'])){
      echo htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
      }
      ?>"/>
      <?php if($error['email'] == 'blank'): ?>
        <p><span class="error">* メールアドレスを入力してください</span></p>
      <?php endif; ?>
    </dd>
    <dt>パスワード<span class="required">必須</span></dt>
    <dd>
      <input type="text" name="password" size="10" maxlength="20"
      value="<?php
      if(isset($_POST['password'])){
      echo htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
      }
       ?>"/>
       <?php if($error['password'] == 'blank'): ?>
         <p><span class="error">* パスワードを入力してください</span></p>
       <?php endif; ?>
       <?php if($error['password'] == 'length'): ?>
         <p><span class="error">* パスワードは４文字以上で入力してください</span></p>
       <?php endif; ?>
    </dd>
    <dt>写真など<dt>
    <dd>
      <input type="file" name="image" size="35" />
      <?php if($error['image'] == 'type'): ?>
        <p><span class="error">* 写真などは「.gif」または「.jpg」の画像を指定してください</span></p>
      <?php endif; ?>
      <?php if(!empty($error)): ?>
        <p><span class="error">* 恐れ入りますが、画像を改めて指定してください</span></p>
      <?php endif; ?>
    </dd>
  </dl>
<div><input type="submit" value="入力内容を確認する" /></div>
</form>
</body>
</html>
