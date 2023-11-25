<?php
require_once 'vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

$html = '
<html>
<head>
<style>
    @page {
      size: auto;
      odd-header-name: html_MyHeader1;
      odd-footer-name: html_MyFooter1;

     margin-top: 100px;
    }
    

    @page chapter2 {
        odd-header-name: html_MyHeader2;
        odd-footer-name: html_MyFooter2;
    }

    @page noheader {
        odd-header-name: _blank;
        odd-footer-name: _blank;
    }

    div.chapter2 {
        page-break-before: always;
        page: chapter2;
    }

    div.noheader {
        page-break-before: always;
        page: noheader;
    }
</style>
</head>
<body>
    <htmlpageheader name="MyHeader1">
        <div style="text-align: right; border-bottom: 1px solid #000000; font-weight: bold; font-size: 10pt;">
		
		<div style="text-align: center; font-weight: bold; font-size: 11pt;"><b>xxxxxxxxxxxxxxxxxxxxxxxx</b><br>
			<b>xxxx '.$name_subject.' xxxxx '.$name_teacher.'</b><br>
			<b>xxxxxxxxxxxxxx</b></div>
		
		
		</div>
    </htmlpageheader>

   

    <htmlpagefooter name="MyFooter1">
        <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
            <tr>
                <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
                <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
                <td width="33%" style="text-align: right; ">My document</td>
            </tr>
        </table>
    </htmlpagefooter>

    

    <div style="margin-top: 250px;">';
	
	$html .= 'Here is the text of the first chapter
	
	</div>
  
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('คะแนนเก็บวิชา '.$name_subject, 'I');
$mpdf->Output();