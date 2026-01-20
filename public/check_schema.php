<?php
// Valid CI4 bootstrap manual
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
chdir(FCPATH);
require __DIR__ . '/../app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

use Config\Services;

$db = Services::database();
$table = 'barang_keluar_jkt';

if ($db->tableExists($table)) {
    echo "Table '$table' exists.\n";
    $fields = $db->getFieldData($table);
    foreach ($fields as $field) {
        echo "- " . $field->name . " (" . $field->type . " " . $field->max_length . ")\n";
    }
} else {
    echo "Table '$table' does NOT exist.\n";
    // Check for other tables
    echo "Tables found:\n";
    $tables = $db->listTables();
    foreach ($tables as $t) {
        echo "- $t\n";
    }
}
