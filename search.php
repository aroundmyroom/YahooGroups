<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?
	$rowcount = 0;
	$resulthtml = "";
	$where = "";
	$last_msg_number = "unknown";
	$last_msg_date = "unknown";
	$first_msg = "unknown";

	$link = mysql_connect("localhost", "USERNAME", "PASSWORD") or die(mysql_error());
	mysql_select_db("mixfreaks_archief") or die (mysql_error());

	// Get the information of last message
	$query = "SELECT YahooMessageID, RecDate
			FROM archive 
			ORDER BY YahooMessageID desc
			LIMIT 1 ";			
	$result = mysql_query($query, $link) or die(mysql_error());
	if($col = mysql_fetch_row($result))				
	{
//		$last_msg_number = $col[0];
		$last_msg_date = $col[1];
	}

		// Get the information of last message
 
 $query3 = "SELECT Min(archive1.YahooMessageID) AS MinVanYahooMessageID FROM archive ORDER BY Min(archive.YahooMessageID) ";
 $result = mysql_query($query, $link) or die(mysql_error());
 if($col = mysql_fetch_row($result))	

	{
	$first_msg = $col[2];
	}

	$query = "SELECT count(*)
			FROM archive";
	$result = mysql_query($query, $link) or die(mysql_error());
	if($col = mysql_fetch_row($result))				
	{
		$last_msg_number = $col[0];
	}
	
	if(isset($_GET['action']))
	{
		if($_GET['action'] == 1)
		{
			if(isset($_POST['txtDateFrom'])) {
				if(strlen($_POST['txtDateFrom']) > 5) {
					$wheres[]= " RecDate >= '" . $_POST['txtDateFrom'] . "'";
				}
			}
			if(isset($_POST['txtDateTill'])) {
				if(strlen($_POST['txtDateTill']) > 5) {
					$wheres[] = "RecDate <= '" . $_POST['txtDateTill'] . "'";
				}
			}		
			if(isset($_POST['txtMessageID'])) {
				if(strlen($_POST['txtMessageID']) > 0) {
					$wheres[] = "YahooMessageID = '" . $_POST['txtMessageID'] . "'";
				}
			}
			if(isset($_POST['txtUser'])) {
				if(strlen($_POST['txtUser']) > 0) {
					$wheres[] = "FromUser like '%" . $_POST['txtUser'] . "%'";
				}
			}
			if(isset($_POST['txtMessage']))	{
				if(strlen($_POST['txtMessage']) > 0) {
					$wheres[] = "(Subject like '%" . $_POST['txtMessage'] . "%' OR Message like '%" . $_POST['txtMessage'] . "%')";
				}
			}
			if (isset($wheres)) {
  			  foreach($wheres as $w) {
			    if (strlen($where) > 0) {
			      $where .= " AND ";
			    }
			    $where .= $w;
			  }
			}

			if($where <> ""){
				
				$query2 = "SELECT YahooMessageID, 
								 Subject, 
								 FromUser,
								 RecDate
						FROM archive 
						WHERE " . $where . "
						ORDER BY YahooMessageID desc";
	
				$result2 = mysql_query($query2, $link) or die(mysql_error());
				$rowcount = mysql_num_rows($result2);
			}
		}
	}
	
	
