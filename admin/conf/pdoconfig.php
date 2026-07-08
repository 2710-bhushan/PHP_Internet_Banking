<?php
$DB_host = "localhost";
$DB_user = "Bhushan";
$DB_pass = "M@toshree27";
$DB_name = "boi_internetbanking";
try
{
 $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
 $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
 $e->getMessage();
}
