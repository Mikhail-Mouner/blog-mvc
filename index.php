<?php
/*
    27
    https://www.youtube.com/playlist?list=PLGO8ntvxgiZPZBHUGED6ItUujXylNGpMH
*/

require __DIR__.'/vendor/System/Application.php';
require __DIR__.'/vendor/System/File.php';

use System\{File,Application};

$file = new File(__DIR__);
$app = new Application($file);


$app->run();

