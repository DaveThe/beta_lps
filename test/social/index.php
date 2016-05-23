<?php 
session_start();
include('class/social_login.php');
$s_login = new Social();

//La struttura dati che ritorna (sia FB che GO) è la seguente:

/*
{"id"				:"10207198888076235",
"nickname"			:"Andrea Tiraboschi",
"first_name"		:"Andrea",
"last_name"			:"Tiraboschi",
"gender"			:"m",
"picture"			:"https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xft1/v/t1.0-1/p50x50/11259814_10207074603609201_6818649882215118308_n.jpg?oh=40e5ff060be1873d6b8ad9e37dc41afc&oe=55C09B34&__gda__=1441650813_f7921a735491ded1d6bbcf543832baa2",
"email"				:"antira87@gmail.com",
"type"				:"FB"}

*/

//Con questi dati che ti ritornano, bisogna controllare se già presente su db, a quel punto se si bisogna fare un update dei dati e poi loggare, se no, bisogna inserire l'utente.
/*
*	Penso che la soluzione migliore, sia fare tutto nella classe, poi ne discutiamo al massimo
*/
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Social Login</title>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script>

</head>

<body>
<div onClick="clickBtn();render();" id="customBtn" style="background-color:#E81B1F; color:#FFF; cursor:pointer;">GOOGLE PLUS LOGIN</div>
<br><br>
<div onClick="FBLogin();" style="background-color:#3A74DB; color:#FFF; cursor:pointer;">FACEBOOK LOGIN</div>
<br><br>
<div style="background:#AAA6A6; color: #000000; font-weight:bold;">Dati Utente
<div id="dati_utente"></div>
</div>

<?php /*****PARTE JAVASCRIPT PER FB e GOOGLE*****/ ?>
<?php include('include/fb_inc.php'); ?>
<?php include('include/go_inc.php'); ?>
</body>
</html>