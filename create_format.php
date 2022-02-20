<?php

$format_name = $_POST['format_name'];
$items = explode("\r\n", $_POST['items']);
$team_id = $_POST['team_id'];

include('utilities.php');
$pdo = connect_to_db();

// format作成
$sql = 'INSERT INTO formats VALUES (NULL, :format_name, :team_id, now(), now())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':format_name', $format_name, PDO::PARAM_STR);
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
  $format_id = $pdo->lastInsertId();
}

// items作成
$items_columns = array_map(fn ($value) => "(NULL, '{$value}', '{$format_id}', now(), now())", $items);
$sql = 'INSERT INTO items VALUES ';
$sql .= implode(', ', $items_columns);

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
  header("Location:formats.php?team_id={$team_id}");
}
