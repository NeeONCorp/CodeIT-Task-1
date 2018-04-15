<?php
session_start();

# Полная директория проекта
const ROOT = __DIR__;

require_once (ROOT . '/classes/Autoload.php');

# Front Controller
new Router();
?>