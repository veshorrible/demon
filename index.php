<?php
require_once('ResponseDataType.php');
require_once('Sender.php');
require_once('Crypt.php');
const ONE_HOUR = 3600;

while (true) {
    $sender = new Sender();
    $info = $sender->getInfo();
    if ($info->message === '' && $info->key === '') {
        exit();
    }
    $sender->updateInfo((new Crypt)->encode($info->message, $info->key));
    sleep(ONE_HOUR);
}


