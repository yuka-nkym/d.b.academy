<?php header("Content-Type:text/html;charset=utf-8"); ?>
<?php
require_once('../admin/config.php');//設定ファイルインクルード（config.phpへの相対パス）※設置箇所が変わる場合は要変更
##-----------------------------------------------------------------------------------------------------------------##
#
#  PHPメールプログラム
#　改造や改変は自己責任で行ってください。
#	
#  今のところ特に問題点はありませんが、不具合等がありましたら下記までご連絡ください。
#  MailAddress: info@php-factory.net
#  name: K.Numata
#  HP: http://www.php-factory.net/
#
##-----------------------------------------------------------------------------------------------------------------##


//----------------------------------------------------------------------
//  関数実行、変数初期化
//----------------------------------------------------------------------
//ご予約日時連結のための再セット
if(isset($_POST["reserv"])){
	$reserv = formPostToConnect($timeArray);
}

//トークンチェック用のセッションスタート
if($useToken == 1 && $confirmDsp == 1){
	session_name('PHPMAILFORMSYSTEM');
	session_start();
}
$encode = "UTF-8";//このファイルの文字コード定義（変更不可）

if($encode == 'SJIS') $_POST = sjisReplace($_POST,$encode);//Shift-JISの場合に誤変換文字の置換実行
$funcRefererCheck = refererCheck($Referer_check,$Referer_check_domain);//リファラチェック実行

//変数初期化
$sendmail = 0;
$empty_flag = 0;
$post_mail = '';
$errm ='';
$header ='';

if($requireCheck == 1) {
	$requireResArray = requireCheck($require);//必須チェック実行し返り値を受け取る
	$errm = $requireResArray['errm'];
	$empty_flag = $requireResArray['empty_flag'];
}
//メールアドレスチェック
if(empty($errm)){
	foreach($_POST as $key=>$val) {
		if($val == "confirm_submit") $sendmail = 1;
		if($key == $Email) $post_mail = calf_h($val);
		if($key == $Email && $mail_check == 1 && !empty($val)){
			if(!checkMail($val)){
				$errm .= "<p class=\"error_messe\">【".$key."】はメールアドレスの形式が正しくありません。</p>\n";
				$empty_flag = 1;
			}
		}
	}
}
if(($confirmDsp == 0 || $sendmail == 1) && $empty_flag != 1){
	
	//トークンチェック（CSRF対策）※確認画面がONの場合のみ実施
	if($useToken == 1 && $confirmDsp == 1){
		if(empty($_SESSION['mailform_token']) || ($_SESSION['mailform_token'] !== $_POST['mailform_token'])){
			exit('ページ遷移が不正です');
		}
		if(isset($_SESSION['mailform_token'])) unset($_SESSION['mailform_token']);//トークン破棄
		if(isset($_POST['mailform_token'])) unset($_POST['mailform_token']);//トークン破棄
	}
	
	
	//差出人に届くメールをセット
	if($remail == 1) {
		$userBody = mailToUser($_POST,$dsp_name,$remail_text,$mailFooterDsp,$mailSignature,$encode);
		$reheader = userHeader($refrom_name,$from,$encode);
		$re_subject = "=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($re_subject,"JIS",$encode))."?=";
	}
	//管理者宛に届くメールをセット
	$adminBody = mailToAdmin($_POST,$subject,$mailFooterDsp,$mailSignature,$encode,$confirmDsp);
	$header = adminHeader($post_mail,$BccMail,$to);
	$subject = "=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($subject,"JIS",$encode))."?=";
	  
	//予約可能数カウントを使用する場合
	if($reservCount == 1){
		//予約データカウント用に日時を保存する（第三引数はデバイスごとのトプページURL）
		mailToReservCountReg($reservFileDir,$reservCountNum,$sp_site_top);
	}
	  
	//-fオプションによるエンベロープFrom（Return-Path）の設定(safe_modeがOFFの場合かつ上記設定がONの場合のみ実施)
	if($use_envelope == 0){
		mail($to,$subject,$adminBody,$header);
		if($remail == 1 && !empty($post_mail)) mail($post_mail,$re_subject,$userBody,$reheader);
	}else{
		mail($to,$subject,$adminBody,$header,'-f'.$from);
		if($remail == 1 && !empty($post_mail)) mail($post_mail,$re_subject,$userBody,$reheader,'-f'.$from);
	}
 
}
else if($confirmDsp == 1){ 

/*　▼▼▼送信確認画面のレイアウト※編集可　オリジナルのデザインも適用可能▼▼▼　*/
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<title>確認画面</title>
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" href="//code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
<script src="//code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="//code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
<style>
/* 自由に編集下さい */
h2{
	background:#333;
	border-radius:6px;
	color:#fff;
	text-align:center;
	padding:2px;
	text-shadow:none;
	font-size:120%;
	margin:3px;
}
#formWrap{
	margin:0 10px;	
}

