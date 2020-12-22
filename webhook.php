<?php
/*
 * Webhook file for updating server content
 */

echo shell_exec('git pull origin master');
header("Location: /404.php");
