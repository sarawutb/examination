<?php 
/* version 1.0
 * การสร้างหัวตารางแบบหลายแถว
 * 
 */
class PDFNew extends FPDF_Thai {
	var $numPage;
	var $Today;
	var $Today2;
	var $SystemName;
	var $ReportName;
	var $ReportName2;
	var $ReportID;
	var $Times;
	var $UserName;
	var $PageNo;
	var $PageAll;
	var $Campus;
	var $Faculty;
	var $StartDate;
	var $EndDate;
	var $arrHeadT;
	var $arrHeadT2;
	var $arrHeadT3;
	var $arrHeadTWidth;
	var $cellH = 6;
	var $MaxY;
	var $EndPage;
		
	function SetThaiFont() {
		$this->AddFont('AngsanaNew','','angsa.php');
		$this->AddFont('AngsanaNew','B','angsab.php');
		$this->AddFont('AngsanaNew','I','angsai.php');
		$this->AddFont('AngsanaNew','IB','angsaz.php');
		$this->AddFont('CordiaNew','','cordia.php');
		$this->AddFont('CordiaNew','B','cordiab.php');
		$this->AddFont('CordiaNew','I','cordiai.php');
		$this->AddFont('CordiaNew','IB','cordiaz.php');
		$this->AddFont('Tahoma','','tahoma.php');
		$this->AddFont('Tahoma','B','tahomab.php');
		$this->AddFont('BrowalliaNew','','browa.php');
		$this->AddFont('BrowalliaNew','B','browab.php');
		$this->AddFont('BrowalliaNew','I','browai.php');
		$this->AddFont('BrowalliaNew','IB','browaz.php');
		$this->AddFont('KoHmu','','kohmu.php');
		$this->AddFont('KoHmu2','','kohmu2.php');
		$this->AddFont('KoHmu3','','kohmu3.php');
		$this->AddFont('MicrosoftSansSerif','','micross.php');
		$this->AddFont('PLE_Cara','','plecara.php');
		$this->AddFont('PLE_Care','','plecare.php');
		$this->AddFont('PLE_Care','B','plecareb.php');
		$this->AddFont('PLE_Joy','','plejoy.php');
		$this->AddFont('PLE_Tom','','pletom.php');
		$this->AddFont('PLE_Tom','B','pletomb.php');
		$this->AddFont('PLE_TomOutline','','pletomo.php');
		$this->AddFont('PLE_TomWide','','pletomw.php');
		$this->AddFont('DilleniaUPC','','dill.php');
		$this->AddFont('DilleniaUPC','B','dillb.php');
		$this->AddFont('DilleniaUPC','I','dilli.php');
		$this->AddFont('DilleniaUPC','IB','dillz.php');
		$this->AddFont('EucrosiaUPC','','eucro.php');
		$this->AddFont('EucrosiaUPC','B','eucrob.php');
		$this->AddFont('EucrosiaUPC','I','eucroi.php');
		$this->AddFont('EucrosiaUPC','IB','eucroz.php');
		$this->AddFont('FreesiaUPC','','free.php');
		$this->AddFont('FreesiaUPC','B','freeb.php');
		$this->AddFont('FreesiaUPC','I','freei.php');
		$this->AddFont('FreesiaUPC','IB','freez.php');
		$this->AddFont('IrisUPC','','iris.php');
		$this->AddFont('IrisUPC','B','irisb.php');
		$this->AddFont('IrisUPC','I','irisi.php');
		$this->AddFont('IrisUPC','IB','irisz.php');
		$this->AddFont('JasmineUPC','','jasm.php');
		$this->AddFont('JasmineUPC','B','jasmb.php');
		$this->AddFont('JasmineUPC','I','jasmi.php');
		$this->AddFont('JasmineUPC','IB','jasmz.php');
		$this->AddFont('KodchiangUPC','','kodc.php');
		$this->AddFont('KodchiangUPC','B','kodc.php');
		$this->AddFont('KodchiangUPC','I','kodci.php');
		$this->AddFont('KodchiangUPC','IB','kodcz.php');
		$this->AddFont('LilyUPC','','lily.php');
		$this->AddFont('LilyUPC','B','lilyb.php');
		$this->AddFont('LilyUPC','I','lilyi.php');
		$this->AddFont('LilyUPC','IB','lilyz.php');
	}
	

	
	function Header (){
		//สำหรับสร้างหัวกระดาษ
		 
		$this->SetLeftMargin(3);
		$this->SetRightMargin(3);
		$sumW = array_sum($this->arrHeadTWidth);
		//กำหนดขอบกระดาษว่าจะสิ้นสุดที่ตำแหน่งไหน (หน่วยเป็น milimeter)
		if($this->DefOrientation == "L")
			$this->EndPage= 183; //กรณีกระดาษอยูในแนวนอน
		else
			$this->EndPage= 273; //กรณีกระดาษอยูในแนวตั้ง
		$this->SetAutoPageBreak(false,10); //กำหนดไม่ให้ขึ้นหน้าไหมอัตโนมัติ
		$this->SetY(7);
		$this->SetX(3);
		$this->SetFont('AngsanaNew','',12);
		$this->Cell(0,0,$this->ConvToThai("ระบบ: ".$this->SystemName),0,1,'L');
		$this->SetFont('AngsanaNew', 'B', 15);
		//$this->SetFont('Angsana','',14);
		$HeadReport = "มหาวิทยาลัยบูรพา".((!empty($this->Campus))? "/".$this->Campus : "");
		$this->Cell(0,0,$this->ConvToThai($HeadReport),0,1,'C');
		if($this->DefOrientation == "L")
			$this->SetX(271);
		else
			$this->SetX(185);
		$this->SetFont('AngsanaNew','',12);
		$this->Cell(0,0,$this->ConvToThai("วันที่ : ".$this->Today),0,1,'L');
		// line 2
		$this->SetY(13);
		$this->SetX(3);
		$this->Cell(0,0,$this->ConvToThai("[ ".$this->ReportID." ]"),0,1,"L");
		$this->SetFont('AngsanaNew','',13);
		$this->Cell(0,$pdf->cellH,$this->ConvToThai($this->ReportName),0,1,"C");
		if($this->DefOrientation == "L")
			$this->SetX(271);
		else
			$this->SetX(185);
		$this->Cell(0,0,$this->ConvToThai("เวลา : ".$this->Times),0,1,'L');
		// line 3
		$this->SetY(19);
		$this->SetX(3);
		$this->Cell(0,0,$this->ConvToThai("รหัสผู้ใช้: ".$_SESSION["sess_login"]["FIRSTNAMEEN"]),0,1,'L');
		$this->SetFont('AngsanaNew','',12);
		if(!empty($this->Today2))
		$this->Cell(0,0,$this->ConvToThai("ณ ".$this->Today2),0,1,'C');
		if($this->DefOrientation == "L")
			$this->SetX(269);
		else
			$this->SetX(184);
		$this->Cell(0,0,$this->ConvToThai("หน้าที่ : ").$this->PageNo()."/{nb}",0,1,'L');
		//line 4
		if(!empty($this->ReportName2)){
			$this->Cell(0,0,$this->ConvToThai($this->ReportName2),0,1,'C');
		}
		if(!empty($this->StartDate)){
			//แปลงเดือน
			$arrStartDate = explode("/",$this->StartDate);
  			$arrEndDate = explode("/",$this->EndDate);
  			$TxtSDate = $arrStartDate[0]." ".changefullmonth($arrStartDate[1])." ".($arrStartDate[2]+543);
  			$TxtEDate = $arrEndDate[0]." ".changefullmonth($arrEndDate[1])." ".($arrEndDate[2]+543);
  			
		//	$this->SetY(25);
			$this->Cell(0,0,$this->ConvToThai("ตั้งแต่วันที่  ".$TxtSDate." ถึงวันที่ ".$TxtEDate),0,1,'C');
		}
	}
	
