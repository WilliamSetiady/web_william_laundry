<?php
$hostname = "localhost";
$hostusername = "root";
$hostpassword = "";
$hostdatabase = "web_william_laundry";
$config = mysqli_connect($hostname, $hostusername, $hostpassword, $hostdatabase);

if (!$config) {
    echo "Connection Failed";
}
