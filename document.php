<?php

$team_id = $_GET['team_id'];
$document_id = $_GET['document_id'];

include('utilities.php');
$pdo = connect_to_db();

// 文書詳細全部取得
$sql = "SELECT format_id, format_name, team_id, document.document_id, date, item_id, item_name, data_id, data FROM (SELECT formats.id AS format_id, format_name, team_id, documents.id AS document_id, date FROM formats INNER JOIN (SELECT id, format_id, date FROM documents WHERE id=:document_id) AS documents ON formats.id = documents.format_id) AS document LEFT OUTER JOIN (SELECT items.id AS item_id, item_name, data.id AS data_id, document_id, data FROM items INNER JOIN (SELECT * FROM data WHERE document_id=:document_id) AS data ON items.id = data.item_id) AS data ON document.document_id = data.document_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':document_id', $document_id, PDO::PARAM_STR);

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
  $tags = implode('', array_map(fn ($v) => "<h2>{$v['item_name']}</h2><p>{$v['data']}</p>", $result));
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
  <h1><?= $result[0]['format_name'] ?> <?= $result[0]['date'] ?></h1>

  <a href="documents.php?team_id=<?= $team_id ?>&format_id=<?= $result[0]['format_id'] ?>"><?= $result[0]['format_name'] ?>一覧に戻る</a>

  <?= $tags ?>

</body>

</html>