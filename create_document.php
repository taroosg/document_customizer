<?php

$team_id = $_POST['team_id'];
$format_id = $_POST['format_id'];
$items = explode("\r\n", $_POST['items']);
$document_date = $_POST['document_date'];

include('utilities.php');
$pdo = connect_to_db();

// document作成
$sql = 'INSERT INTO documents VALUES (NULL, :format_id, :document_date, now(), now())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':format_id', $format_id, PDO::PARAM_STR);
$stmt->bindValue(':document_date', $document_date, PDO::PARAM_STR);

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
  $document_id = $pdo->lastInsertId();
}

// data作成
$data = array_filter($_POST, fn ($k) => $k !== 'document_date' && $k !== 'format_id' && $k !== 'team_id', ARRAY_FILTER_USE_KEY);
$optimized_data = array_map(fn ($v) => is_array($v) ? json_encode($v, JSON_UNESCAPED_UNICODE) : $v, $data);
$items_columns = array_map(fn ($k, $v) => "(NULL, '{$document_id}', '{$k}', '{$v}', now(), now())", array_keys($data), array_values($optimized_data));
$sql = 'INSERT INTO data VALUES ';
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
  header("Location:documents.php?team_id={$team_id}&format_id={$format_id}");
}
