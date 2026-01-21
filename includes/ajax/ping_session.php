<?php
require('../../bootstrap.php');
is_ajax();
user_access(true, true);

header('Content-Type: application/json; charset=utf-8');
echo json_encode([
  'sid' => session_id(),
  'cookie_PHPSID' => isset($_COOKIE['PHPSESSID']) ? $_COOKIE['PHPSESSID'] : 'NONE',
  'SESSION_SECRET' => isset($_SESSION['secret']) ? $_SESSION['secret'] : 'NULL',
  'POST_SECRET' => isset($_POST['secret']) ? $_POST['secret'] : 'NULL',
  'time' => date('c'),
], JSON_UNESCAPED_UNICODE);
