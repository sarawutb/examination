<?php 
include'connect.php';

$sql = "SELECT DISTINCT `year_std` FROM `manage_std` WHERE IsUse = 1;";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
						$year_std = $row['year_std'];
						echo $year_std."<br>";
					}

?>