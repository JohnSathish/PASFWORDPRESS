<?php
/**
 * Database connection diagnostic - DELETE THIS FILE after fixing
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db_name = 'pasfanc';
$db_user = 'root';
$db_pass = '';

echo "<h2>Database Connection Diagnostic</h2>";
echo "<p>Testing connection to database: <strong>$db_name</strong></p>";

if (!extension_loaded('mysqli')) {
    echo "<p style='color:red'><strong>FAIL:</strong> MySQLi extension not loaded. Enable it in php.ini.</p>";
    exit;
}
echo "<p style='color:green'>OK: MySQLi loaded</p>";

$hosts_to_try = array('127.0.0.1', 'localhost', '127.0.0.1:3306', 'localhost:3306');
$working_host = null;

foreach ($hosts_to_try as $host) {
    $link = @mysqli_connect($host, $db_user, $db_pass);
    if ($link) {
        if (mysqli_select_db($link, $db_name)) {
            $working_host = $host;
            mysqli_close($link);
            break;
        }
        mysqli_close($link);
    }
}

if ($working_host) {
    echo "<p style='color:green'><strong>SUCCESS:</strong> Connection works with DB_HOST = '$working_host'</p>";
    echo "<p><strong>Update wp-config.php:</strong> Change <code>define( 'DB_HOST', 'localhost' );</code> to <code>define( 'DB_HOST', '" . esc_html($working_host) . "' );</code></p>";
    echo "<p><a href='index.php'>Go to WordPress</a> | <strong>Delete this file when done!</strong></p>";
} else {
    echo "<p style='color:red'><strong>All connection attempts failed.</strong></p>";
    echo "<p>Last error: " . mysqli_connect_error() . " (Code: " . mysqli_connect_errno() . ")</p>";
    echo "<p><strong>Things to try:</strong></p>";
    echo "<ul>";
    echo "<li>Is MySQL running in XAMPP Control Panel?</li>";
    echo "<li>Does phpMyAdmin use a password? If you log in to phpMyAdmin with a password, add: <code>define( 'DB_PASSWORD', 'your_password' );</code> in wp-config.php</li>";
    echo "<li>Try DB_HOST = '127.0.0.1' in wp-config.php</li>";
    echo "<li>Check MySQL port in XAMPP (default 3306). If different, use '127.0.0.1:PORT'</li>";
    echo "</ul>";
}
