<?php
require_once('../Class/Modify.class.php');
use Modifier\Modify;
$modify=new Modify();
$response=$modify->modify();
echo "<pre>";
print_r($response);