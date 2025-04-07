<?php
namespace MageeShortcodes\Classes;

class Utils{

    /**
	 * JS & CSS debug
	 *
	 * @since 2.0.0
	 * @access public
	 */
    public static function is_script_debug() {
		return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
	}

	public static function rand_str($prefix = '', $randLength = 6, $addtime = 0, $includenumber = 1) {
		if ($includenumber) {
			$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		} else {
			$chars = 'abcdefghijklmnopqrstuvwxyz';
		}
		$len = strlen($chars);
		$randStr = '';
		for ($i = 0; $i < $randLength; $i++) {
			$randStr .= $chars[mt_rand(0, $len - 1)];
		}
		$tokenvalue = $randStr;
		if ($addtime) {
			$tokenvalue = $randStr . time();
		}
		$tokenvalue = $prefix.$tokenvalue;
		return $tokenvalue;
	}
}