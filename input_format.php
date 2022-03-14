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

  <p>入力typeを選択して追加ボタンをクリックしてください．</p>

  <ul>
    <li>
      <label for="text">
        <input type="radio" id="text" name="parts" value="text">text
      </label>
    </li>
    <li>
      <label for="number">
        <input type="radio" id="number" name="parts" value="number">number
      </label>
    </li>
    <li>
      <label for="date">
        <input type="radio" id="date" name="parts" value="date">date
      </label>
    </li>
    <li>
      <label for="datetime_local">
        <input type="radio" id="datetime_local" name="parts" value="datetime_local">datetime_local
      </label>
    </li>
    <li>
      <label for="select">
        <input type="radio" id="select" name="parts" value="select">select
      </label>
    </li>
    <li>
      <label for="radio">
        <input type="radio" id="radio" name="parts" value="radio">radio
      </label>
    </li>
    <li>
      <label for="textarea">
        <input type="radio" id="textarea" name="parts" value="textarea">textarea
      </label>
    </li>

    <button type="button" id="add_btn">🔽 追加 🔽</button>

  </ul>

  <form action="create_format.php" method="POST" id="form">
    <label for="format_name">
      <p>フォーマット名（必須）</p>
      <input type="text" id="format_name" name="format_name">
    </label>

    <p>🔽 項目リスト 🔽</p>

    <ul id="items">

    </ul>

    <!-- <div>
      <p>種類: <span>text</span></p>
      <input type="hidden" value="text" name="type[]">
      項目名: <input type="text" name="item_name[]">
    </div>

    <label for="items">
      <p>項目名</p>
      <textarea name="items" id="items" cols="30" rows="10"></textarea>
    </label> -->

    <input type="hidden" name="team_id" value="<?= $team_id ?>" />
    <button>送信</button>
  </form>

  <script>
    const types = {
      text: `<li>
          <p>種類: text</p>
          <input type="hidden" value="text" name="type[]">
          項目名: <input type="text" name="item_name[]">
        </li>`,
      number: `<li>
          <p>種類: number</p>
          <input type="hidden" value="number" name="type[]">
          項目名: <input type="text" name="item_name[]">
        </li>`,
      date: `<li>
          <p>種類: date</p>
          <input type="hidden" value="date" name="type[]">
          項目名: <input type="text" name="item_name[]">
        </li>`,
      datetime_local: `<li>
          <p>種類: datetime-local</p>
          <input type="hidden" value="datetime-local" name="type[]">
          項目名: <input type="text" name="item_name[]">
        </li>`,
      select: `<li>
          <p>種類: select</p>
          <input type="hidden" value="select" name="type[]">
          項目名: <input type="text" name="item_name[]">
          <ul class="select_parts"><li><button type="button" class="add_select">🔽 add option 🔽</button></li><ul>
        </li>`,
      radio: `<li>
          <p>種類: radio</p>
          <input type="hidden" value="radio" name="type[]">
          項目名: <input type="text" name="item_name[]">
          <ul class="radio_parts"><li><button type="button" class="add_radio">🔽 add radio 🔽</button></li><ul>
        </li>`,
      textarea: `<li>
          <p>種類: textarea</p>
          <input type="hidden" value="textarea" name="type[]">
          項目名: <input type="text" name="item_name[]">
        </li>`,
      add_select: `<li><input type="text" name="option[]"></li>`,
      add_radio: `<li><input type="text" name="add_radio[]"></li>`,
    };

    const createAppendHtml = (types, type) => {
      const tmpItem = document.createElement('div');
      tmpItem.innerHTML = types[type];
      return tmpItem.childNodes[0];
    }

    document.getElementById("add_btn").addEventListener("click", () => {
      // type種別取得
      const type = document.querySelector('input[name="parts"]:checked').value;

      // HTML要素追加
      const items = document.getElementById("items");
      const appendedItemsResult = items.appendChild(createAppendHtml(types, type));

      // selectとradioの場合は追加イベント設定
      const appendedOptionOrRadio = ['select', 'radio'].includes(type) ? [...document.getElementsByClassName(`add_${type}`)].forEach((x) => x.addEventListener("click", (e) => {
        e.target.closest(`.${type}_parts`).appendChild(createAppendHtml(types, `add_${type}`));
      })) : null;

    });
  </script>

</body>

</html>