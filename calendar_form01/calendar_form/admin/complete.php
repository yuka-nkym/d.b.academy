<?php
	#�ݒ�t�@�C���C���N���[�h
	require_once('./config.php');
		
	$getYm = date('Y-m');
	if(isset($_GET['ym'])){
		$getYm = $_GET['ym'];
	}
	header("Location: ./?mode=complete&ym={$getYm}");
	exit();
