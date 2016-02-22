<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
	$yahoomessageid = "unknown";
	
	if(isset($_GET['yahoomessageid'])) 
	{
		$yahoomessageid = $_GET['yahoomessageid'];
		$link = mysql_connect("localhost", "USERNAME", "PASSWORD") or die(mysql_error());
		mysql_select_db("DATABASE") or die (mysql_error());
		
		$query = "SELECT YahooMessageID, 
						 Subject, 
						 FromUser,
						 RecDate,
						 Message
		FROM archive 
		WHERE YahooMessageID = " . $yahoomessageid;

		$result = mysql_query($query, $link) or die(mysql_error());
		if($row = mysql_fetch_row($result))
		{
			$yahoomessageid = $row[0];
			$subject = $row[1];
			$fromuser = $row[2];
			$recdate = $row[3];
			$message = $row[4];
		}
	}
		
?>
<html>
<head>
<title>MAILINGLISTNAME</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {font-size: 18px}
-->
</style>
</head>

<body>
<table width="100%"  border="0" cellspacing="0" cellpadding="8">
  <tr>
    <td height="20" bgcolor="#FFCC00" class="bold"><span class="style1">Message #<?php echo($yahoomessageid); ?></span></td>
  </tr>
  <tr>
    <td height="20" bgcolor="#FFFFFF" class="softfill">
      <table width="100%"  border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="100">Subject</td>
          <td width="92%" class="bold"><?php echo($subject); ?></td>
        </tr>
        <tr>
          <td>From</td>
          <td class="bold"><?php echo($fromuser); ?></td>
        </tr>
        <tr>
          <td>Date</td>
          <td class="bold"><?php echo($recdate); ?></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td height="600" valign="top" bgcolor="#FFFFFF"><?php echo($message); ?></td>
  </tr>
</table>
</body>
</html>
