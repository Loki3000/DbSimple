<?php
chdir($dirname);

error_reporting(-1);

header("Content-type: text/plain");
include_once __DIR__ . "/../../lib/config.php";
ini_set("include_path", ini_get("include_path").PATH_SEPARATOR.__DIR__.'/..'); // for Cache_Lite
include_once "DbSimple/Connect.php";
include_once "DbSimple/Generic.php";  

$DSN = array();

$dsnFile = "dsn.txt";
$dsnOwn = trim(@join("", file($dsnFile)));
if (!$dsnOwn) die("Current directory must contain $dsnFile file!");
if ($dsnOwn == '*' || preg_match('/^\w+$/', $dsnOwn)) {
	$dir = __DIR__;
	$d = opendir($dir);
	while (false !== ($e = readdir($d))) {
		$full = realpath("$dir/$e");
		if ($e == "." || $e == ".." || !is_dir($full) || $full == realpath(getcwd())) continue;
		if ($dsnOwn != '*' && strtolower($e) != strtolower($dsnOwn)) continue;
		$dsn = trim(@join("", file("$full/$dsnFile")));
		if ($dsn) $DSN = array_merge($DSN, preg_split('/\s+/s', $dsn));
	}
} else {
	$DSN[] = $dsnOwn;
}

foreach ($DSN as $dsn) {
    $DB =new DbSimple_Connect($dsn);
    $DB->setLogger('queryLogger');
    $DB->setErrorHandler('errorHandler');
    main($DB);
}

function queryLogger(&$DB, $query)
{
	if (preg_match('/^\s*--\s+(\d|error)/', $query)) return;
	printr($query, "Query");
}

function errorHandler($msg, $error)
{
	if (!error_reporting() || 4437==error_reporting()) return;
	$dir = __DIR__. '/';
	$rpath = str_replace($dir, '', $error['context']);
	printr($error['message'], "Error");
	//printr($rpath, "Context");
}

// Debug human-readable output of any variable.
function printr($value, $comment=null)
{
    if ($comment !== null) echo "$comment: ";
    var_export($value);
    echo "\n";
}
?>
