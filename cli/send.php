<?php

function msg($msg) {
    print $msg;
    fwrite($log_file_handler, $msg);
}

require_once('../heysky.php');
require_once('../config.php');

$logFilename = './log';
file_put_contents($logFilename, ""); # clear log file
$log_file_handler = fopen($logFilename, "w+");

# parse data
$s = file_get_contents('../data');
$data_array = explode(PHP_EOL, $s);

$record_total = count($data_array);
$send_success_counter = 0;

# load sms template
$template = str_replace(PHP_EOL, '', file_get_contents('../template'));

foreach ($data_array as $data) {
    $rec = explode('|', $data);
    $da = $rec[0];
    #print_r($dc);

# add sms template
    $sm = $template;
    $sm = str_replace('<text1>', $rec[1], $sm);
    $sm = str_replace('<text2>', $rec[2], $sm);
    $sm = str_replace('<text3>', $rec[3], $sm);

    #print_r($sm);

# send
    $api = new Heysky($heysky_username, $heysky_password);
    $response = $api->sendMessage($da, $sm);
    #print_r($response);
# log
    if ($response['mtstat'] == "ACCEPTD") $send_success_counter += 1;
    msg($da.'|'.$response['mtstat'].'|'.$response['mterrcode']."\n");
}

msg("\n");
msg("All messages have been sent.\n");
msg("Total: ".$record_total." Success: ".$send_success_counter." Failed: ".($record_total - $send_success_counter)."\n");

fclose($log_file_handler);
