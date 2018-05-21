<?php

use repofor\NewsDumper\Dumper;


(new Dumper($config))->dumpToFile();

$referrer = $_SERVER['HTTP_REFERER'];
header( "Location: $referrer", true, 303 );