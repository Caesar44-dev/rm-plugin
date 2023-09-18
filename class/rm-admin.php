<?php

class AdminCallbacks extends RMPlugin
{
    public function home()
    {
        return require_once("$this->plugin_path/templates/home.php");
    }

    public function importexcel()
    {
        return require_once("$this->plugin_path/templates/importexcel.php");
    }
}
