<?php include("header.php"); ?>
<?php
require_once 'function.php';
$Conn = getConnection();
$db_database = 'pacsdb';
$db_selecct = mysql_select_db($db_database);
if (!$db_selecct) {
    die("could not to the database</br>" . mysql_error());
}
$query = "SELECT (institution), src_aet FROM series ORDER BY created_time DESC limit 800";
$result = mysql_query($query);

echo PHP_EOL . PHP_EOL . PHP_EOL;
$tempArray= array();
while ($result_row = mysql_fetch_assoc($result)) {
    array_push($tempArray, $result_row['institution'] ."::". $result_row['src_aet']);
//    echo $result_row['institution'] ."-". $result_row['src_aet'] . PHP_EOL;
}
$tempArray= array_unique($tempArray);
echo '<ul data-role="listview" data-inset="true" class="ui-mini">';
foreach ($tempArray as $key => $value) {
    $name = explode('::',$value);
//    echo reset($name) . "---" . end($name) . PHP_EOL;
    echo '<li><a href="tableList_Fenyi.php?aetitle='. end($name) .'">'.
	reset($name) . '</a></li>';

}
echo "</ul>";

?>
