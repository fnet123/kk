<?php
/**
*�������߱༭��PHP��
*
*gently
*2008��2��27�գ��˴θ��½�Ϊ�ִ٣���ӭ����BUG����
*���ͣ�http://www.zendstudio.net/
*
**/
$act=addslashes($_GET['action']);
$type=addslashes($_GET['uploadtype']);
$http_dir="http://".$_SERVER ['HTTP_HOST'].strtolower(substr(dirname($_SERVER['PHP_SELF']),0,-13));
$dir=strtolower(substr(dirname(__FILE__),0,-13));
if($act=='upload'){
	if($type=='attach'){
		$fileType=array('rar','zip','xls','doc');//�����ϴ����ļ�����
	}
	elseif($type=='img'){
		$fileType=array('jpg','gif','bmp','png');
	}
	$upfileDir='CGI/upload/';
	$maxSize=500; //��λ��KB
	$fileExt=substr(strrchr($_FILES['file1']['name'],'.'),1);
	if(!in_array(strtolower($fileExt),$fileType))
		die("<script>alert('�������ϴ������͵��ļ���-808');window.parent.\$('divProcessing').style.display='none';history.back();</script>");
	if($_FILES['file1']['size']> $maxSize*1024)
		die( "<script>alert('�ļ�����');window.parent.\$('divProcessing').style.display='none';history.back();</script>");
	if($_FILES['file1']['error'] !=0)
		die("<script>alert('δ֪�����ļ��ϴ�ʧ�ܣ�');window.parent.$('divProcessing').style.display='none';history.back();</script>");
	$targetDir=$dir.$upfileDir;
	$targetFile=date('Ymd').time().strrchr($_FILES['file1']['name'],'.');
	$realFile=$targetDir.$targetFile;
	if(function_exists('move_uploaded_file')){
		 move_uploaded_file($_FILES['file1']['tmp_name'],$realFile);
	}
	else{
		@copy($_FILES['file1']['tmp_name'],$realFile);
	}
	if($type=='img'){
		die("<script>window.parent.LoadIMG('{$http_dir}{$upfileDir}{$targetFile}');</script>");
	}
	elseif($type=='attach'){
		die("<script>window.parent.LoadAttach('{$http_dir}{$upfileDir}{$targetFile}');</script>");
	}
}

?>