	function Footer(){
		//$this->SetLineWidth(0);
		//$this->Line(11,195,285,195);
		//$this->SetY(200);
		//$this->SetX(275);
		//$this->Cell(0,0,'˹�� '.$this->PageNo().'/{nb}',0,0,'C');
	}
	
	function CutString($str, &$remain, $cut) {
		$arr = array("�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
		$arrSara = array("�", "�", "�");
		
		//while (1) {
		$s = substr($str,0,$cut);
		$remain = substr($str,$cut, strlen($str));
		if (!in_array($remain{0}, $arr)) {
			for ($i = 0; $i < strlen($remain); $i++) {
				if (in_array($remain{$i}, $arr))
					break;
			}		
			
		} 
		
		$s = substr($str, 0, ($cut+$i));
		$remain = substr($str, ($cut+$i), strlen($str));
		
		return $s;
		
	}	// end function
	
	function CutStringForPDF($str, $cut, &$arrString) {
		$arr = array("�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
		$arrSara = array("�", "�", "�");
		$newline = 0;
			
		while (1) {
			$s = substr($str,0,$cut);
			$remain = substr($str,$cut, strlen($str));
			if (!in_array($remain{0}, $arr)) {
				for ($i = 0; $i < strlen($remain); $i++) {
					if (in_array($remain{$i}, $arr))
						break;
				}	// end for	
			}	// end if 
			$s = substr($str, 0, ($cut+$i));
			$remain = substr($str, ($cut+$i), strlen($str));
			
			$arrString[$newline++] = $s;
			if (strlen($remain) <= $cut) {
				if (!empty($remain))
					$arrString[$newline++] = $remain;
				break;
			} else {
				$str = $remain;
				$remain = "";		$s = "";
			}
				
			
		}	// end while	
			
		return $newline;
		
	}	// end function
	
	function CreateHeadTable($posX,$posY,$cellH=6){
		$sum = 0;
		$nCol = count($this->arrHeadT); //หัวตารางแถวที่ 1
		$nCol2 = count($this->arrHeadT2); //หัวตารางแถวที่ 2
		$nCol3 = count($this->arrHeadT3); //หัวตารางแถวที่ 3
		//$this->SetFont('AngsanaNew', 'B', 12);
		//กรณีหัวตารางมีแถวย่อมากว่า 1 แถว
		if(($nCol2 > 0) && ($nCol3 <= 0)) //ตรวจสอบว่ามีข้อมูลหัวตารางแถวที่ 2 หรือไม่
			$cellH *= 2;
		if($nCol3 > 0)  //ตรวจสอบว่ามีข้อมูลหัวตารางแถวที่ 3 หรือไม่
			$cellH *= 3;
			
			$sum2 = 0; //ผลรวมความกว้างของคอลัมภ์แถวที่ 2
			$sum3 = 0;  //ผลรวมความกว้างของคอลัมภ์แถวที่ 3
			$i=0;
		while($i<$nCol){ //เริ่มค้นหาข้อมูลในหัวตารางแถวที่ 1
			//if($i != $nCol )
		if($nCol3 > 0){ //กรณีที่แถวที่ 3 มีข้อมูล
			
			$k = 0;
			$i3 = $i+$j;
			$arrData1 = explode(":",$this->arrHeadT2[$i]);
			if(count($arrData1) > 1){//แถวที่ 2 มีข้อมูล
				$j = -1;
			foreach($arrData1 as $value1){//วนลูปข้อมูลของแถวที่ 2
				$indx = $i.$k;
				$arrData2 = explode(":",$this->arrHeadT3[$indx]);
				
			if(count($arrData2) > 1){//แถวที่ 3 มีข้อมูล
				
			foreach($arrData2 as $value2){
					++$j;
					$this->SetXY($sum+$sum3+$posX,$posY+($cellH-($cellH/3)));
					$this->CellFitScale($this->arrHeadTWidth[$i3],($cellH/3),$this->ConvToThai($value2),1,1,'C');
					$sum3 += $this->arrHeadTWidth[$i3];
					$sum4 += $this->arrHeadTWidth[$i3];
					$i3++;	
				}
			}
			
					
					$this->SetXY($sum+$sum2+$posX,$posY+($cellH/3));
					$this->CellFitScale($sum4,($cellH/3),$this->ConvToThai($value1),1,1,'C');
					$k++; //เริ่มนับคอลัมภ์
					$sum2 += $sum4;
					$sum4 = 0;	
				}
				$this->SetXY($sum+$posX,$posY);
				$this->CellFitScale($sum2,$cellH/3,$this->ConvToThai($this->arrHeadT[$i]),1,1,'C');
			}else if(count($arrData1) == 1){
				$j = 0;
				$indx = $i.$k;
				$arrData2 = explode(":",$this->arrHeadT3[$indx]);
				if(count($arrData2) > 1){
					foreach($arrData2 as $value2){
						++$j;
						$this->SetXY($sum+$sum2+$posX,$posY+($cellH-($cellH/3)));
						$this->CellFitScale($this->arrHeadTWidth[$i3],($cellH/3),$this->ConvToThai($value2),1,1,'C');
						$sum2 += $this->arrHeadTWidth[$i3];
						$i3++;	
					}
				$this->SetXY($sum+$posX,$posY);
				$this->CellFitScale($sum2,($cellH-($cellH/3)),$this->ConvToThai($this->arrHeadT[$i]),1,1,'C');
				$this->SetXY($posX,$this->GetY()+($cellH/3));
				}
			}
		}		
		if(($nCol2 > 0) && ($nCol3 <= 0)){ //กรณีที่แถวที่ 2 มีข้อมูล
				$arrData = (!empty($this->arrHeadT2[$i]))? explode(":",$this->arrHeadT2[$i]) : "";
				if(!empty($this->arrHeadT2[$i])){
					$j = -1;
					$i2 = $i;
				foreach($arrData as $value){
					++$j;
					$this->SetXY($sum+$sum2+$posX,$posY+($cellH/2));
					$this->CellFitScale($this->arrHeadTWidth[$i2],($cellH/2),$this->ConvToThai($value),1,1,'C');
					$sum2 += $this->arrHeadTWidth[$i2];
					$i2++;
				} 
				
				$this->SetXY($sum+$posX,$posY);
				$this->CellFitScale($sum2,$cellH/2,$this->ConvToThai($this->arrHeadT[$i]),1,1,'C');
				$this->SetXY($posX,$this->GetY()+($cellH/2));
				
				}
				
			}
			
			if($sum2 <= 0){
			$this->SetXY($sum+$posX,$posY);
			$this->CellFitScale($this->arrHeadTWidth[$i+$j],$cellH,$this->ConvToThai($this->arrHeadT[$i]),1,1,'C');
			$sum += $this->arrHeadTWidth[$i+$j];
		
			}else{
				$sum += $sum2;
				$sum2 = 0;
			}
			
			$i++;
		}
		
	}
	
	function CreateHeadTableMulti($posX,$posY){
		$sum = 0;
		$nCol = count($this->arrHeadT);
	//	$this->SetFont('AngsanaNew', 'B', 12);
		$this->MaxY = 0;
		$sum = 0;
		for($i=0;$i<$nCol;$i++){
			if($i != $nCol )
				$this->SetXY($sum+$posX,$posY);
			$this->MultiCell($this->arrHeadTWidth[$i],$this->cellH,$this->ConvToThai($this->arrHeadT[$i]),'T','C');
			$sum += $this->arrHeadTWidth[$i];
			$this->MaxY = ($this->MaxY < $this->GetY())? $this->GetY() : $this->MaxY;
			
		}
			$this->MaxY = (($posY+$this->cellH) > $this->MaxY)? ($posY+$this->cellH) : $this->MaxY;
			$this->SetXY($posX,$this->MaxY);
			$this->Line($posX,$this->MaxY,$sum+$posX,$this->MaxY);
			$sum = 0;
			//ตีเส้นแนวตั้ง
			for($i=0;$i<=$nCol;$i++){
				$this->Line($posX+$sum,$posY,$posX+$sum,$this->MaxY);
				$sum += $this->arrHeadTWidth[$i];
			}
			
			$this->SetXY($posX,$this->MaxY);
	}
	
	function CreateTableMulti($posX,$posY,$aW,$aText,$aAlign,$Bfont="",$Sizefont=12){
			$this->SetXY($posX,$posY);
			$this->SetFont('AngsanaNew',$Bfont,$Sizefont);
			$this->MaxY = 0;
			$sum = 0;
			$nC = count($aW);
			for($i=0;$i<$nC;$i++){
				$sum += $aW[$i];
				$TxtAlign = (empty($aAlign[$i]))? "L" : $aAlign[$i] ;
				$this->MultiCell($aW[$i],$this->cellH,$this->ConvToThai($aText[$i]),0,$TxtAlign);
				$this->MaxY = ($this->MaxY < $this->GetY())? $this->GetY() : $this->MaxY;
				if($i < ($nC+1))
					$this->SetXY($posX+$sum,$posY);
			}
				$this->MaxY = (($posY+$this->cellH) > $this->MaxY)? ($posY+$this->cellH) : $this->MaxY;
			$this->SetXY($posX,$this->MaxY);
			$this->Line($posX,$this->MaxY,$sum+$posX,$this->MaxY);
			$sum = 0;
			//ตีเส้นแนวตั้ง
			for($i=0;$i<=$nC;$i++){
				$this->Line($posX+$sum,$posY,$posX+$sum,$this->MaxY);
				$sum += $aW[$i];
			}
			$this->SetXY($posX,$this->MaxY);
		}
		
		
	function CreateTable($posX,$posY,$aW,$aText,$aAlign,$Bfont="",$Sizefont=12){
			$this->SetXY($posX,$posY);
			$this->SetFont('AngsanaNew',$Bfont,$Sizefont);
			$sum = 0;
			$nC = count($aW);
			for($i=0;$i<$nC;$i++){
				$sum += $aW[$i];
				$TxtAlign = (empty($aAlign[$i]))? "L" : $aAlign[$i] ;
				$this->CellFitScale($aW[$i],$this->cellH,$this->ConvToThai($aText[$i]),1,1,$TxtAlign);
				if($i < ($nC+1))
					$this->SetXY($posX+$sum,$posY);
			}
			$this->SetXY($posX,$this->GetY()+$this->cellH);
		}

		/*
		 *  Function 	: CreateHeadTableMulti2($posX,$posY,$cellH)
		 *  Attitude 	: เพื่อสร้างหัวตาราง ให้มีการ Murge Cell เอกสารในรูปแบบ PDF
		 *  ข้อจำกัด		: สามารถส้างหัวตารางซ้อนกันได้แค่ 3 ชั้น
		 *  Create Date	: 18/10/2553
		 *  Creater 	: Vichaya Sunsern
		 */
function CreateHeadTableMulti2($posX,$posY,$cellH=6){
		$sum = 0;
		$nCol = count($this->arrHeadT); //หัวตารางแถวที่ 1
		$nCol2 = count($this->arrHeadT2); //หัวตารางแถวที่ 2
		$nCol3 = count($this->arrHeadT3); //หัวตารางแถวที่ 3
		$this->MaxY = 0;
		$StartY2 = 0;
		$StartY3 = 0;
		$NewarrPoint = array();
		$NewarrPoint2 = array();
		$NewarrPoint3 = array();
		$NewarrWidth = array();
		$NewarrWidth2 = array();
		$NewarrWidth3 = array();
		$indxW= 0; //index ของ array arrHeadTWidth
		$sum1 = 0; //ผลรวมความกว้างของคอลัมภ์แถวที่ 1
		$sum2 = 0; //ผลรวมความกว้างของคอลัมภ์แถวที่ 2
		$sum3 = 0;  //ผลรวมความกว้างของคอลัมภ์แถวที่ 3
		//$this->SetFont('AngsanaNew', 'B', 12);
		//กรณีหัวตารางมีแถวย่อมากว่า 1 แถว
		if(($nCol2 > 0) && ($nCol3 <= 0)) //ตรวจสอบว่ามีข้อมูลหัวตารางแถวที่ 2 หรือไม่
			$cellH *= 2;
		if($nCol3 > 0)  //ตรวจสอบว่ามีข้อมูลหัวตารางแถวที่ 3 หรือไม่
			$cellH *= 3;
		for($i=0;$i < $nCol;$i++){//f1
			if(!empty($this->arrHeadT2[$i])){
				$arrData = explode(":",$this->arrHeadT2[$i]);
				array_push($NewarrPoint,$posX+$sum1);
				for($i2=0;$i2 < count($arrData);$i2++){//f2	
					array_push($NewarrPoint2,$posX+$sum1);
					
					if(!empty($this->arrHeadT3[$i.$i2])){
						$arrData2 = explode(":",$this->arrHeadT3[$i.$i2]);
						
						for($i3=0;$i3 < count($arrData2);$i3++){//f3
							array_push($NewarrPoint3,$posX+$sum1);
							array_push($NewarrWidth3,$this->arrHeadTWidth[$indxW]);
							$sum3 += $this->arrHeadTWidth[$indxW];
							$sum2 += $this->arrHeadTWidth[$indxW];
							$sum1 += $this->arrHeadTWidth[$indxW++];
						}
						
					}else{						
							$sum2 += $this->arrHeadTWidth[$indxW];
							$sum1 += $this->arrHeadTWidth[$indxW++];	
							//$tempSum += $sum2;
					}
					$tempSum += $sum2;
					array_push($NewarrWidth2,$sum2);
					$sum2 = 0;
				}
				//$sum1=0;
				
				array_push($NewarrWidth,($tempSum != 0)? $tempSum : $sum3); 
				
				//$sum1 += $this->arrHeadTWidth[$indxW++];
			}else{
				array_push($NewarrPoint,$posX+$sum1);
				array_push($NewarrWidth,$this->arrHeadTWidth[$indxW]);
				$sum1 += $this->arrHeadTWidth[$indxW++];
			}
			$sum2 =0;
			$sum3 = 0;
			$tempSum = 0;
		}
			$indxW =0;
			$i=0;
		
		if($nCol3 > 0){ //กรณีที่แถวที่ 3 มีข้อมูล
			//เขียนหัวตารางในแถวที่ 1
			for($i=0;$i<$nCol;$i++){
				$this->SetXY($NewarrPoint[$i],$posY);
				$this->MultiCell($NewarrWidth[$i],($cellH/3),$this->ConvToThai($this->arrHeadT[$i]),'T','C');
				$this->MaxY = ($this->MaxY < $this->GetY())? $this->GetY() : $this->MaxY;
			}
				$StartY2 = $this->MaxY;
				$indx2=0;
			//เขียนหัวตารางในแถวที่ 2
			for($i=0;$i<$nCol;$i++){
				if(!empty($this->arrHeadT2[$i])){
					$arrData = explode(":",$this->arrHeadT2[$i]);
					foreach ($arrData as $Value){
						$this->SetXY($NewarrPoint2[$indx2],$StartY2);
						$this->MultiCell($NewarrWidth2[$indx2],($cellH/3),$this->ConvToThai($Value),'T','C');
						$this->MaxY = ($this->MaxY < $this->GetY())? $this->GetY() : $this->MaxY;
						$indx2++;
					}
				}
			}
			$indx2=0;
			for($i=0;$i<$nCol;$i++){
				if(!empty($this->arrHeadT2[$i])){
					$arrData = explode(":",$this->arrHeadT2[$i]);
					foreach ($arrData as $Value){
						$this->Line($NewarrPoint2[$indx2],$StartY2,$NewarrPoint2[$indx2],$this->MaxY);
						$indx2++;
					}
				}
			}
			
		//เขียนหัวตารางในแถวที่ 3
		$StartY3 = $this->MaxY;
		$indx3 = 0;
			for($i=0;$i<$nCol;$i++){
				if(!empty($this->arrHeadT2[$i])){
					$arrData = explode(":",$this->arrHeadT2[$i]);
					for($i2=0;$i2 < count($arrData);$i2++){//f2	
						if(!empty($this->arrHeadT3[$i.$i2])){
						$arrData2 = explode(":",$this->arrHeadT3[$i.$i2]);
						foreach ($arrData2 as $Value){
						$this->SetXY($NewarrPoint3[$indx3],$StartY3);
						$this->MultiCell($NewarrWidth3[$indx3],($cellH/3),$this->ConvToThai($Value),'T','C');
						$this->MaxY = ($this->MaxY < $this->GetY())? $this->GetY() : $this->MaxY;
						$indx3++;
						}
					}
				}
			 }
			}
		$indx2=0;
		$indx3=0;
			for($i=0;$i<$nCol;$i++){
				if(!empty($this->arrHeadT2[$i])){
					$arrData = explode(":",$this->arrHeadT2[$i]);
					for($i2=0;$i2 < count($arrData);$i2++){//f2	
						if(!empty($this->arrHeadT3[$i.$i2])){
							$arrData2 = explode(":",$this->arrHeadT3[$i.$i2]);
							foreach ($arrData2 as $Value){
								$this->Line($NewarrPoint3[$indx3],$StartY3,$NewarrPoint3[$indx3],$this->MaxY);
								$indx3++;
							}
						}
						$this->Line($NewarrPoint2[$indx2],$StartY2,$NewarrPoint2[$indx2],$this->MaxY);
						$indx2++;
					}
				}
			}
			$sumAll = 0;
		for($i=0;$i<$nCol;$i++){
				$this->Line($NewarrPoint[$i],$posY,$NewarrPoint[$i],$this->MaxY);
				$sumAll += $NewarrWidth[$i];
			}
			$this->Line($posX,$this->MaxY,$posX+$sumAll,$this->MaxY);
			$this->Line($posX+$sumAll,$posY,$posX+$sumAll,$this->MaxY);
			
		}else if(($nCol2 > 0) && ($nCol3 <= 0)){ //กรณีที่แถวที่ 2 มีข้อมูล
			for($i=0;$i<$nCol;$i++){
				
				if(!empty($this->arrHeadT2[$i])){
					$arrData = (!empty($this->arrHeadT2[$i]))? explode(":",$this->arrHeadT2[$i]) : "";
					$j = -1;
					$i2 = $i;
					for($su2 = 0;$su2 < count($arrData);$su2++){
						$sumX2 += $this->arrHeadTWidth[$indxW++];
					}
					
				$this->SetXY($sum+$posX,$posY);
				$this->MultiCell($sumX2,($cellH/2),$this->ConvToThai($this->arrHeadT[$i]),'T','C');
				$this->MaxY = ($this->MaxY < $this->GetY())? $this->GetY() : $this->MaxY;
				$StartY2 = $this->MaxY;
		
				$sum += $sumX2;
				$sumX2 = 0;
				$this->SetXY($posX,$this->MaxY);
				
				}else{
					$this->SetXY($sum+$posX,$posY);
			$this->MultiCell($this->arrHeadTWidth[$indxW],$this->cellH,$this->ConvToThai($this->arrHeadT[$i]),'T','C');
			
			$sum += $this->arrHeadTWidth[$indxW++];
			$this->MaxY = ($this->MaxY < $this->GetY())? $this->GetY() : $this->MaxY;
				}
			
				
			}
			$sum =0;
			$sum2 = 0;
			$indxW = 0;
		for($m=0;$m<$nCol;$m++){
					$arrData = (!empty($this->arrHeadT2[$m]))? explode(":",$this->arrHeadT2[$m]) : "";
					$i2 =$m;
					if((!empty($this->arrHeadT2[$m]))){
						
					foreach($arrData as $value){
						$this->SetXY($sum+$sum2+$posX,$StartY2);
						$this->MultiCell($this->arrHeadTWidth[$indxW],($cellH/2),$this->ConvToThai($value),'T','C');
						$this->MaxY = ($this->MaxY < $this->GetY())? $this->GetY() : $this->MaxY;
						$sum2 += $this->arrHeadTWidth[$indxW++];
						$i2++;
						}
					}
					$sum += ($sum2 == 0)? $this->arrHeadTWidth[$indxW++]:$sum2;
					$sum2 = 0;
				}
		
			
			$this->SetXY($posX,$this->MaxY);
			$this->Line($posX,$this->MaxY,$sum+$posX,$this->MaxY);
			$sum = 0;
			$sum2 = 0;
			$indxW =0;

			for($i=0;$i<=$nCol;$i++){
				
				if((!empty($this->arrHeadT2[$i]))){
					$i2 = $i;
					$arrData = (!empty($this->arrHeadT2[$i]))? explode(":",$this->arrHeadT2[$i]) : "";
					$this->Line($posX+$sum,$posY,$posX+$sum,$this->MaxY);
					foreach($arrData as $value){		
						$sum2 += $this->arrHeadTWidth[$indxW++];
						$this->Line($posX+$sum+$sum2,$StartY2,$posX+$sum+$sum2,$this->MaxY);		
						$i2++;
					}
				}else{	
					$this->Line($posX+$sum,$posY,$posX+$sum,$this->MaxY);
				}
				$sum += ($sum2 == 0)? $this->arrHeadTWidth[$indxW++]:$sum2;
				$sum2 = 0;
			}
		}
	}//end function
}
?><html xmlns:mso="urn:schemas-microsoft-com:office:office" xmlns:msdt="uuid:C2F41010-65B3-11d1-A29F-00AA00C14882"><head>
<!--[if gte mso 9]><xml>
<mso:CustomDocumentProperties>
<mso:Keywords msdt:dt="string"></mso:Keywords>
<mso:wic_System_Copyright msdt:dt="string"></mso:wic_System_Copyright>
<mso:_Author msdt:dt="string"></mso:_Author>
<mso:_Comments msdt:dt="string"></mso:_Comments>
<mso:VideoHeightInPixels msdt:dt="string"></mso:VideoHeightInPixels>
<mso:display_urn_x003a_schemas-microsoft-com_x003a_office_x003a_office_x0023_Editor msdt:dt="string">Vichaya Sunsern</mso:display_urn_x003a_schemas-microsoft-com_x003a_office_x003a_office_x0023_Editor>
<mso:VideoWidthInPixels msdt:dt="string"></mso:VideoWidthInPixels>
<mso:Order msdt:dt="string">1300.00000000000</mso:Order>
<mso:PublishingStartDate msdt:dt="string"></mso:PublishingStartDate>
<mso:PublishingExpirationDate msdt:dt="string"></mso:PublishingExpirationDate>
<mso:display_urn_x003a_schemas-microsoft-com_x003a_office_x003a_office_x0023_Author msdt:dt="string">Vichaya Sunsern</mso:display_urn_x003a_schemas-microsoft-com_x003a_office_x003a_office_x0023_Author>
<mso:AlternateThumbnailUrl msdt:dt="string"></mso:AlternateThumbnailUrl>
<mso:_SourceUrl msdt:dt="string"></mso:_SourceUrl>
<mso:_SharedFileIndex msdt:dt="string"></mso:_SharedFileIndex>
<mso:MediaLengthInSeconds msdt:dt="string"></mso:MediaLengthInSeconds>
</mso:CustomDocumentProperties>
</xml><![endif]-->
<title></title></head>