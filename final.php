﻿<!DOCTYPE HTML>
<html lang='pl'>
<head>
	<meta  charset="utf-8"/>
	<title>Monster Energy FIM Speedway World Cup 2016</title>
	<script type="text/javascript">
// <![CDATA[
function flash(id, kolor, czas, kolor2, czas2)
{
	document.getElementById(id).style.color = kolor;
	setTimeout('flash("' + id + '","' + kolor2 + '",' + czas2 + ',"' + kolor + '",' + czas + ')', czas);
}
// ]]>
</script>
</head>
<body>
	<h2>Monster Energy FIM Speedway World Cup 2016 - Final (Manchester)</h2>
	
	<p>
		[<a href="index.php">Main page</a>]
		[<a href="vojens.php">Event 1 (Vojens)</a>]
		[<a href="vastervik.php">Event 2 (Västervik)</a>]
		[<a href="raceoff.php">Race Off (Manchester)</a>]
	</p><b>Final (Manchester)</b> [<a href="complete.php">Complete results</a>] </h3>
	
	<form style='font-family: monospace' >
	<font size=4>
<?php
	
	require_once "connect.php";
	
	$connection = new mysqli($host,$db_user,$db_password,$db_name);
	mysqli_set_charset($connection, "utf8");
	
	$venue="final";
	
	if($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno . "Description: ".$connection->connect_error;
	}
	
	$ask_team= "SELECT team,manager FROM teams WHERE (semiplace = 1 OR roplace = 1 OR teams.event = 'Final') ORDER BY fh";
	
	$res=@$connection->query($ask_team);
	
	if($res)
	{
		if($res->num_rows==0) {echo "Semis have not raced";}
		else
		{
			while($row = $res->fetch_array())
			{
				$team = $row['team'];
				$manager = $row['manager'];
				//$color = $row['color'];
				$color="NONE";
				$sumt=0;
			
				$to_sum = "SELECT sum FROM $venue,teams,riders WHERE teams.team='$team' AND riders.team=teams.idteam AND $venue.idrider=riders.idrider";
			
				$res2 = @$connection->query($to_sum);
				if($res2)
				{
					while($row2 = $res2->fetch_array())
					{
						$sumt+=$row2['sum'];
					}
				}
				else echo "skopane1";
			
			
				echo "<h4>".$team." (".$color.") "."<bigger>".$sumt."</bigger></h4>" . "<p> Team Manager: " . $manager."</p>";
			
			
			
				$ask_rider = "SELECT $venue.idrider,riders.name,$venue.number,$venue.points FROM teams,riders,$venue WHERE teams.team='$team' AND riders.team=teams.idteam AND $venue.idrider=riders.idrider AND $venue.number>0 ORDER BY number";
			
				$res1 = @$connection->query($ask_rider);
				if($res1)
				{
					while($row1 = $res1->fetch_array())
					{
						$number=$row1['number'];
						$name=$row1['name'];
						$points=$row1['points'];
						$sumr=0;
						$idr=$row1['idrider'];
					
						for($i=0;$i<strlen($points);$i++)
						{
							if($points[$i]>'0' && $points[$i]<='6') $sumr+=$points[$i];
						}
					
						$update="UPDATE $venue SET sum = '$sumr' WHERE idrider='$idr'";
					
						@$connection->query($update);
					
						printf("%d. %'.-40s %d ",$number,$name,$sumr);
						if(strlen($points)>0)
						{
							printf("(");
							for($i=0;$i<strlen($points)-1;$i++)
							{
								printf("%s,",$points[$i]);
							}
							printf("%s)",$points[$i]);
						}
						echo "</br>";
					
					
					}
				}
				else echo "skopane2";
				echo "<br />";
			
				$updres="UPDATE teams SET semipoints = '$sumt' WHERE team='$team'";		
				@$connection->query($updres);
			
			
			}
				$actualplaces="SELECT team FROM teams WHERE (semiplace = 1 OR roplace = 1 OR teams.event = 'Final') ORDER BY finalpoints DESC, idteam ASC";
				$res3=@$connection->query($actualplaces);
				$place=1;
				$prize1="";
				$prize2="";
				echo "Current results</br>";
				while($row3 = $res3->fetch_array())
				{
					$team=$row3['team'];
					if($place==1) {$prize1="<b>"; $prize2="</b>";}
					else if($place==2 || $place==3) {$prize1="<i>"; $prize2="</i>";}
					else if($place==4) {$prize1=""; $prize2="";}
					printf("%d. %s%s%s</br>",$place,$prize1,$team,$prize2);
					$newplace="UPDATE teams SET finalplace='$place' WHERE team='$team'";
					@$connection->query($newplace);
					$place++;
				}
				
		}
	}
	else {echo "Skopane3";}
			
	$res->close();
	
	
			
/*		
?>
</font>
</form>
</body>
</html><!DOCTYPE HTML>
<html lang='pl'>
<head>
	<meta  charset="utf-8"/>
	<title>Monster Energy FIM Speedway World Cup 2016</title>
</head>
<body>
	<h1>Monster Energy FIM Speedway World Cup 2016 - Final (Manchester)</h1>
	<p>
		[<a href="index.php">Main page</a>]
		[<a href="vojens.php">Event 1 (Vojens)</a>]
		[<a href="vastervik.php">Event 2 (Västervik)</a>]
		[<a href="raceoff.php">Race Off (Manchester)</a>]
	</p>
	<form>
	<h2>Final (Manchester)</h2>
		
<?php
	header('Content-Type: text/html; charset=UTF-8');
	require_once "connect.php";
	
	$connection = new mysqli($host,$db_user,$db_password,$db_name);
	
	if($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno . "Description: ".$connection->connect_error;
	}
		
	$ask_team= "SELECT team,manager FROM teams WHERE semiplace = 1 OR roplace = 1 OR event = 'Final' ORDER BY rh";
	
	$res=@$connection->query($ask_team);
	
	if($res)
	{
		if($res->num_rows==1) {echo "Semis have not raced";}
		else if($res->num_rows==3) {echo "Race Off have not raced";}
		else if($res->num_rows==4) {
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
</html>*/