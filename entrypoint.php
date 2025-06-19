<?php

require 'vendor/autoload.php';
require 'src/helpers.php';

$item = num(1000000);

echo $item->isOdd();

var_dump($item->sum(1000000)->value());
