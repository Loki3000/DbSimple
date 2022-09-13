--TEST--
PostgreSQL: excaping test

--FILE--
<?php
$dirname=__DIR__;
require_once __DIR__ . '/../init.php';

function main(&$DB)
{
	$DB->DbSimple_Postgresql_USE_NATIVE_PHOLDERS = false;
  $DB->query("SET STANDARD_CONFORMING_STRINGS TO OFF");
	printr($DB->query("select ? as a", "aaa\\"), "Result");
}
?>


--SKIPIF--
<?php
if (!is_callable('pg_connect')) print('skip pgsql extension not loaded');
?>


--EXPECT--
Query: 'SET STANDARD_CONFORMING_STRINGS TO OFF'
Query: 'select E\'aaa\\\\\' as a'
Result: array (
  0 => 
  array (
    'a' => 'aaa\\',
  ),
)
