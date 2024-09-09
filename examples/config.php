<?php

require '../vendor/autoload.php';

use Dotenv\Dotenv;

// Load the .env file
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


use Tinq\TinqClient;

require_once('../src/TinqClient.php');
// Initialize the TinqClient
$tinq = new TinqClient($_ENV['TINQ_API_KEY']);
