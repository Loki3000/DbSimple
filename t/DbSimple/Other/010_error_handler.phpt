--TEST--
Error handler call_user_func
--FILE--
<?php
$dirname=__DIR__;
require_once __DIR__ . '/../init_lasy.php';

function main(&$DB)
{
	$DB->select('error');
}

?>
--EXPECT--
Query: 'error'
Error: 'You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near \'error\' at line 1'
Context: 'Standard input code line 7'
