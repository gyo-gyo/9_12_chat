<?php



// var_dump($_POST);
// exit();

if (
    !isset($_POST['like']) || $_POST['like'] == '' ||
    !isset($_POST['likefood']) || $_POST['likefood'] == ''
) {
    // 項目が入力されていない場合はここでエラーを出力し，以降の処理を中止する
    echo json_encode(["error_msg" => "no input"]);
    exit();
}
$like = $_POST['like'];
$likefood = $_POST['likefood'];

// var_dump($like);
// exit();
$chatroom = '';

if ($like == '1' && $likefood == '1') {
    $chatroom = '1';
} elseif ($like == '1' && $likefood == '2') {
    $chatroom = '2';
} elseif ($like == '2' && $likefood == '1') {
    $chatroom = '3';
} elseif ($like == '2' && $likefood == '2') {
    $chatroom = '4';
};

// var_dump($like, $chatroom, $likefood);
// exit();

$dbn = 'mysql:dbname=gsf_d06_db12;charset=utf8;port=3306;host=localhost';
$user = 'root';
$pwd = '';

try {
    // ここでDB接続処理を実行する
    $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
    // DB接続に失敗した場合はここでエラーを出力し，以降の処理を中止する
    echo json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
}

// データ取得SQL作成
$sql = ' INSERT INTO chat_quest(id,quest1, quest2, RoomNumber, time)              
  VALUES(NULL,:quest1, :quest2, :RoomNumber, sysdate())';



// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':quest1', $like, PDO::PARAM_STR);
$stmt->bindValue(':quest2', $likefood, PDO::PARAM_STR);
$stmt->bindValue(':RoomNumber', $chatroom, PDO::PARAM_STR);
$status = $stmt->execute();

// データ登録処理後
$view = '';
// データ登録処理後
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    exit('sqlError:' . $error[2]);
} else {

    header('');
}