?>
<html>
<head>
<title>Mailinglist Name</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css">
</head>
<body> 
<p>&nbsp;</p> 
<form action="search.php?action=1" method="post"> 
  <table width="800" height="100%"  border="0" align="center" cellpadding="8" cellspacing="0" class="maintable"> 
    <tr> 
      <td height="50" valign="top" bgcolor="#FFCC00"> <table width="600"  border="0" cellspacing="0" cellpadding="0"> 
          <tr> 
            <td><img src="header.gif" width="400" height="50"></td> 
          </tr> 
          <tr> 
            <td>Number of messages: <span class="bold"><?php echo($last_msg_number); ?></span></td> 
          </tr> 
          <tr> 
            <td>Last message date: <span class="bold"><?php echo($last_msg_date); ?></span></td> 
          </tr> 
			</table></td> 
    </tr> 
    <tr> 
      <td height="400" valign="top" bgcolor="#FFFFFF"> <h5 class="softfill">Enter search criteria:</h5> 
        <table width="600"  border="0" cellspacing="2" cellpadding="4"> 
          <tr> 
            <td width="171" align="right" class="softfill bold">Subject/Message</td> 
            <td width="413"> <input name="txtMessage" type="text" id="txtMessage" size="50" maxlength="50"> </td> 
          </tr> 
          <tr> 
            <td width="171" align="right" class="softfill bold">User</td> 
            <td width="413"> <input name="txtUser" type="text" id="txtUser" size="50" maxlength="50"> </td> 
          </tr> 
          <tr> 
            <td width="171" align="right" class="softfill bold">Message ID [Number] </td> 
            <td width="413"> <input name="txtMessageID" type="text" id="txtMessageID" size="20" maxlength="8"> </td> 
          </tr> 
          <tr> 
            <td width="171" align="right" class="softfill bold">Date</td> 
            <td width="413"> from
              <input name="txtDateFrom" type="text" id="txtDateFrom" size="15" maxlength="20"> 
              till
              <input name="txtDateTill" type="text" id="txtDateTill" size="15" maxlength="20"> 
              (format <span class="bold">yyyy-mm-dd</span>)</td> 
          </tr> 
          <tr> 
            <td align="right">&nbsp;</td> 
            <td> <input type="hidden" name="txtType" id="txtType" size="1" maxlength="1" value="1"> </td> 
          </tr> 
          <tr> 
            <td align="right">&nbsp;</td> 
            <td> <input type="submit" name="Submit" value="Go!"> 
              <input type="reset" name="Reset" value="Clear"> </td> 
          </tr> 
        </table> 
        <h5 class="softfill"><?php echo($rowcount); ?> query results:</h5> 
        <?//php echo($where); ?> 
        <table width="100%"  border="0" cellspacing="2" cellpadding="2"> 
          <tr bgcolor="#FFCC00" class="bold"> 
            <td width="100" align="right">Message ID</td> 
            <td >Subject</td> 
            <td >From</td> 
            <td width="140">Date</td> 
          </tr> 
          <?php
			if($where <> "") {
				while($row = mysql_fetch_row($result2))
				{
?> 
          <tr class="softfill"> 
            <td align="right"> <? if ($row[0]> 0) {?> 
              <a href="javascript:;" onClick="window.open('http://launch.groups.yahoo.com/group/GROUPNAME/message/<?=$row[0]?>', '', 'width=800, height=600, location=no, menubar=no, scrollbars=yes, resizable=yes, status=yes, toolbar=no');">Yahoo</a>| 
              <?} else { ?> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              <?}?> 
              <a 
href="javascript:;" onClick="window.open('message.php?yahoomessageid=<?=$row[0]?>', '', 'width=800, height=600, location=no, menubar=no, scrollbars=yes, resizable=yes, status=yes, toolbar=no');"> 
              <?=$row[0]?> 
              </a> </td> 
            <td><?=$row[1]?></td> 
            <td><?=$row[2]?></td> 
            <td><?=$row[3]?></td> 
          </tr> 
          <?
				}				

		mysql_close($link);			
		}

?> 
          <!--?php echo($resulthtml); ?--> 
        </table></td> 
    </tr> 
    <tr> 
      <td height="40" align="center" bgcolor="#FFCC00"> Copyright Mixfreaks.nl &copy; 2004 ~ 2012 | <a href="http://www.mixfreaks.nl" target="_blank">www.mixfreaks.nl</a> <br> 
        <center> </td> 
    </tr> 
  </table> 
</form> 
<p>&nbsp;</p> 
</body>
</html>
