<?php
$team_id = $_GET['team_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>新規フォーマット作成</h1>

  <a href="formats.php?team_id=<?= $team_id ?>">フォーマット一覧に戻る</a>

  <p>改行区切りで項目を入力してください．</p>

  <form action="create_format.php" method="POST">
    <label for="format_name">
      <p>フォーマット名</p>
      <input type="text" id="format_name" name="format_name">
    </label>

    <label for="items">
      <p>項目名</p>
      <textarea name="items" id="items" cols="30" rows="10"></textarea>
    </label>

    <input type="hidden" name="team_id" value="<?= $team_id ?>" />
    <button>送信</button>
  </form>
</body>

</html>