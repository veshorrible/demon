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
    $sender->updateInfo(base64_encode(Crypt::code($info->message, $info->key)));
    sleep(ONE_HOUR);
}


