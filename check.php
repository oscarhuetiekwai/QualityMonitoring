<?php
// Create connection
$con=mysql_connect("localhost","callcenter","ca11c3nt3r","callcenter");

//echo mysqli_errno($con);
$result = mysql_query("SELECT * FROM users");

echo "<table border='1'>
<tr>
<th>test</th>
<th>test</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['userid'] . "</td>";
  echo "<td>" . $row['name'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

?>