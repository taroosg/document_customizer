<?php

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
  <table>
    <tbody>
      <tr>
        <td>
          <input type="radio" name="items" value="input_text">
        </td>
        <td>
          <label for="input_text">
            <p>text</p>
            <input type="text" id="input_text" disabled="true">
          </label>
        </td>
      </tr>
      <tr>
        <td>
          <input type="radio" name="items" id="" value="input_date">
        </td>
        <td>
          <label for="input_date">
            <p>date</p>
            <input type="date" name="" id="input_date" disabled="true">
          </label>
        </td>
      </tr>
      <tr>
        <td>
          <input type="radio" name="items" id="" value="input_number">
        </td>
        <td>
          <label for="input_number">
            <p>number</p>
            <input type="number" name="" id="input_number" disabled="true">
          </label>
        </td>
      </tr>
      <tr>
        <td>
          <input type="radio" name="items" id="" value="textarea">
        </td>
        <td>
          <label for="textarea">
            <p>textarea</p>
            <textarea name="" id="textarea" cols="30" rows="10" disabled="true"></textarea>
          </label>
        </td>
      </tr>
    </tbody>
  </table>

  <button type="button" id="add">追加</button>

  <form action="" id="form"></form>

  <script>
    const add = document.getElementById("add");
    const form = document.getElementById("form");

    const htmlData = {
      input_text: '<input type="text" name="" id="input_text">',
      input_date: '<input type="date" name="" id="input_date">',
      input_number: '<input type="number" name="" id="input_number">',
      textarea: '<textarea name="" id="textarea" cols="30" rows="10"></textarea>',
    }

    add.addEventListener("click", () => {
      const value = document.querySelector('input[name="items"]:checked').value;
      const tmpItem = document.createElement('div');
      tmpItem.innerHTML = htmlData[value];
      form.appendChild(tmpItem.childNodes[0]);
    })
  </script>
</body>

</html>