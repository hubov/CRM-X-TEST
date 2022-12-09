<?php

$NS = MODULES_NS.'Importer\Http\Controllers\\';

$router->resource('importer.', $NS.'ImporterController');

$router->get('importer', $NS.'ImporterController@index');
