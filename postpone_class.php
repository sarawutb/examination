<?php
date_default_timezone_set("Asia/Bangkok");
include('connect.php');
$sql = "SELECT * FROM `manage_std` WHERE IsUse = 1;";
$result = $conn->query($sql);
$year = date("Y") + 543;

// $sqlstd = "SELECT * FROM `manager_status` WHERE `manager_status`.`id` = 1";
// $result = $conn->query($sqlstd);
// while ($row = $result->fetch_assoc()) {
//     $year_std = $row["year_std"];
// }
$sqlStd = "UPDATE `manager_status` SET `year_std` = $year+1 WHERE `manager_status`.`id` = 1;";
$conn->query($sqlStd);

while ($row = $result->fetch_assoc()) {
    $id_std = $row["id"];
    $degree_std = $row["degree_std"] + 1;
    $section_std = $row["section_std"];

    $sqlUPdegree = "UPDATE `manage_std` SET `year_std` = '$degree_std/$section_std', `degree_std` = '$degree_std' WHERE `manage_std`.`id` = $id_std;";
    $conn->query($sqlUPdegree);
}

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'examination';
$tables = '*';

//Call the core function
//backup_tables($dbhost, $dbuser, $dbpass, $dbname, $tables);

//Core function
function backup_tables($host, $user, $pass, $dbname, $tables = '*')
{
    $link = mysqli_connect($host, $user, $pass, $dbname);

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit;
    }

    mysqli_query($link, "SET NAMES 'utf8'");

    //get all of the tables
    if ($tables == '*') {
        $tables = array();
        $result = mysqli_query($link, 'SHOW TABLES');
        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }
    } else {
        $tables = is_array($tables) ? $tables : explode(',', $tables);
    }

    $return = '';
    //cycle through
    foreach ($tables as $table) {
        $result = mysqli_query($link, 'SELECT * FROM ' . $table);
        $num_fields = mysqli_num_fields($result);
        $num_rows = mysqli_num_rows($result);

        $return .= 'DROP TABLE IF EXISTS ' . $table . ';';
        $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE ' . $table));
        $return .= "\n\n" . $row2[1] . ";\n\n";
        $counter = 1;

        //Over tables
        for ($i = 0; $i < $num_fields; $i++) {   //Over rows
            while ($row = mysqli_fetch_row($result)) {
                if ($counter == 1) {
                    $return .= 'INSERT INTO ' . $table . ' VALUES(';
                } else {
                    $return .= '(';
                }

                //Over fields
                for ($j = 0; $j < $num_fields; $j++) {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = str_replace("\n", "\\n", $row[$j]);
                    if (isset($row[$j])) {
                        $return .= '"' . $row[$j] . '"';
                    } else {
                        $return .= '""';
                    }
                    if ($j < ($num_fields - 1)) {
                        $return .= ',';
                    }
                }

                if ($num_rows == $counter) {
                    $return .= ");\n";
                } else {
                    $return .= "),\n";
                }
                ++$counter;
            }
        }
        $return .= "\n\n\n";
    }
    $time = date('H:i');

    //save file
    $fileName = 'backupdb/db_backup_date' . date('dm') . (date('Y') + 543) . '_time' . date('Hi') . '.sql';
    $handle = fopen($fileName, 'w+');
    fwrite($handle, $return);
    if (fclose($handle)) {
        header('Location:Manager_Std.php');
        die;
    }
}

header('Location:Manager_Std.php');
?>
<!-- <script type="text/javascript">
  history.back()
</script> -->