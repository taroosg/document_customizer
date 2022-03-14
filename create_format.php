<?php
// echo "<pre>";
// var_dump($_POST);
// echo "</pre>";
// exit();

// items: item_name, format_id, type

// item_parts: format_id, item_id, item_value

$format_name = $_POST['format_name'];
$items = $_POST['items'];
$options = $_POST['options'];
$radios = $_POST['radios'];
$checkboxes = $_POST['checkboxes'];
// $items = explode("\r\n", $_POST['items']);
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

foreach ($items['item_names'] as $index => $x) {
  // echo $index . ", " . $x . " type: " . $items['type'][$index] . "\n";
  // itemsの作成
  try {
    $sql = "INSERT INTO items VALUES (NULL, :item_name, :format_id, :type, now(), now())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':item_name', $x, PDO::PARAM_STR);
    $stmt->bindValue(':format_id', $format_id, PDO::PARAM_STR);
    $stmt->bindValue(':type', $items['type'][$index], PDO::PARAM_STR);
    $status = $stmt->execute();
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }

  // item追加の成否判定
  if ($status === false) {
    $error = $stmt->errorInfo();
    exit('sqlError:' . $error[2]);
  } else {
    // selectかradioかcheckboxの場合は別テーブルへインサートする
    if (in_array($items['type'][$index], ['select', 'radio', 'checkbox'], true)) {
      // idを取得
      $item_id = $pdo->lastInsertId();
      // insertする内容でSQL作成，配列は先頭を使用して削除する．
      switch ($items['type'][$index]) {
        case 'select':
          $items_columns = array_map(fn ($value) => "(NULL, '{$format_id}', '{$item_id}', '{$value}', now(), now())", $options[0]);
          array_shift($options);
          break;
        case 'radio':
          $items_columns = array_map(fn ($value) => "(NULL, '{$format_id}', '{$item_id}', '{$value}', now(), now())", $radios[0]);
          array_shift($radios);
          break;
        case 'checkbox':
          $items_columns = array_map(fn ($value) => "(NULL, '{$format_id}', '{$item_id}', '{$value}', now(), now())", $checkboxes[0]);
          array_shift($checkboxes);
          break;
      }
      // if ($items['type'][$index] === 'select') {
      //   $items_columns = array_map(fn ($value) => "(NULL, '{$format_id}', '{$item_id}', '{$value}', now(), now())", $options[0]);
      //   array_shift($options);
      // } else if ($items['type'][$index] === 'radio') {
      //   $items_columns = array_map(fn ($value) => "(NULL, '{$format_id}', '{$item_id}', '{$value}', now(), now())", $radios[0]);
      //   array_shift($radios);
      // }else{
      //   $items_columns = array_map(fn ($value) => "(NULL, '{$format_id}', '{$item_id}', '{$value}', now(), now())", $checkboxes[0]);
      //   array_shift($checkboxes);
      // }
      $sql = 'INSERT INTO item_parts VALUES ';
      $sql .= implode(', ', $items_columns);

      $stmt = $pdo->prepare($sql);
      try {
        $stmt = $pdo->prepare($sql);
        $status = $stmt->execute();
      } catch (PDOException $e) {
        echo json_encode(["sql error" => "{$e->getMessage()}"]);
        exit();
      }
    }
  }
}

// 全部終わったらフォーマット一覧に戻る
header("Location:formats.php?team_id={$team_id}");
exit();
// items作成
// $items_columns = array_map(fn ($value) => "(NULL, '{$value}', '{$format_id}', now(), now())", $items);
// $sql = 'INSERT INTO items VALUES ';
// $sql .= implode(', ', $items_columns);

// $stmt = $pdo->prepare($sql);

// try {
//   $status = $stmt->execute();
// } catch (PDOException $e) {
//   echo json_encode(["sql error" => "{$e->getMessage()}"]);
//   exit();
// }

// if ($status === false) {
//   $error = $stmt->errorInfo();
//   exit('sqlError:' . $error[2]);
// } else {
//   header("Location:formats.php?team_id={$team_id}");
// }
