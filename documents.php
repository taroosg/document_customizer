<?php

// teams_id受け取る
$team_id = $_GET['team_id'];
$format_id = $_GET['format_id'];

include('utilities.php');
$pdo = connect_to_db();

// 文書名取得
$sql = 'SELECT * FROM formats WHERE id = :format_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':format_id', $format_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

if ($status === false) {
  $error = $stmt->errorInfo();
  exit('sqlError:' . $error[2]);
} else {
  $format_name = $stmt->fetch(PDO::FETCH_ASSOC)['format_name'];
}

// 会社で作成した文書を一覧で表示
$sql = 'SELECT * FROM documents WHERE format_id = :format_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':format_id', $format_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

if ($status === false) {
  $error = $stmt->errorInfo();
  exit('sqlError:' . $error[2]);
} else {
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $tags = implode('', array_map(fn ($value) => "<li><a href='document.php?team_id={$team_id}&document_id={$value['id']}'>{$value['date']}</a></li>", $result));
}

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
  <h1><?= $format_name ?>一覧</h1>
  <a href="formats.php?team_id=<?= $team_id ?>">フォーマット一覧に戻る</a>
  <a href="input_document.php?team_id=<?= $team_id ?>&format_id=<?= $format_id ?>">新規<?= $format_name ?>作成</a>

  <ul>
    <?= $tags ?>
  </ul>

</body>

</html>