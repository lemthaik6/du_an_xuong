<?php
// Quick test script
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "PHP Version: " . phpversion() . "\n";
echo "Testing autoloader...\n";

require 'vendor/autoload.php';
echo "✓ Autoloader loaded\n";

echo "Testing Database class...\n";
try {
    $db = \Src\Database::getInstance();
    echo "✓ Database connected\n";
} catch (Exception $e) {
    echo "✗ Database error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "Testing Models...\n";
try {
    $projectModel = new \App\Models\Project();
    echo "✓ Project model loaded\n";
    
    $taskModel = new \App\Models\Task();
    echo "✓ Task model loaded\n";
    
    $userModel = new \App\Models\User();
    echo "✓ User model loaded\n";
    
    $categoryModel = new \App\Models\Category();
    echo "✓ Category model loaded\n";
    
    $teamModel = new \App\Models\Team();
    echo "✓ Team model loaded\n";
    
} catch (Exception $e) {
    echo "✗ Model error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n✓ All tests passed!\n";
