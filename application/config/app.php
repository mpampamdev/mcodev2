<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$json =  json_decode(file_get_contents('application/config/app.cfg'), true);

foreach ($json as $key => $value) {
  $config["$key"] = "$value";
}
