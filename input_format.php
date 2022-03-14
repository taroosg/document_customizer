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
  <style>
    #main {
      display: flex;
    }

    #button_wrapper {
      display: flex;
      align-items: center;
    }
  </style>
</head>

<body>
  <h1>新規フォーマット作成</h1>

  <a href="formats.php?team_id=<?= $team_id ?>">フォーマット一覧に戻る</a>

  <section id="main">
    <fieldset>
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
          <label for="checkbox">
            <input type="radio" id="checkbox" name="parts" value="checkbox">checkbox
          </label>
        </li>
        <li>
          <label for="textarea">
            <input type="radio" id="textarea" name="parts" value="textarea">textarea
          </label>
        </li>
      </ul>
    </fieldset>

    <div id="button_wrapper">
      <button type="button" id="add_btn">>> 追加 >></button>
    </div>

    <fieldset>
      <form action="create_format.php" method="POST" id="form">
        <label for="format_name">
          <p>フォーマット名（必須）</p>
          <input type="text" id="format_name" name="format_name">
        </label>

        <p>🔽 項目リスト 🔽</p>

        <ul id="items"></ul>

        <input type="hidden" name="team_id" value="<?= $team_id ?>" />
        <button>送信</button>
      </form>
    </fieldset>
  </section>

  <script>
    const types = {
      text: () => `<li>
          <p>種類: text</p>
          <input type="hidden" value="text" name="items[type][]">
          項目名: <input type="text" name="items[item_names][]">
        </li>`,
      number: () => `<li>
          <p>種類: number</p>
          <input type="hidden" value="number" name="items[type][]">
          項目名: <input type="text" name="items[item_names][]">
        </li>`,
      date: () => `<li>
          <p>種類: date</p>
          <input type="hidden" value="date" name="items[type][]">
          項目名: <input type="text" name="items[item_names][]">
        </li>`,
      datetime_local: () => `<li>
          <p>種類: datetime-local</p>
          <input type="hidden" value="datetime-local" name="items[type][]">
          項目名: <input type="text" name="items[item_names][]">
        </li>`,
      select: (number) => `<li>
          <p>種類: select</p>
          <input type="hidden" value="select" name="items[type][]">
          項目名: <input type="text" name="items[item_names][]">
          <ul class="select_parts"><li><button type="button" class="add_select" value=${number}>🔽 add option 🔽</button></li><ul>
        </li>`,
      radio: (number) => `<li>
          <p>種類: radio</p>
          <input type="hidden" value="radio" name="items[type][]">
          項目名: <input type="text" name="items[item_names][]">
          <ul class="radio_parts"><li><button type="button" class="add_radio" value=${number}>🔽 add radio 🔽</button></li><ul>
        </li>`,
      checkbox: (number) => `<li>
          <p>種類: checkbox</p>
          <input type="hidden" value="checkbox" name="items[type][]">
          項目名: <input type="text" name="items[item_names][]">
          <ul class="checkbox_parts"><li><button type="button" class="add_checkbox" value=${number}>🔽 add checkbox 🔽</button></li><ul>
        </li>`,
      textarea: () => `<li>
          <p>種類: textarea</p>
          <input type="hidden" value="textarea" name="items[type][]">
          項目名: <input type="text" name="items[item_names][]">
        </li>`,
      add_select: (selectNumber) => `<li><input type="text" name="options[${selectNumber}][]"></li>`,
      add_radio: (radioNumber) => `<li><input type="text" name="radios[${radioNumber}][]"></li>`,
      add_checkbox: (checkboxNumber) => `<li><input type="text" name="checkboxes[${checkboxNumber}][]"></li>`,
    };

    const createAppendHtml = (types, type, number) => {
      const tmpItem = document.createElement('div');
      console.log(number)
      tmpItem.innerHTML = ['select', 'radio', 'checkbox', 'add_select', 'add_radio', 'add_checkbox'].includes(type) ? types[type](String(number)) : types[type]();
      return tmpItem.childNodes[0];
    }


    document.getElementById("add_btn").addEventListener("click", () => {
      // type種別取得
      const type = document.querySelector('input[name="parts"]:checked').value;

      // HTML要素追加
      const items = document.getElementById("items");
      const appendedItemsResult = ['select', 'radio', 'checkbox'].includes(type) ? items.appendChild(createAppendHtml(types, type, String([...document.getElementsByClassName(`add_${type}`)].length))) : items.appendChild(createAppendHtml(types, type, 0));

      // selectとradioの場合は追加イベント設定
      const appendedOptionOrRadio = ['select', 'radio', 'checkbox'].includes(type) ? [...document.getElementsByClassName(`add_${type}`)].forEach((x) => x.addEventListener("click", (e) => {
        console.log(e.target.value);
        e.target.closest(`.${type}_parts`).appendChild(createAppendHtml(types, `add_${type}`, e.target.value));
      })) : null;



    });
  </script>

</body>

</html>