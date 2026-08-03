<!-- <input hidden type="text" name="type_series_exam1[]" value="1"> -->
				<?php
				include("connect.php");
				$id_subject = $_GET['id_subject'];
				$id_series_exam = $_GET['id_series_exam'];
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
							$data_name_chapter =  $row['name_chapter'];

            $sql1 = "SELECT count(manager_exam.id) as sum_exam FROM `manager_chapter`
								INNER JOIN manager_exam on manager_exam.chapter_id_exam = manager_chapter.id
								WHERE manager_exam.chapter_id_exam = $data_id";
            $result1 = $conn->query($sql1);
						while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
              $sum_exam =  $row1['sum_exam'];
            }
          $num_sum_exam = strlen($sum_exam);
				?>
						<div class="card-header">
						<div class="row">
						<div id="empty_bar<?php echo $a; ?>" class="col-sm-12" >


              <input class="no-collapsable" type="checkbox" id="Check_All1<?php echo $a; ?>" onclick="check_unCheck_All11<?php echo $a; ?>()">
              <i href="#collapse<?php echo $list;?>" role="button" data-toggle="collapse" class="fas fa-table" id="txt_chapter<?php echo $i;?>"><a href="#collapse<?php echo $list;?>" role="button" data-toggle="collapse"> <?php echo $data_name_chapter; ?> </a></i>
              (<?php echo $sum_exam; ?>ข้อ)

            </div>




						</div>
						</div>
          <div id="collapse<?php echo $list;?>" class="panel-collapse collapse">
            <div class="form-check-inline mx-2 my-2" id="input_custom<?php echo $a; ?>">
                ตั้งแต่ข้อ&nbsp;
                <input id="myInput1<?php echo $a; ?>" onchange="limit1<?php echo $a; ?>(this);" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" style="width:70px" type="text" class="form-control" name="">&nbsp;ถึง&nbsp;
                <input id="myInput12<?php echo $a; ?>" onchange="limit2<?php echo $a; ?>(this);" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" style="width:70px" type="text" class="form-control" name="">

            </div>
            <script>
                    function limit1<?=$a?>(input1)
                    {
                        var x;
                        var max_chars = 1;
                        var maxinput = parseInt(<?=$sum_exam?>);
                        var number = parseInt(document.getElementById("myInput1<?=$a;?>").value);
                        var max = parseInt(document.getElementById("myInput12<?=$a;?>").value);


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
                          document.getElementById("id<?php echo $a ?>"+x).checked = false;
                          document.getElementById("id<?php echo $a ?>"+x).disabled  = true;
                        }
                        for(x=number;x<=max;x++){
                          document.getElementById("id<?php echo $a ?>"+x).checked = true;
                          document.getElementById("id<?php echo $a ?>"+x).disabled  = false;
                        }

                        if(document.getElementById("myInput1<?=$a;?>").value == '' && document.getElementById("myInput12<?=$a;?>").value == ''){
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
                      var number = parseInt(document.getElementById("myInput12<?=$a;?>").value);
                      var min = parseInt(document.getElementById("myInput1<?=$a;?>").value);


                      if(number > maxinput){
                          document.getElementById("myInput12<?=$a;?>").value = maxinput;
                          number = maxinput;
                      }else if(number == '0'){
                          document.getElementById("myInput12<?=$a;?>").value = 1;
                          number = 1;
                      }
                      if(number<min){
                        document.getElementById("myInput12<?=$a;?>").value = min;
                        number = min;
                      }
                      for(x=1;x<=maxinput;x++){
                        document.getElementById("id<?=$a;?>"+x).checked = false;
                        document.getElementById("id<?=$a;?>"+x).disabled  = true;
                      }
                      for(x=min;x<=number;x++){
                        document.getElementById("id<?=$a;?>"+x).checked = true;
                        document.getElementById("id<?=$a;?>"+x).disabled  = false;
                        document.getElementById("Check_All1<?=$a;?>").checked = true;;
                      }

                      if(document.getElementById("myInput1<?=$a;?>").value == '' && document.getElementById("myInput12<?=$a;?>").value == ''){
                        for(x=1;x<=maxinput;x++){
                          document.getElementById("id<?=$a;?>"+x).disabled  = false;
                        }
                      }
                    }


            </script>


              <table class="table table-bordered" id="dataTable1" width="50%" cellspacing="0">
                  <tr>
                    <th width="5%">
                      เลือก
                    </th>

                    <th  width="95%">โจทย์</th>
                  </tr>

				  <?php


						$sql1 = "SELECT manager_exam.id,manager_exam.proposition_exam FROM `manager_chapter`
								INNER JOIN manager_exam on manager_exam.chapter_id_exam = manager_chapter.id
								WHERE manager_exam.chapter_id_exam = $data_id";
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
        					<input onclick="check_up1<?php echo $a; ?>()" id="id<?php echo $a.$b; ?>" <?php if($manager=="edit"){
        										$arr_list_series_exam = explode(',',$list_series_exam);
        										for ($i=0; $i < count($arr_list_series_exam); $i++) {
        						                  $id = $arr_list_series_exam[$i];
        												if($id == $exam_id){
        													echo "checked";
        													}
        									 }
        					}
        					?> type="checkbox" name="num_exam_value1[]" value="<?php echo $exam_id; ?>"></input>
            </td>
            <td>ข้อที่ <?php echo ($num_chapter++)."). ".$proposition_exam; ?></td>
        </tr>
							<?php $b++; }
            }?>


                </table>



                <script>
                </script>
              </div>
              <script>
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
	function check_unCheck_All11<?php echo $a; ?>(){
		 var checkedVal = document.getElementById("Check_All1<?php echo $a; ?>");
		 <?php
						$sql1 = "SELECT manager_exam.id,manager_exam.proposition_exam FROM `manager_chapter`
									INNER JOIN manager_exam on manager_exam.chapter_id_exam = manager_chapter.id
									WHERE manager_exam.chapter_id_exam = $data_id";
							$result1 = mysqli_query($conn, $sql1);
							$i = 1;
							while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
		 ?>
	 if(checkedVal.checked==true){
			document.getElementById("id<?php echo $a.$i; ?>").checked = true;


	 }else{
			document.getElementById("id<?php echo $a.$i; ?>").checked = false;

	 }

	<?php $i++; }?>
	}

	<?php $a++; } ?>

	</script>



	<script type="text/javascript">
	 var befor_max = 0;
	 var cout=1;
	 var xxx = <?=$sum_exam?>;

	<?php
				$sql = "SELECT * FROM `manager_chapter` WHERE name_name_subject = '$id_subject' ORDER BY `manager_chapter`.`id` ASC";
							$result = mysqli_query($conn, $sql);
							$a = 0;
							while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
								$data_id =  $row['id'];
	              $sql1 = "SELECT manager_exam.id,manager_exam.proposition_exam FROM `manager_chapter`
	    								INNER JOIN manager_exam on manager_exam.chapter_id_exam = manager_chapter.id
	    								WHERE manager_exam.chapter_id_exam = $data_id";
	    						$result1 = mysqli_query($conn, $sql1);
	    						$i = 1;

	 ?>
	function check_up1<?php echo $a; ?>(){
		 var checkedVal = document.getElementById("Check_All1<?php echo $a; ?>");
		 <?php
						$sql1 = "SELECT manager_exam.id,manager_exam.proposition_exam FROM `manager_chapter`
									INNER JOIN manager_exam on manager_exam.chapter_id_exam = manager_chapter.id
									WHERE manager_exam.chapter_id_exam = $data_id";
							$result1 = mysqli_query($conn, $sql1);
							$i = 1;
							while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
		 ?>

	   if(document.getElementById("id<?php echo $a.$i; ?>").checked == true){
	     checkedVal.checked = true;

	   }
	   if(document.getElementById("id<?php echo $a.$i; ?>").checked == false){
	     document.getElementById("myInput1<?php echo $a; ?>").value = null;
	     document.getElementById("myInput12<?php echo $a; ?>").value = null;
	     var x;
	     var maxinput = <?=$sum_exam;?>;



	   }


	<?php $i++; }?>
	cout++;
	}

	<?php $a++; }
	?>


	</script>



	<script type="text/javascript">

	<?php
	$sql = "SELECT * FROM `manager_chapter` WHERE name_name_subject = '$id_subject' ORDER BY `manager_chapter`.`id` ASC";
	      $result = mysqli_query($conn, $sql);
	      $a = 0;
	      while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
	        $data_id =  $row['id'];
	?>
	var checkedVal = document.getElementById("Check_All1<?php echo $a; ?>");
	<?php
	    $sql1 = "SELECT manager_exam.id,manager_exam.proposition_exam FROM `manager_chapter`
	          INNER JOIN manager_exam on manager_exam.chapter_id_exam = manager_chapter.id
	          WHERE manager_exam.chapter_id_exam = $data_id";
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
