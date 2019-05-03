<?php
/**
 * ===========================================================================================
 * SYSTEM NAME    : DEMOWORK
 * PROGRAM NAME   : システム共通関数定義
 * PROGRAM ID     : common.php
 * DEVELOPED BY   : OSC
 * CREATE DATE    : 2015/04/01
 * ===========================================================================================
 *
 */
ini_set('error_log',BASE_DIR.'log/log.log');

//ini_set('error_log','/var/www/html/esyugyo/log/log.log');

/*
 *-------------------------------------------------------*
 * DATABASE接続
 *-------------------------------------------------------*
*/
function cmDbCon() {
    $con = mysqli_connect(RDB, RDB_USER, RDB_PASSWORD, RDB_DB);
    //$con = mysql_connect(RDB,'a',RDB_PASSWORD);
    //var_dump($con);
    $con->set_charset("utf8");
    return $con;
}
/*
 *-------------------------------------------------------*
 * DATABASE切断
 *-------------------------------------------------------*
*/
function cmDbClose($con) {
    mysqli_close($con);
}
/*
 *-------------------------------------------------------*
 * autocommit
 *-------------------------------------------------------*
*/
function cmDbAutocommit($con, $flag) {
    mysqli_autocommit($con, $flag);
}
/*
 *-------------------------------------------------------*
 * commit
 *-------------------------------------------------------*
*/
function cmDbCommit($con) {
    mysqli_commit($con);
}
/*
 *-------------------------------------------------------*
 * rollback
 *-------------------------------------------------------*
*/
function cmDbRollback($con) {
    mysqli_rollback($con);
}
/*
 *-------------------------------------------------------*
 * db2_query
 *-------------------------------------------------------*
*/
function cmDbQuery($con, $sql, $bindType, $bindParam) {
    $rs = true;
    $stmt = cmDbPrepare($con, $sql);
    if ($stmt === false) {
        $rs = false;
    } else {
        cmDbBind($stmt, $bindType, $bindParam);
        $exe = cmDbExecute($stmt);
        if ($exe === false) {
            $rs = false;
            error_log($sql);
            error_log(print_r($bindParam, true));
            error_log(mysqli_stmt_error($stmt));
        } else {
            $rs = $stmt;
        }
    }
    return $rs;
}
/*
 *-------------------------------------------------------*
 * db2_Bind
 *-------------------------------------------------------*
*/
function cmDbBind($stmt, $bindType, $bindParam) {
    $stmtParams = array();
    $stmtParams[] = $bindType;
    foreach ($bindParam as $k => $v) {
        $stmtParams[] = & $bindParam[$k];
    }
    @call_user_func_array(array($stmt, 'bind_param'), $stmtParams);
}
/*
 *-------------------------------------------------------*
 * db2_Prepare
 *-------------------------------------------------------*
*/
function cmDbPrepare($con, $sql) {
    $stmt = mysqli_prepare($con, $sql);
    if ($stmt === false) {
        error_log('preapreの失敗');
        error_log(mysqli_error($con));
        error_log($sql);
    }
    return $stmt;
}
/*
 *-------------------------------------------------------*
 * db2_execute
 *-------------------------------------------------------*
*/
function cmDbExecute($stmt) {
    $rs = mysqli_execute($stmt);
    if ($rs === false) {
        error_log('execute失敗');
    }
    return $rs;
}
/*
 *-------------------------------------------------------*
 * SELECTSQLを実行 fetch_assocした配列データをリターン
 *-------------------------------------------------------*
*/
function cmFetchAll($con, $sql, $bindType, $bindParam) {
    $array = array();
    $stmt = cmDbQuery($con, $sql, $bindType, $bindParam);
    if ($stmt === false) {
        error_log('queryの失敗');
        error_log($sql);
        error_log($bindType);
        $result = false;
    } else {
        $result = mysqli_stmt_result_metadata($stmt);
        //$result = $stmt->result_metadata();
        $variables = array();
        $data = array();
        while ($field = mysqli_fetch_field($result)) {
            $variables[] = & $data[$field->name];
        }
        @call_user_func_array(array($stmt, 'bind_result'), $variables);
        $array = array();
        $i = 0;
        while (mysqli_stmt_fetch($stmt)) {
            $array[$i] = array();
            foreach ($data as $k => $v) {
                $array[$i][$k] = $v;
            }
            $i++;
        }
    }
    return $array;
}
/*
 *-------------------------------------------------------*
 * 値をJSON形式にしてリターン
 *-------------------------------------------------------*
*/
function je($str) {
    $rs;
    //JSON_HEX_TAG  (すべての < および > をそれぞれ \u003C および \u003E に変換)
    //JSON_HEX_APOS (すべての ' を \u0027 に変換)
    //JSON_HEX_QUOT (すべての " を \u0022 に変換)
    //JSON_HEX_AMP  (すべての & を \u0026 に変換)
    $rs = json_encode($str, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    if ($rs === false) {
        error_log($_SERVER['DOCUMENT_URI']);
    }
    return $rs;
}
/*
 *-------------------------------------------------------*
 * 右トリム
 *-------------------------------------------------------*
*/
function um($str) {
    $bfr = '';
    $aft = $str;
    mb_regex_encoding('UTF-8');
    while ($bfr !== $aft) {
        $bfr = $aft;
        $aft = mb_ereg_replace(" +$", "", $bfr);
        $aft = mb_ereg_replace("　+$", "", $aft);
    }
    return $aft;
}
/*
 *-------------------------------------------------------*
 * 2次元配列をすべて右トリム & フラグに応じてhtmlspecialcharas
 *-------------------------------------------------------*
*/
function umEx($pArray, $hscFlg = false) {
    $rtn = array();
    if (is_array($pArray)) {
        for ($i = 0;$i < count($pArray);$i++) {
            if (is_array($pArray[$i])) {
                $rtn[$i] = array();
                foreach ($pArray[$i] as $key => $val) {
                    if ($hscFlg === true) {
                        $v = htmlspecialchars(um($val), ENT_QUOTES);
                    } else {
                        $v = um($val);
                    }
                    $rtn[$i][$key] = $v;
                }
            }
        }
    }
    return $rtn;
}