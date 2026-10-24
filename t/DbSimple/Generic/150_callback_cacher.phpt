--TEST--
Generic: callback as cacher (CacherImpl)
--FILE--
<?php
$dirname=__DIR__;
require_once __DIR__ . '/../init.php';

function main(&$DB)
{
	$storage = array();
	$DB->setCacher(function ($key, $value = null) use (&$storage) {
		if (func_num_args() > 1) {
			$storage[$key] = $value;
			return true;
		}
		return isset($storage[$key]) ? $storage[$key] : null;
	});
	$query = "
        -- CACHE: 10
        SELECT * FROM test
        ";
	@$DB->query("DROP TABLE test");
	$DB->query("CREATE TABLE test(id INTEGER, str VARCHAR(1))");
	$DB->query("INSERT INTO test(id, str) VALUES( 1, 'a')");
	printr($DB->selectRow($query));
	$DB->query("UPDATE test SET str='b' WHERE id=1");
	printr($DB->selectRow($query));
	printr(count($storage), "Cached");
}

?>
--EXPECT--
Query: 'DROP TABLE test'
Query: 'CREATE TABLE test(id INTEGER, str VARCHAR(1))'
Query: 'INSERT INTO test(id, str) VALUES( 1, \'a\')'
Query: '
        -- CACHE: 10
        SELECT * FROM test
        '
array (
  'id' => '1',
  'str' => 'a',
)
Query: 'UPDATE test SET str=\'b\' WHERE id=1'
Query: '
        -- CACHE: 10
        SELECT * FROM test
        '
array (
  'id' => '1',
  'str' => 'a',
)
Cached: 1