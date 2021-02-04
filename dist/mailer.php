<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  $send = "";
  header("Location: /");
  exit;
}

// 設定
$from = 'sys@eweb.co.jp';
$from_name = 'e-web mail system';
$addAddress = [
  'oshizawa.shinichi@eweb.co.jp'
];
$addCC = [];
$addBCC = [
  'oshizawa.shinichi@eweb.co.jp'
];

// 本番パス
// $path = '/home/eweb';
// localパス
$path = '/Users/e-web/Public';

require $path.'/vendor/autoload.php';
require $path.'/vendor/phpmailer/phpmailer/language/phpmailer.lang-ja.php';

mb_language("japanese");
mb_internal_encoding("UTF-8");
$mail = new PHPMailer(true);
$mail->CharSet = "iso-2022-jp";
$mail->Encoding = "7bit";
$mail->setLanguage('ja', $path.'/vendor/phpmailer/phpmailer/language/');

// conf
require $path.'/mail_sys/conf.php';

// data

$variables = [];
$variables['mail_title'] = "テストメール";
$variables['company_name'] = $_POST['company'];
$variables['name'] = $_POST['name'];
$variables['tel'] = $_POST['tel'];
$variables['postalCode'] = $_POST['postalCode'];
$variables['address'] = $_POST['address'];
$template = file_get_contents('mail_template.html');
foreach($variables as $key => $value) {
  $template = str_replace('{{ '.$key.' }}', $value, $template);
}

try {
  $mail->SMTPDebug = 0;
  // $mail->SMTPDebug = SMTP::DEBUG_SERVER;  // デバグの出力を有効に（テスト環境での検証用）
  $mail->isSMTP();
  $mail->Host       = HOST;
  $mail->SMTPAuth   = true;
  $mail->Username   = USERNAME;
  $mail->Password   = PASSWORD;
  $mail->SMTPSecure = 'tls';
  $mail->Port       = 587;

  $mail->setFrom($from, mb_encode_mimeheader($from_name));
  // $mail->addAddress('someone@xxxx.com', mb_encode_mimeheader("受信者名"));
  foreach ($addAddress as $key => $value) {
    $mail->addAddress($value);
  }
  //返信用アドレス（差出人以外に別途指定する場合）
  // $mail->addReplyTo('info@example.com', mb_encode_mimeheader("お問い合わせ"));
  foreach ($addCC as $key => $value) {
    $mail->addCC($value);
  }
  foreach ($addBCC as $key => $value) {
    $mail->addBCC($value);
  }

  //コンテンツ設定
  $mail->isHTML(true);   // HTML形式を指定
  //メール表題（文字エンコーディングを変換）
  $mail->Subject = mb_encode_mimeheader($variables['mail_title'] );
  //HTML形式の本文（文字エンコーディングを変換）
  $mail->Body  = mb_convert_encoding($template, "JIS", "UTF-8");
  //テキスト形式の本文（文字エンコーディングを変換）
  // $mail->AltBody = mb_convert_encoding('テキストメッセージ',"JIS","UTF-8");

  $mail->send();  //送信
  $send = true;
  require ('index.php');
  // echo 'Message has been sent';
} catch (Exception $e) {
  //エラー（例外：Exception）が発生した場合
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
