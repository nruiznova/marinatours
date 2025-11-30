<?php

if ($_SERVER['SERVER_NAME'] === 'localhost') {
    return require 'config.local.php';
} else {
    return require 'config.prod.php';
}