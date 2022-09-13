--TEST--
Connect to non existed DB
--FILE--
<?php ## Подключение к БД.
require_once __DIR__."/../../../lib/config.php";
require_once "DbSimple/Generic.php";

// Подключаемся к БД.
$DATABASE = DbSimple_Generic::connect('mysqli://test:test@localhost/non-existed-db');

// Устанавливаем обработчик ошибок.
$DATABASE->setErrorHandler('databaseErrorHandler');

// Код обработчика ошибок SQL.
function databaseErrorHandler($message, $info)
{
	// Если использовалась @, ничего не делать.
	if (!error_reporting() || 4437==error_reporting()) return;
	$dir = __DIR__. '/';
	$rpath = str_replace($dir, '', $info['context']);
	echo "Error: ".$info['message']."\n";
	//echo "Context: ".$rpath."\n";
	exit();
}
?>
--EXPECT--
Error: No such file or directory
