<?php
$team_id = $_GET['team_id'];
$format_id = $_GET['format_id'];

include('utilities.php');
$pdo = connect_to_db();

// パーツ取得関数
$get_item_parts = function ($item_id) use ($pdo) {
  try {
    $sql = 'SELECT id, item_id, item_value FROM item_parts WHERE item_id = :item_id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':item_id', $item_id, PDO::PARAM_STR);
    $status = $stmt->execute();
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }

  if ($status === false) {
    $error = $stmt->errorInfo();
    exit('sqlError:' . $error[2]);
  } else {
    return  $stmt->fetchAll(PDO::FETCH_ASSOC);
  };
};

// タグ生成関数
$create_input = fn ($x) => "<label for='{$x['id']}'><p>{$x['item_name']}</p><input type='{$x['type']}' id='{$x['id']}' name='{$x['id']}'></label>";
$create_textarea = fn ($x) => "<label for='{$x['id']}'><p>{$x['item_name']}</p><textarea id='{$x['id']}' name='{$x['id']}'></textarea></label>";
$create_radio = function ($x) use ($get_item_parts) {
  $radios = implode('', array_map(fn ($x) => "<li><label for='{$x['id']}'>{$x['item_value']}<input type='radio' name='{$x['item_id']}' value='{$x['item_value']}'></label></li>", $get_item_parts($x['id'])));
  return "<ul><p>{$x['item_name']}</p>{$radios}</ul>";
};
$create_select = function ($x) use ($get_item_parts) {
  $options = implode('', array_map(fn ($x) => "<option value='{$x['item_value']}'>{$x['item_value']}</option>", $get_item_parts($x['id'])));
  return "<label for='{$x['id']}'><p>{$x['item_name']}</p><select id='{$x['id']}' name='{$x['id']}'>{$options}</select></label>";
};

$create_inputs = [
  "textarea" => $create_textarea,
  "radio" => $create_radio,
  "select" => $create_select,
  "text" => $create_input,
  "date" => $create_input,
  "number" => $create_input,
  "datetime-local" => $create_input,
];


// 文書名取得
try {
  $sql = 'SELECT * FROM formats WHERE id = :format_id';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':format_id', $format_id, PDO::PARAM_STR);
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

// 文書コンテンツとtype取得
try {
  $sql = 'SELECT * FROM items WHERE format_id = :format_id';
  // $sql = "SELECT items.id, item_name, format_id, item_types.id AS item_type_id, type FROM items LEFT OUTER JOIN item_types ON items.id = item_types.id WHERE format_id = :format_id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':format_id', $format_id, PDO::PARAM_STR);
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
  // $tags = implode('', array_map(fn ($value) => $value['type'] === 'textarea' ? $create_textarea($value) : $create_input($value), $result));
  $tags = implode('', array_map(fn ($value) => $create_inputs[$value['type']]($value), $result));
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