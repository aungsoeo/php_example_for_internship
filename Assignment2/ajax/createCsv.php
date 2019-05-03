<?php
/**
 * ===========================================================================================
 * SYSTEM NAME    : FTP
 * PROGRAM NAME   : 一覧表示用Ajax
 * DEVELOPED BY   : OSC
 * CREATE DATE    : 2015/11/27
 * ===========================================================================================
 *
 */
/*
 *-------------------------------------------------------*
 * 外部ファイル読み込み
 *-------------------------------------------------------*
*/
include_once ("../common/webinit.php");
/*
 *-------------------------------------------------------*
 * 在庫一覧検索処理
 *-------------------------------------------------------*
*/
$rtn = 0; //処理フラグ 処理中にエラーが出た場合はfalse
$msg = '';
$data = array(); //SELECTしたデータを代入

//local variable
$data=array();
//DB接続
$con = cmDbCon();
if ($con === false) {
    $rtn = 1;
    $msg = MSG1;
}

if($rtn===0){
	$r=fnGetPTEST($con);
	if($r["result"]!==true){
		$rtn=1;
		$msg=$r["result"];
	}else{
		$data=$r["data"];
	}
}
//create csv
if($rtn==0){
	$ourFileName=BASE_FILE_PATH."ptest.csv";
	$fp =  fopen($ourFileName, 'w') or die("can't open file");
	foreach ($data as $fields) {
	    fputcsv($fp, $fields);
	}
	fclose($fp);
}
$rtnAry = array(
	'data' => $data,
	"$my_file"=>$my_file
);
echo (je($rtnAry));


//insert function
function fnInsPTEST($con,$id,$name,$year){
	$rs=true;
        $sql = " INSERT INTO ptest VALUES( ?, ?, ?)";
        $param = array($id, $name, $year);
        $r = cmDbQuery($con, $sql, 'ssi', $param);
        if ($r === false) {
            $rs=MSG2;
        }
	return $rs; 
}
//delete function
//update function
function fnUpdPTEST($con,$id,$name,$year){
	$rs=true;
	$sql = " UPDATE ptest SET name=?,year=? ";
	$sql.= " WHERE id=? ";
	$param = array($name, $year,$id);
	$r = cmDbQuery($con, $sql, 'sis', $param);
	if ($r === false) {
		$rs=MSG2;
	}
	return $rs; 
}
//get function
function fnGetPTEST($con){
	$data=array();
	$rs=true;
	$sql =" select * from ptest";
	$param = array();
	$r = cmFetchAll($con,$sql,'',$param);
	if ($r === false) {
		$rs=MSG2;
	}else{
		$data=$r;
	}
	return array("result"=>$rs,"data"=>$data);
}
//get function by id
function fnGetPTEST_ID($con,$id){
	$data=array();
	$rs=true;
	$sql =" SELECT A.* FROM ptest AS A ";
	$sql .=" WHERE A.id=? ";
	$param = array($id);
	$r = cmFetchAll($con, $sql, 's', $param);
	if ($r === false) {
		$rs = MSG2;
	}else{
		$data=$r;
	}
	return array("result"=>$rs,"data"=>$data);
}
