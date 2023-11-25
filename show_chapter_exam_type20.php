				<?php
				include("connect.php");
				$id_subject = $_GET['id_subject'];
				$id_series_exam = $_GET['id_series_exam'];
				$score_series_exam = $_GET['score_series_exam'];

				$score_series_exam = explode(',',$score_series_exam);
				$manager = $_GET['manager'];
				$list_series_exam = $_GET['list_series_exam'];
				$sql = "SELECT * FROM `manager_chapter` WHERE name_name_subject = '$id_subject' ORDER BY `manager_chapter`.`id` ASC";
						$result = mysqli_query($conn, $sql);
						$list = 1;
						$a = 0;
						$i = 0;
            $x = 0;
						while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
							$data_id =  $row['id'];
							// $data_num_chapter =  $row['num_chapter'];
							$data_name_chapter =  $row['name_chapter'];
							$type_series_exam =  $id_subject;
							// $data_objective_chapter =  $row['objective_chapter'];
						//	$list_exam =  $row['list_series_exam'];
            $sql1 = "SELECT count(manager_exam_annotated.id) as sum_exam FROM `manager_chapter`
								INNER JOIN manager_exam_annotated on manager_exam_annotated.chapter_id_exam = manager_chapter.id
								WHERE manager_exam_annotated.chapter_id_exam = $data_id";
					//	$result1 = mysqli_query($conn, $sql1);
            $result1 = $conn->query($sql1);
						while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
              $sum_exam =  $row1['sum_exam'];
            }
          $num_sum_exam = strlen($sum_exam);
				?>
				<input hidden type="text" name="type_series_exam" value="2">
						<div style="border-radius: 5px 5px 5px 5px;" class="card-header">
						<div class="row">
						<div id="empty_bar<?php echo $a; ?>" class="col-sm-12" >
              <!-- <div class="form-group">
              <div class="form-check-inline">
                <label class="form-check-label">
                  <?php echo $type_series_exam; ?>
                  <input <?php if($type_series_exam == 1){echo "checked";} ?> onclick="select_checkbox<?php echo $a; ?>()" type="radio" class="form-check-input" id="radio_select<?php echo $x++; ?>" name="optradio<?php echo $a; ?>">แบบเลือกทีละข้อ
                </label>
              </div>
              <div class="form-check-inline">
                <label class="form-check-label">
                  <input <?php if($type_series_exam == 2){echo "checked";} ?> onclick="select_custom<?php echo $a; ?>()" type="radio" class="form-check-input" id="radio_select<?php echo $x++; ?>" name="optradio<?php echo $a; ?>">แบบกำหนดเอง
                </label>
              </div>

              </div> -->


              <input class="no-collapsable" type="checkbox" id="Check_All2<?php echo $a; ?>" onclick="check_unCheck_All22<?php echo $a; ?>()">
              <i href="#collapse<?php echo $list;?>" role="button" data-toggle="collapse" class="fas fa-table" id="txt_chapter<?php echo $i;?>"><a href="#collapse<?php echo $list;?>" role="button" data-toggle="collapse"> <?php echo $data_name_chapter; ?> </a></i>
              (<?php echo $sum_exam; ?>ข้อ)

            </div>




						</div>
						</div>
          <div id="collapse<?php echo $list;?>" class="panel-collapse collapse">
            <div class="form-check-inline mx-2 my-2" id="input_custom<?php echo $a; ?>">
                ตั้งแต่ข้อ&nbsp;
                <input id="myInput1<?php echo $a; ?>" onchange="limit1<?php echo $a; ?>(this);" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" style="width:70px" type="text" class="form-control" name="">&nbsp;ถึง&nbsp;
                <input id="myInput2<?php echo $a; ?>" onchange="limit2<?php echo $a; ?>(this);" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" style="width:70px" type="text" class="form-control" name="">
                <!-- <button id="submit_btn" type="button" onclick="min1()"></button> -->

            </div>
            <script>
                    function limit1<?=$a?>(input1)
                    {
                        var x;
                        var max_chars = 1;
                        var maxinput = parseInt(<?=$sum_exam?>);
                        var number = parseInt(document.getElementById("myInput1<?=$a;?>").value);
                        var max = parseInt(document.getElementById("myInput2<?=$a;?>").value);



                        //if(element.value.length > max_chars) {
                        if(number > maxinput){
                            document.getElementById("myInput1<?=$a;?>").value = maxinput;
                            number = maxinput;
                        }else if(number == '0'){
                            document.getElementById("myInput1<?=$a;?>").value = 1;
                            number=1;
                        }
                        if(number>max){
                          document.getElementById("myInput1<?=$a;?>").value = max;
                          number=max;
                        }
                        for(x=1;x<=maxinput;x++){
													document.getElementById("point<?=$a;?>"+x).disabled = true;
                          document.getElementById("id<?php echo $a ?>"+x).checked = false;
                          document.getElementById("id<?php echo $a ?>"+x).disabled  = true;
													document.getElementById("point<?=$a;?>"+x).value = null;
                        }
                        for(x=number;x<=max;x++){
													document.getElementById("point<?=$a;?>"+x).disabled = false;
                          document.getElementById("id<?php echo $a ?>"+x).checked = true;
                          document.getElementById("id<?php echo $a ?>"+x).disabled  = false;
													document.getElementById("point<?=$a;?>"+x).value = null;
                        }

                        if(document.getElementById("myInput1<?=$a;?>").value == '' && document.getElementById("myInput2<?=$a;?>").value == ''){
                          for(x=1;x<=maxinput;x++){
                            document.getElementById("id<?php echo $a ?>"+x).disabled  = false;
                          }
                        }
                    }

                    function limit2<?=$a?>(input1)
                    {
                      var x;
                      var max_chars = 1;
                      var maxinput = parseInt(<?=$sum_exam?>);
                      var number = parseInt(document.getElementById("myInput2<?=$a;?>").value);
                      var min = parseInt(document.getElementById("myInput1<?=$a;?>").value);



                      //if(element.value.length > max_chars) {
                      if(number > maxinput){
                          //element.value = element.value.substr(0, max_chars);
                          document.getElementById("myInput2<?=$a;?>").value = maxinput;
                          number = maxinput;
                      }else if(number == '0'){
                          document.getElementById("myInput2<?=$a;?>").value = 1;
                          number = 1;
                      }
                      if(number<min){
                        document.getElementById("myInput2<?=$a;?>").value = min;
                        number = min;
                      }
                      for(x=1;x<=maxinput;x++){
												document.getElementById("point<?=$a;?>"+x).disabled = true;
												// document.getElementById("point<?=$a;?>"+x).value = null;
                        document.getElementById("id<?=$a;?>"+x).checked = false;
                        document.getElementById("id<?=$a;?>"+x).disabled  = true;
												document.getElementById("point<?=$a;?>"+x).value = null;
                      }
                      for(x=min;x<=number;x++){
                        document.getElementById("point<?=$a;?>"+x).disabled = false;
                        document.getElementById("id<?=$a;?>"+x).checked = true;
                        document.getElementById("id<?=$a;?>"+x).disabled  = false;
                        document.getElementById("Check_All2<?=$a;?>").checked = true;
												document.getElementById("point<?=$a;?>"+x).value = null;
                      }

                      if(document.getElementById("myInput1<?=$a;?>").value == '' && document.getElementById("myInput2<?=$a;?>").value == ''){
                        for(x=1;x<=maxinput;x++){
                          document.getElementById("id<?=$a;?>"+x).disabled  = false;
                        }
                      }
                    }


            </script>


						<table class="table table-bordered" id="dataTable1" width="50%" cellspacing="0">
							<!-- <thead> -->

							<!-- </thead> -->
								<tr>
									<th width="5%">
										เลือก
										<!-- <input type="checkbox" id="Check_All2<?php echo $a; ?>" onclick="check_unCheck_All22<?php echo $a; ?>()"> -->
									</th>
									<!-- <th width="10%">ข้อสอบที่</th> -->

									<th  width="85%">โจทย์</th>
									<th  width="10%">คะแนน</th>
								</tr>
								<!-- <input type="text" name="" value="<?=$data_id;?>"> -->

				<?php


					$sql1 = "SELECT manager_exam_annotated.id,manager_exam_annotated.proposition_exam FROM `manager_chapter`
							INNER JOIN manager_exam_annotated on manager_exam_annotated.chapter_id_exam = manager_chapter.id
							WHERE manager_exam_annotated.chapter_id_exam = $data_id";
				//	$result1 = mysqli_query($conn, $sql1);
					$result1 = $conn->query($sql1);
					$num_chapter = 1;
					$b = 1;
					if ($result1->num_rows > 0) {
					while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
						$exam_id =  $row1['id'];
						$proposition_exam =  $row1['proposition_exam'];




				?>
				<tr>
					<td>
								<input hidden type="text" name="id_series_exam" value="<?php echo $id_series_exam;?>">
								<input onclick="check_up2<?php echo $a; ?>()" id="id<?php echo $a.$b; ?>" <?php if($manager=="edit"){
													$arr_list_series_exam = explode(',',$list_series_exam);
													for ($i=0; $i < count($arr_list_series_exam); $i++) {
																		$id = $arr_list_series_exam[$i];
															if($id == $exam_id){
																echo "checked";
																}
												 }
								}
								?> type="checkbox" name="num_exam_value[]" value="<?php echo $exam_id; ?>"></input>
					</td>
					<td>ข้อที่ <?php echo ($num_chapter++)."). ".$proposition_exam; ?></td>

					<td><input required id="point<?php echo $a.$b; ?>" class="form-control" name="name_score_exam[]" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text"
						<?php	echo 'value="';
						if($manager=="edit"){
											$arr_list_series_exam = explode(',',$list_series_exam);
											for ($i=0; $i < count($arr_list_series_exam); $i++) {
																$id = $arr_list_series_exam[$i];
																$point_exam = $score_series_exam[$i];
													if($id == $exam_id){
														 echo $point_exam;
														}
										 }
						}
				 echo '"'; ?>>
			</td>

			</tr>
						<?php $b++; }
					}?>


							</table>



                <script>
                //  document.getElementById('Check_All2<?= $a; ?>').disabled = true;
                //  document.getElementById('empty_bar<?= $a; ?>').disabled = true;
                </script>
              </div>
              <script>
              // function select_checkbox<?php echo $a; ?>() {
              //   document.getElementById("Check_All2<?php echo $a; ?>").hidden = false;
              //   document.getElementById("dataTable1").hidden = false;
              // //  document.getElementById("dataTable2").hidden = true;
              //    document.getElementById("input_custom<?php echo $a; ?>").hidden = true;
              // }
              // function select_custom<?php echo $a; ?>() {
              //   // document.getElementById("tr_up<?php echo $a; ?>").hidden = true;
              //
              //   // document.getElementById("tr_down<?php echo $a.$list; ?>").hidden = true;
              //
              //   document.getElementById("Check_All2<?php echo $a; ?>").hidden = true;
              //   document.getElementById("dataTable1").hidden = true;
              // //  document.getElementById("dataTable2").hidden = false;
              //    document.getElementById("input_custom<?php echo $a; ?>").hidden = false;
              // }
              </script>

	<?php $list++; $a++; } ?>

	<script type="text/javascript">
	<?php

				$sql = "SELECT * FROM `manager_chapter` WHERE name_name_subject = '$id_subject' ORDER BY `manager_chapter`.`id` ASC";
							$result = mysqli_query($conn, $sql);
							$a = 0;
							while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
								$data_id =  $row['id'];
	 ?>
	function check_unCheck_All22<?php echo $a; ?>(){
		 var checkedVal = document.getElementById("Check_All2<?php echo $a; ?>");
		 <?php
		 	$i = 1;
						$sql1 = "SELECT manager_exam_annotated.id,manager_exam_annotated.proposition_exam FROM `manager_chapter`
									INNER JOIN manager_exam_annotated on manager_exam_annotated.chapter_id_exam = manager_chapter.id
									WHERE manager_exam_annotated.chapter_id_exam = $data_id";
							$result1 = mysqli_query($conn, $sql1);
							while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
		 ?>
	 if(checkedVal.checked==true){
			document.getElementById("id<?php echo $a.$i; ?>").checked = true;
	 }else{
			document.getElementById("id<?php echo $a.$i; ?>").checked = false;

	 }

	 if(document.getElementById("id<?php echo $a.$i; ?>").checked == true){
		 checkedVal.checked = true;
		 document.getElementById("point<?php echo $a.$i; ?>").disabled = false;

	 }else{
		 document.getElementById("point<?php echo $a.$i; ?>").disabled = true;
	 }
	<?php $i++; }?>
	}
	<?php
	$a++;
} ?>

	</script>



	<script>
	<?php
	$sql = "SELECT * FROM `manager_chapter` WHERE name_name_subject = '$id_subject' ORDER BY `manager_chapter`.`id` ASC";
			$result = mysqli_query($conn, $sql);
			$a = 0;
			while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
				$data_id =  $row['id'];
				$sql1 = "SELECT manager_exam_annotated.id,manager_exam_annotated.proposition_exam FROM `manager_chapter`
						INNER JOIN manager_exam_annotated on manager_exam_annotated.chapter_id_exam = manager_chapter.id
						WHERE manager_exam_annotated.chapter_id_exam = $data_id";
			//	$result1 = mysqli_query($conn, $sql1);
				$result1 = $conn->query($sql1);
				$num_chapter = 1;
				$b = 1;
				while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
	?>
	var checkedInput = document.getElementById("id<?php echo $a.$b; ?>");

	if(checkedInput.checked==true){
		 document.getElementById("point<?php echo $a.$b; ?>").disabled = false;
	}else{
			 document.getElementById("point<?php echo $a.$b; ?>").disabled = true;

	}
	<?php
		$b++;}
	$a++;}
	?>
	</script>



	<script type="text/javascript">
	 var befor_max = 0;
	 var cout=1;
	 var xxx = <?=$sum_exam?>;

	 //var xxx = parseInt(document.getElementById("test").value);
	<?php
				$sql = "SELECT * FROM `manager_chapter` WHERE name_name_subject = '$id_subject' ORDER BY `manager_chapter`.`id` ASC";
							$result = mysqli_query($conn, $sql);
							$a = 0;
							while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
								$data_id =  $row['id'];
								$sql1 = "SELECT count(manager_exam_annotated.id) as sum_exam FROM `manager_chapter`
										INNER JOIN manager_exam_annotated on manager_exam_annotated.chapter_id_exam = manager_chapter.id
										WHERE manager_exam_annotated.chapter_id_exam = $data_id";
									$result1 = mysqli_query($conn, $sql1);
									$i = 1;

	 ?>
	function check_up2<?php echo $a; ?>(){
		 var checkedVal = document.getElementById("Check_All2<?php echo $a; ?>");
		 <?php
						$sql1 = "SELECT manager_exam_annotated.id,manager_exam_annotated.proposition_exam FROM `manager_chapter`
									INNER JOIN manager_exam_annotated on manager_exam_annotated.chapter_id_exam = manager_chapter.id
									WHERE manager_exam_annotated.chapter_id_exam = $data_id";
							$result1 = mysqli_query($conn, $sql1);
							$i = 1;
							while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
		 ?>

		 if(document.getElementById("id<?php echo $a.$i; ?>").checked == true){
			 checkedVal.checked = true;
			 document.getElementById("point<?php echo $a.$i; ?>").disabled = false;

		 }else{
			 document.getElementById("point<?php echo $a.$i; ?>").disabled = true;
			 document.getElementById("point<?php echo $a.$i; ?>").value = null;
		 }
		 if(document.getElementById("id<?php echo $a.$i; ?>").checked == false){
			 document.getElementById("myInput1<?php echo $a; ?>").value = null;
			 document.getElementById("myInput2<?php echo $a; ?>").value = null;
			 var x;
			 var maxinput = <?=$sum_exam;?>;



		 }


	<?php $i++; }?>
	//cout = cout+1;
	cout++;
	}

	<?php $a++; }
	?>


	</script>



	<script type="text/javascript">
	// <?php
	// 			$sql = "SELECT * FROM `manager_chapter` WHERE name_name_subject = '$id_subject' ORDER BY `manager_chapter`.`id` ASC";
	// 						$result = mysqli_query($conn, $sql);
	// 						$a = 0;
	// 						while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
	// 							$data_id =  $row['id'];
	//  ?>
	// function check_unCheck_All22<?php echo $a; ?>(){
	// 	 var checkedVal = document.getElementById("Check_All2<?php echo $a; ?>");
	// 	 <?php
	// 					$sql1 = "SELECT manager_exam.id,manager_exam.proposition_exam FROM `manager_chapter`
	// 								INNER JOIN manager_exam on manager_exam.chapter_id_exam = manager_chapter.id
	// 								WHERE manager_exam.chapter_id_exam = $data_id";
	// 						$result1 = mysqli_query($conn, $sql1);
	// 						$i = 0;
	// 						while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
	// 	 ?>
	//  if(checkedVal.checked==true){
	// 		document.getElementById("id<?php echo $a.$i; ?>").checked = true;
	//     //document.getElementById("Check_All21").checked = true;
	//     if(document.getElementById("id<?php echo $a.$i; ?>").checked == true){
	//       checkedVal.checked = true;
	//     }
	//
	//  }else{
	// 		document.getElementById("id<?php echo $a.$i; ?>").checked = false;
	//
	//  }
	//
	// <?php //$i++; }?>
	// }
	// <?php// $a++; } ?>

	<?php
	$sql = "SELECT * FROM `manager_chapter` WHERE name_name_subject = '$id_subject' ORDER BY `manager_chapter`.`id` ASC";
				$result = mysqli_query($conn, $sql);
				$a = 0;
				while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
					$data_id =  $row['id'];
	?>
	var checkedVal = document.getElementById("Check_All2<?php echo $a; ?>");
	<?php
			$sql1 = "SELECT manager_exam_annotated.id,manager_exam_annotated.proposition_exam FROM `manager_chapter`
						INNER JOIN manager_exam_annotated on manager_exam_annotated.chapter_id_exam = manager_chapter.id
						WHERE manager_exam_annotated.chapter_id_exam = $data_id";
				$result1 = mysqli_query($conn, $sql1);
				$i = 1;
				while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
					?>
					if(document.getElementById("id<?php echo $a.$i; ?>").checked == true){
						checkedVal.checked = true;

					}else if(!document.getElementById("id<?php echo $a.$i; ?>").checked == false){
						checkedVal.checked = false;
					}
					<?php $i++; }?>

					<?php $a++; } ?>

	</script>
