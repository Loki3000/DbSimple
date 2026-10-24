--TEST--
Mysqli: BLOB_OBJ attribute
--FILE--
<?php
$dirname=__DIR__;
require_once __DIR__ . '/../init.php';

function main(&$DB)
{
	@$DB->query("DROP TABLE test");
	$DB->query("CREATE TABLE test(id INTEGER, b BLOB)");
	$DB->query("INSERT INTO test(id, b) VALUES(1, ?)", "blob data");
	$row = $DB->selectRow("-- BLOB_OBJ: 1\nSELECT * FROM test");
	printr(get_class($row['b']));
	printr($row['b']->read(4));
	printr($row['b']->length());
}

?>
--EXPECT--
Query: 'DROP TABLE test'
Query: 'CREATE TABLE test(id INTEGER, b BLOB)'
Query: 'INSERT INTO test(id, b) VALUES(1, \'blob data\')'
Query: '-- BLOB_OBJ: 1
SELECT * FROM test'
'DbSimple_Mysqli_Blob'
'blob'
9