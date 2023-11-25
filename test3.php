<?php
header('Content-Type: application/json;charset=utf-8');
// $url = 'http://hyd-app.rid.go.th/hydro4hwl.html';
$url = file_get_contents('https://watertele.egat.co.th/pakmun/dataStation/ajx_teledata_right.php?stationSI=15');
// echo $url;
// <div id="showdata_right"><input type="hidden" id="waterLV" value="108.06">
// $post_content = '<a href="http://www.test.com" title="test">test.com</a> there is another example <a href="http://www.test1.com">test1.com</a>
// one more here too <a href="http://www.test2.com" title="test2">test2.com</a>';
// preg_match_all('/<div id="showdata_right"><input type="hidden" id="waterLV" value="(.*?)"/is', $url, $matches);
preg_match_all('/(border-left: 1px solid.*?)"/is', $url, $matches);
print_r($matches[0][13]);
?>
