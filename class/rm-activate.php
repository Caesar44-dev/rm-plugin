<?php

class RMPluginActivate
{
	public static function activate() {
		flush_rewrite_rules();
	}
}