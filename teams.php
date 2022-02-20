<?php

include('utilities.php');
$pdo = connect_to_db();

$sql = 'SELECT * FROM teams';
$stmt = $pdo->prepare($sql);

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
  $tags = implode('', array_map(fn ($value) => "<li><a href='formats.php?team_id={$value['id']}'>{$value['name']}</a></li>", $result));
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
  <h1>企業一覧</h1>

  <a href="index.php">トップに戻る</a>

  <ul>
    <?= $tags ?>
  </ul>
</body>

</html>