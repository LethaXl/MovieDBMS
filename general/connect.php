<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Establish the connection

$conn = oci_connect('****', '****', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(Host=oracle.scs.ryerson.ca)(Port=1521))(CONNECT_DATA=(SID=orcl)))');

if (!$conn) {
    $m = oci_error();
    echo "Connection failed: " . $m['message'];
}
?>