table.formTable{
	width:100%;
	margin:0 auto;
	border-collapse:collapse;
}
table.formTable td,table.formTable th{
	border:1px solid #ccc;
	padding:10px;
	font-size:12px;
}
table.formTable th{
	width:30%;
	font-weight:normal;
	background:#efefef;
	text-align:left;
}
p.error_messe{
	margin:5px 0;
	color:red;
}
</style>
</head>
<body>
<div id="confirm" data-role="page" data-theme="d">

<!-- ▲ Headerやその他コンテンツなど　※自由に編集可 ▲-->

<!-- ▼************ 送信内容表示部　※編集は自己責任で ************ ▼-->
<div id="formWrap">
<?php if($empty_flag == 1){ ?>
<div align="center">
<h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4>
<?php echo $errm; ?><br /><br /><input type="button" value=" 前画面に戻る " onClick="history.back()">
</div>
<?php }else{ ?>
<h2>確認画面</h2>
<p align="center">以下の内容で間違いがなければ、「送信」ボタンを押してください。</p>
<form action="<?php echo calf_h($_SERVER['SCRIPT_NAME']); ?>" method="POST" data-ajax="false">
<table class="formTable">
<?php echo confirmOutput($_POST);//入力内容を表示?>
</table>
<p align="center"><input type="hidden" name="mail_set" value="confirm_submit">
<input type="hidden" name="confirm_reserv[date]" value="<?php echo (isset($reserv["date"])) ? calf_h($reserv["date"]) : '';?>">
<input type="hidden" name="confirm_reserv[time]" value="<?php echo (isset($reserv["time"])) ? calf_h($reserv["time"]) : '';?>">
<input type="hidden" name="httpReferer" value="<?php echo calf_h(@$_SERVER['HTTP_REFERER']);?>">
<input type="submit" value="　送信　">
<input type="button" value="前画面に戻る" onClick="history.back()"></p>
</form>
<?php calf_copyright();}//削除禁止 ?>
</div><!-- /formWrap -->
<!-- ▲ *********** 送信内容確認部　※編集は自己責任で ************ ▲-->

<!-- ▼ Footerその他コンテンツなど　※編集可 ▼-->
</div>
</body>
</html>
<?php
/* ▲▲▲送信確認画面のレイアウト　※オリジナルのデザインも適用可能▲▲▲　*/
}

if(($jumpPage == 0 && $sendmail == 1) || ($jumpPage == 0 && ($confirmDsp == 0 && $sendmail == 0))) { 

/* ▼▼▼送信完了画面のレイアウト　編集可 ※送信完了後に指定のページに移動しない場合のみ表示▼▼▼　*/
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<title>完了ページ</title>
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" href="//code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css" />
<script src="//code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="//code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
</head>
<body>
<div id="confirm" data-role="page" data-theme="d">
<div align="center">
<?php if($empty_flag == 1){ ?>
<h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4>
<div style="color:red"><?php echo $errm; ?></div>
<br /><br /><input type="button" value=" 前画面に戻る " onClick="history.back()">
</div>
</div>
</body>
</html>
<?php }else{ ?>
ご予約いただきありがとうございます。<br />
ご予約が完了しました。<br /><br />
当日はお気をつけてお越しくださいませ。<br /><br />
<a data-role="button" href="<?php echo $sp_site_top ;?>" rel="external">トップページへ戻る&raquo;</a>
</div>
</div>
<?php calf_copyright(); ?>
<!--  CV率を計測する場合ここにAnalyticsコードを貼り付け -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-1462GGVPBR"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-1462GGVPBR');
</script>
</body>
</html>
<?php 
/* ▲▲▲送信完了画面のレイアウト 編集可 ※送信完了後に指定のページに移動しない場合のみ表示▲▲▲　*/
  }
}
//確認画面無しの場合の表示、指定のページに移動する設定の場合、エラーチェックで問題が無ければ指定ページヘリダイレクト
else if(($jumpPage == 1 && $sendmail == 1) || $confirmDsp == 0) { 
	if($empty_flag == 1){ ?>
<div align="center"><h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4><div style="color:red"><?php echo $errm; ?></div><br /><br /><input type="button" value=" 前画面に戻る " onClick="history.back()"></div>
<?php 
	}else{ header("Location: ".$thanksPageSP); }
}
?>