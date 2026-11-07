<?php
echo "<h3>Folder Structure Test</h3>";
echo "Current file: " . __FILE__ . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";

// Check paths
$paths = [
    'assets/images/founder/' => __DIR__ . '/assets/images/founder/',
    '../assets/images/founder/' => dirname(__DIR__) . '/assets/images/founder/',
    '../../assets/images/founder/' => dirname(dirname(__DIR__)) . '/assets/images/founder/',
];

foreach ($paths as $web => $physical) {
    echo "<br><strong>Testing:</strong> $web<br>";
    echo "Physical: $physical<br>";
    echo "Exists: " . (file_exists($physical) ? 'YES' : 'NO') . "<br>";
    echo "Writable: " . (is_writable($physical) ? 'YES' : 'NO') . "<br>";
}

// Test URL structure
echo "<br><h4>Test URLs:</h4>";
echo '<a href="/assets/images/founder/test.jpg">/assets/images/founder/test.jpg</a><br>';
echo '<a href="/core/public/assets/images/founder/test.jpg">/core/public/assets/images/founder/test.jpg</a><br>';
echo '<a href="/public/assets/images/founder/test.jpg">/public/assets/images/founder/test.jpg</a><br>';
?>