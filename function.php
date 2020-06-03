<?php

function jd($var, $dead = false) {
	echo '<pre style="text-align:left;">' . "\n";
	print_r($var);
	echo "\n</pre>\n";
	if($dead)
		exit;
}

function jdd($v, $isVarExport = FALSE) {
	$_bt = debug_backtrace();
	$bt0 = & $_bt[0];
	jd("{$bt0['file']}: {$bt0['line']}");
	if ($isVarExport) {
		jd(var_export($v, 1));
	} else {
		jd($v);
	}
}

function get($data, $item, $default=NULL) {
    $keys = array_keys((array) $data);
    $str = (string) $item;
    if (in_array($str, $keys, TRUE)) {
        return $data[$item];
    }
    return $default;
}


?>
