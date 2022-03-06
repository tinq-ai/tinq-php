<?php

use Tinq\TinqClient;

require_once('../src/TinqClient.php');

$tinq = new Tinq\TinqClient('key-5cfb0b67-9b31-4837-891d-bb69c924792a-6215d15d9489f', 'unm-9b5d9010-08d6-499b-b39f-7d9c7c7052c4-6215d15d948ad');
var_dump($tinq->checkPlagiarism('boulama'));