<?php

function humanTiming($timestamp) {
	$ci = &get_instance();
    $ci->load->helper('date');

	$timezone_obj = new DateTimeZone('Europe/Skopje');
    $now_date = new DateTime('now', $timezone_obj);
    $now_timestamp = $now_date->getTimestamp();
    $offset = $now_date->getOffset();

    $human_time = timespan($timestamp, $now_timestamp);

    $tmp_final_human = explode(',', $human_time);
    $final_human = 'пред ' . $tmp_final_human[0];
    
    return $final_human;
}

?>