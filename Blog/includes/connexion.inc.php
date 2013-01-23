<?php
mysql_connect('localhost','root',''); //connexion au serveur BDD
mysql_select_db('blog');	//selection de la BDD
mysql_query("SET NAMES 'utf8'"); 
session_start();

