﻿<!DOCTYPE HTML>
<html lang='pl'>
<head>
	<meta  charset="utf-8"/>
	<title>Monster Energy FIM Speedway World Cup 2016</title>
</head>
<body>
	<h1>Monster Energy FIM Speedway World Cup 2016 - Race Off (Manchester)</h1>
	<p>
		[<a href="index.php">Main page</a>]
		[<a href="vojens.php">Event 1 (Vojens)</a>]
		[<a href="vastervik.php">Event 2 (Västervik)</a>]
		[<a href="final.php">Final (Manchester)</a>]
	</p>
	<form>
	<h2>Race Off (Manchester)</h2>
		
<?php
	header('Content-Type: text/html; charset=UTF-8');
	require_once "connect.php";
	
	$connection = new mysqli($host,$db_user,$db_password,$db_name);
	
	if($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno . "Description: ".$connection->connect_error;
	}
		
	$ask_team= "SELECT team,manager FROM teams WHERE semiplace BETWEEN 2 AND 3 ORDER BY rh";
	
	$res=@$connection->query($ask_team);
	
	if($res)
	{
		if($res->num_rows==0) {echo "Semis have not raced";}
		else{
		while($row = $res->fetch_array())
		{
			$team = $row['team'];
			$manager = $row['manager'];
			
			echo "<form>";
			echo "<h3>".$team."</h3>" . "<p> Team Manager: " . $manager."</p>";
			
			$ask_rider = "SELECT riders.name FROM teams,riders WHERE teams.team='$team' AND riders.team=teams.idteam ORDER BY number";
			
			$res1 = @$connection->query($ask_rider);
			if($res1)
			{
				while($row1 = $res1->fetch_array())
				{
					echo $row1['name'];
					echo "<br/>";
				}
			}
			else echo "skopane";
			echo "</form><br />";
			
		}
		}
	}
	else echo "Skopane";
	
	$res->close();
	
			
		
?>
</form>
</body>
</html>