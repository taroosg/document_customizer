<?php
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


$sql = 'SELECT * FROM items WHERE format_id = :format_id';
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
  $tags = implode('', array_map(fn ($value) => "<label for='{$value['id']}'><p>{$value['item_name']}</p><input type='text' id='{$value['id']}' name='{$value['id']}'></label>", $result));
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
  <h1>新規<?= $format_name ?>作成</h1>

  <a href="documents.php?team_id=<?= $team_id ?>&format_id=<?= $format_id ?>"><?= $format_name ?>一覧に戻る</a>

  <p>各項目を入力してください．</p>

  <form action="create_document.php" method="POST">
    <label for="document_date">
      <p>作成日</p>
      <input type="date" id="document_date" name="document_date">
    </label>

    <?= $tags ?>

    <input type="hidden" name="format_id" value="<?= $format_id ?>" />
    <input type="hidden" name="team_id" value="<?= $team_id ?>" />
    <button>送信</button>
  </form>
</body>

</html>