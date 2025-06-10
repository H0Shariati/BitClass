<?php
defined('site') or die('ACCESS DENIED!');
$link=new mysqli("localhost","root","","bitclass");

if($link===false){
    die("ERROR: Could not connect. ");
}

$link->query("set names utf8");
?>