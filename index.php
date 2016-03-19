<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Чат</title>
        <meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="chat.css">
		<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.2.1.min.js"></script>
    </head>
 
    <body>
		<section><p id="Output">Исторя сообщений пустая<p></section>
		
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<input type="text" name="nickname" placeholder="Ник" id="Nickname">
		<input type="text" name="message" placeholder="Сообщение" id="Message">
			 <input type="submit" value="Отправить" id="Send">
		 </form>
		 
<?php


$nickname = $message = "";
// if submit pressed
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if($_POST["nickname"] != ""
   	&& $_POST["message"] != ""
	&& strlen ($_POST["nickname"]) < 30
	&& strlen ($_POST["message"]) < 7000){
		$nickname = InputSequrity($_POST["nickname"]);
		$message = InputSequrity($_POST["message"]);
	  
		AddMessageToLog( $nickname . ": " . $message);
		$nickname = $message = "";
	}
 }

function InputSequrity($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
 }
// $message - string
function AddMessageToLog($message) {
	$file = fopen("/home/dgodovanets/data/www/dgodovanets.shpp.me/chat/log.json", "r");
	$log = json_decode(fgets($file, 99999));
	fclose($file);
	
	$log->m10 = $log->m9;
	$log->m9 = $log->m8;
	$log->m8 = $log->m7;
	$log->m7 = $log->m6;
	$log->m6 = $log->m5;
	$log->m5 = $log->m4;
	$log->m4 = $log->m3;
	$log->m3 = $log->m2;
	$log->m2 = $log->m1;
	$log->m1 = $message;
	
	$file = fopen("/home/dgodovanets/data/www/dgodovanets.shpp.me/chat/log.json", "w");
	fputs($file, json_encode($log));
	fclose($file);
	return true;
}

?>

<script>
$(document).ready(function(){
	LoadHistory();
});

$(document).ready(function(){
	setInterval(function(){
		LoadHistory();
	}, 1000);
});

function LoadHistory(){
	$.getJSON("log.json", function(data){
		document.getElementById('Output').innerHTML = data.m10.concat("<br>");
		document.getElementById('Output').innerHTML += data.m9.concat("<br>"); 
		document.getElementById('Output').innerHTML += data.m8.concat("<br>"); 
		document.getElementById('Output').innerHTML += data.m7.concat("<br>"); 
		document.getElementById('Output').innerHTML += data.m6.concat("<br>"); 
		document.getElementById('Output').innerHTML += data.m5.concat("<br>"); 
		document.getElementById('Output').innerHTML += data.m4.concat("<br>"); 
		document.getElementById('Output').innerHTML += data.m3.concat("<br>"); 
		document.getElementById('Output').innerHTML += data.m2.concat("<br>"); 
		document.getElementById('Output').innerHTML += data.m1.concat("<br>");
		});
}
</script>

    </body>
</html>