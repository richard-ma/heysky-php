<?php

require_once('./heysky.php');
require_once('./config.php');

# parse post data
$s = $_POST['data'];
$data_array = explode(PHP_EOL, $s);

# load sms template
$template = file_get_contents('./template');

$logFilename = './logs/log';
file_put_contents($logFilename, ""); # clear log file
$log_file_handler = fopen($logFilename, "w+");

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
    print_r($response);
# log
    fwrite($log_file_handler, $da.'|'.$response['mtstat'].'|'.$response['mterrcode']."\n");
}

fclose($log_file_handler);
