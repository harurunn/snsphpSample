<?php
session_start();

if(!isset($_SESSION['join'])){
  header('Location: index.php');
  exit();
}

 ?>
<!-- 入力内容確認ページ -->
<p>記入した内容でいい場合は「登録する」ボタンをクリックしてください</p>
<form action="" method="post">
  <dl>
    <dt>ニックネーム</dt>
    <dd>
      <?php echo htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES, 'UTF-8'); ?>
    </dd>
    <dt>メールアドレス</dt>
    <dd>
      <?php echo htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES, 'UTF-8'); ?>
    </dd>
    <dt>パスワード</dt>
    <dd>
      【表示されません】
    </dd>
    <dt>写真など</dt>
    <dd>
      <img src="member_picture/<?php echo htmlspecialchars(
      $_SESSION['join']['image'], ENT_QUOTES, 'UTF-8');?>" width="100" height="100" alt="" />
    </dd>
  </dl>
  <!--　&laquo«マーク　&nbsp半角スペース　-->
  <div><a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a>
    | <input type="submit" value="登録する" /></div>
</form>
