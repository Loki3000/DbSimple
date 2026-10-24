--TEST--
PostgreSQL: connect twice even with same DSNs

--FILE--
<?php
$dirname=__DIR__;
require_once __DIR__ . '/../init.php';

function main(&$DB)
{
	global $DSN;
	$db2 = DbSimple_Generic::connect($DSN[0]);
	// PgSql\Connection objects (PHP 8.1+) have no properties, so compare identity
	if ($DB->getLink() !== $db2->getLink()) echo "OK\n";
	else echo "Same link is established for same DSNs\n";
}
?>


--SKIPIF--
<?php
if (!is_callable('pg_connect')) print('skip pgsql extension not loaded');
?>


--EXPECT--
OK
