<?php

/*
Plugin Name: TD Network Admin notice
Description: Set a notification for all users in the network.
Version: 1.0
Author: These Days | Joren Van Hocht
*/

require_once 'AdminNotice.php';

$adminNotice = new AdminNotice();
$adminNotice->init();