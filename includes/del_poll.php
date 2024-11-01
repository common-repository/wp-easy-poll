<?php

$del_poll_code=esc_sql($_POST['del_poll']);
$table_name_question=$wpdb->prefix."poll_question";
    $table_name_answer=$wpdb->prefix."poll_answer";
    $table_result=$wpdb->prefix."poll_answer_result";



$q1=$wpdb->query(
	"
	DELETE FROM $table_name_question WHERE question_uid='$del_poll_code'
	"
);

$q2=$wpdb->query(
	"
	DELETE FROM $table_name_answer WHERE question_id='$del_poll_code'
	"
);

$q3=$wpdb->query(
	"
	DELETE FROM $table_result WHERE question_uid='$del_poll_code'
	"
);



?>