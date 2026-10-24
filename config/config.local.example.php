<?php
/**
 * Copy this file to config.local.php on the server and fill in the database
 * details from Hostinger hPanel → Databases → MySQL Databases.
 * config.local.php is ignored by git, so the password never reaches GitHub.
 */
return [
    'db' => [
        'host' => 'localhost',
        'name' => 'u123456789_scd',
        'user' => 'u123456789_scd',
        'pass' => 'the-database-password',
    ],
];
