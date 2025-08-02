<?php
// Test view path
$viewPath = '../app/Views/';
$viewFile = $viewPath . 'home/index.php';

echo "Testing view path...\n";
echo "View path: $viewPath\n";
echo "View file: $viewFile\n";
echo "File exists: " . (file_exists($viewFile) ? 'YES' : 'NO') . "\n";
echo "Current directory: " . getcwd() . "\n";
echo "Absolute path: " . realpath($viewFile) . "\n"; 