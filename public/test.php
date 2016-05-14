<?php

$dbConnection = new PDO('mysql:host=104.155.196.101;dbname=mydb', 'devUI', 'dev101');

$loginCall =
    $dbConnection->prepare('select  fiscal_year_entity_id, fiscal_year, start_date, end_date, current_fiscal_year from view_org_fiscal_year_detail');

$loginCall->execute();

$test= $loginCall->fetchAll(PDO::FETCH_ASSOC);

$insertCall = $dbConnection->prepare('CALL sproc_org_fiscal_year_dml_ins (:iparam_start_date, :iparam_end_date, :iparam_name, :iparam_current_fiscal_year, :iparam_facility_ids, :iparam_session_id, :iparam_user_id, :iparam_screen_id, :iparam_debug_sproc, :iparam_audit_screen_visit, @oparam_fiscal_year_entity_id, @oparam_err_flag, @oparam_err_step, @oparam_err_msg);');

$insertCall->bindValue(':iparam_start_date', '21.02.2015');
$insertCall->bindValue(':iparam_end_date', '21.02.2015');
$insertCall->bindValue(':iparam_name', 'test');
$insertCall->bindValue(':iparam_current_fiscal_year', '12321321');
$insertCall->bindValue(':iparam_facility_ids', '1, 3, 5');
$insertCall->bindValue(':iparam_session_id', '12');
$insertCall->bindValue(':iparam_user_id', '1');
$insertCall->bindValue(':iparam_screen_id', '2001');
$insertCall->bindValue(':iparam_debug_sproc', '1');
$insertCall->bindValue(':iparam_audit_screen_visit', '1');

$insertCall->execute();

$test2 = $db->query('SELECT @oparam_fiscal_year_entity_id, @oparam_err_flag, @oparam_err_step, @oparam_err_msg')->fetchAll();

$test = 0;
