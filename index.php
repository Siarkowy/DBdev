<?php

// DBdev (c) 2014 by Siarkowy <siarkowy@siarkowy.net>
// Released under the terms of GNU GPL v3 license.

function __autoload($class) { require_once './class.' . $class . '.php'; }

$app = new Application;
