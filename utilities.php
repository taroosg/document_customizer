<?php
include('env.php');

// DB接続
function connect_to_db()
{
  $dbn = dbn();
  $user = user();
  $pwd = pwd();

  try {
    return new PDO($dbn, $user, $pwd);
  } catch (PDOException $e) {
    exit('dbError:' . $e->getMessage());
  }
}
