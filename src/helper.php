<?php
function println($var) {

		if (PHP_SAPI == 'cli' || (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'curl') !== false)) {
				if (is_scalar($var)) {
						$ret = $var.PHP_EOL;
				} else {
						$ret = print_r($var, true);
				}
		} else {
				$ret = "<pre>";
				$ret .= print_r($var, true);
				$ret .= "</pre>";
		}
		echo $ret;
}
