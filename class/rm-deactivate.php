<?php

class RMPluginDeactivate
{
	public static function deactivate() {
		flush_rewrite_rules();
	}
}