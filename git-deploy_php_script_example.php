<?php
require_once("config.php");

// get the server path
$_PATH = $_SERVER["DOCUMENT_ROOT"];

// get the theme name
preg_match("/\/([0-9a-z-]+)\.git/", REMOTE_REPOSITORY, $_MATCHES);
$_NAME = $_MATCHES ? $_MATCHES[1] : false;

// verify that settings are configured
if (!$_PATH || !$_NAME) {
    $_ERROR = !$_PATH && $_NAME ? "\$_PATH is" : ($_PATH && !$_NAME ? "\$_NAME is" : "\$_PATH and \$NAME are");
    echo "error! {$_ERROR} not set properly!<br>"; exit;
}

echo "Using \"{$_PATH}\" as website directory...<br>";
echo "Using \"{$_NAME}\" as theme name...<br>";

// clone the repository
if (!exec("/usr/bin/git clone " . REMOTE_REPOSITORY . " " . DIR)) echo "ERROR! Repository was not cloned!<br />";

// generate the symlink
if (!symlink(DIR . "/dist", "{$_PATH}/wp-content/themes/{$_NAME}")) echo "ERROR! Symlink was not created!<br />";

// delete the file
if (!unlink(__FILE__)) echo "ERROR! Delete this file manually!<br>";

echo "initialized!"; exit;
