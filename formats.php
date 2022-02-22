<?php

// teams_id受け取る
$team_id = $_GET['team_id'];

include('utilities.php');
$pdo = connect_to_db();

// 会社で作成した文書を一覧で表示
$sql = 'SELECT * FROM formats WHERE team_id = :team_id  ORDER BY created_at DESC';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':team_id', $team_id, PDO::PARAM_STR);

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
  $tags = implode('', array_map(fn ($value) => "<li><a href='documents.php?team_id={$team_id}&format_id={$value['id']}'>{$value['format_name']}</a></li>", $result));
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
  <h1>文書フォーマット一覧</h1>

  <a href="teams.php">企業一覧に戻る</a>

  <a href="input_format.php?team_id=<?= $team_id ?>">新規フォーマット作成</a>

  <ul>
    <?= $tags ?>
  </ul>

</body>

</html>