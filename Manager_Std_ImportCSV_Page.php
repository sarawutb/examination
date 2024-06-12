<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CSV File Import</title>
    <!-- Add DataTables CSS -->
</head>
<style>
    * {
      box-sizing: border-box;
      -moz-box-sizing: border-box;
      -webkit-box-sizing: border-box;
    }

    .wrapper {
      margin: auto;
      max-width: 640px;
      text-align: center;
    }

    .upload-container {
      background-color: rgb(239, 239, 239);
      border-radius: 6px;
      padding: 10px;
    }

    .border-container {
      border: 5px dashed rgba(198, 198, 198, 0.65);
      /*   border-radius: 4px; */
      padding: 20px;
    }

    .border-container p {
      color: #130f40;
      font-weight: 600;
      font-size: 1.1em;
      letter-spacing: -1px;
      margin-top: 30px;
      margin-bottom: 0;
      opacity: 0.65;
    }

    #file-browser {
      text-decoration: none;
      color: rgb(22, 42, 255);
      border-bottom: 3px dotted rgba(22, 22, 255, 0.85);
    }

    #file-browser:hover {
      color: rgb(0, 0, 255);
      border-bottom: 3px dotted rgba(0, 0, 255, 0.85);
    }

    .icons {
      color: #95afc0;
      opacity: 0.55;
    }
</style>
<body>
    <!--<form action="Manager_Std_Sql.php" method="post" enctype="multipart/form-data">-->
    <div class="wrapper">
        <div class="container">
            <div class="upload-container">
                <div class="border-container">
                    <div class="icons fa-4x">
                        <i class="fas fa-file-csv" data-fa-transform="shrink-1 down-2 right-6 rotate-45"></i>
                    </div>
                    <div id="nameFile">
                        <h3 id="fileName"></h3>
                        <button type="button" name="UploadCSVStd" id="btnSave" class="btn btn-success btn-sm">
                            <i style="font-size: 15px" class="fas">บันทึก</i>
                        </button>
                        <button type="button" id="btnCancel" class="btn btn-danger btn-sm">
                            <i style="font-size: 15px" class="fas">ยกเลิก</i>
                        </button>
                    </div>
                    <input hidden type="file" name="csvFileInput" id="csvFileInput" accept=".csv,.txt" style="display: none" />
                    <p>
                        กรุณา
                        <a href="#">
                            <label for="csvFileInput" class="file-input-button">เลือกไฟล์</label>
                        </a>
                        สกุล CSV.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!--</form>-->


    <div class="container-fulid" id="formTabel">
        <table class="table table-bordered" id="dataTableImportFile" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th width="5%">ลำดับ</th>
                    <th width="15%">รหัสนักศึกษา</th>
                    <th width="20%">ชื่อ-นามสกุล</th>
                    <th width="15%">สาขา</th>
                    <th width="10%">ระดับการศึกษา</th>
                    <th width="10%">ระดับชั้น</th>
                    <th width="10%">ห้องเรียน</th>
                    <th width="10%">รหัสผ่าน</th>
                    <th width="10%">เพศ</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                <!-- Table will be populated here -->
            </tbody>
        </table>
    </div>

    <!-- Add DataTables JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <?php
    $i = 1;
    $sql = "SELECT b.branch_id,b.branch_name FROM `manager_branch` as b;";
    $result = mysqli_query($conn, $sql);
    //$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $row = $result -> fetch_all(MYSQLI_NUM);
    $jsonBranch = json_encode($row);
    ?>
    <script>
    const jsonBranch = <?=$jsonBranch;?>;
    const LIMIT_CELL_CSV = 8;
    const CELL_1_NUMBER = 0;
    const CELL_2_STD_NO = 1;
    const CELL_3_FULLNAMME_STD = 2;
    const CELL_4_BRANCH = 3;
    const CELL_4_DEEGREE = 4;
    const CELL_5_LEVEL = 5;
    const CELL_6_CLASS = 6;
    const CELL_7_PASSWORD_STD = 7;
    const CELL_8_GENDER = 8;

    $("#nameFile").hide();
    $("#formTabel").hide();
    document.getElementById("csvFileInput").addEventListener("change", function () {
        const file = this.files[0];
        if (file) {
            console.log(file);
            $("#fileName").html(file.name);
            const reader = new FileReader();
            reader.readAsText(file);
            reader.onload = function (e) {
                try {
                    const csv = e.target.result;
                    const rows = csv.split("\n");
                    const table = document.getElementById("dataTableImportFile");
                    const tbody = table.getElementsByTagName("tbody")[0];
                    tbody.innerHTML = ""; // Clear previous table data
                    var number = 0;
                    rows.forEach((row) => {
                        var index = 1;
                        const cells = row.split(",");
                        const newRow = tbody.insertRow();
                        const newCell1 = newRow.insertCell();
                        newCell1.appendChild(document.createTextNode(++number));
                        var Chk = validaeCellCSV(cells);
                        if (Chk) {
                            cells.forEach((cell) => {
                                const newCell = newRow.insertCell();
                                var str = cell.replace(/"/g, '');
                                if (index == CELL_4_DEEGREE) {
                                    if (str == 1) {
                                        newCell.appendChild(document.createTextNode("ปวช."));

                                    } else {
                                        newCell.appendChild(document.createTextNode("ปวส."));
                                    }
                                } else if (index == CELL_8_GENDER) {
                                    if (str == 1) {
                                        newCell.appendChild(document.createTextNode("ชาย"));

                                    } else {
                                        newCell.appendChild(document.createTextNode("หญิง"));
                                    }
                                }
                                else if (index == CELL_4_BRANCH) {
                                    newCell.appendChild(document.createTextNode(FindBrannchName(str)));

                                } else {
                                    newCell.appendChild(document.createTextNode(str));
                                }
                                index++;
                            });
                        } else {
                            throw "รูปแบบไฟล์ไม่ถูกต้อง";
                        }
                    });

                    // Initialize DataTables
                    $(document).ready(function () {
                        $("#nameFile").show();
                        $("#formTabel").show();
                        $("#dataTableImportFile").DataTable();
                    });
                } catch (err) {
                    CancelFile();
                    alert("รูปแบบไฟล์ไม่ถูกต้อง");
                }
            };
        }
    });

    $("#btnCancel").on("click", function () {
        CancelFile();
    });

    $("#btnSave").on("click", function () {
        var fileInput = document.getElementById("csvFileInput");
        AddCSVStd(fileInput);
    });

    function CancelFile() {
        $("#fileName").html(null);
        $("#formTabel").hide();
        $("#nameFile").hide();
        const table = document.getElementById("dataTableImportFile");
        const tbody = table.getElementsByTagName("tbody")[0];
        tbody.innerHTML = "";
        $("#dataTableImportFile").DataTable().destroy();
        //$('#dataTableImportFile').dataTable().fnClearTable();
        document.getElementById("csvFileInput").value = null;
    }

    function validaeCellCSV(cells) {
        if (cells.length > LIMIT_CELL_CSV) {
            return false;
        }
        else {
            return true;
        }
    }

    function FindBrannchName(id) {
        var BranchName = null;
        BranchNameLst = jsonBranch.find((element) => element[0] == id);
        if (BranchNameLst.length > 0) {
            BranchName = BranchNameLst[1];
        }
        return BranchName;
    }

    function AddCSVStd(fileInput) {
        var form = new FormData();
        form.append("UploadCSVStd", "UploadCSVStd");
        form.append("csvFileInput", fileInput.files[0]);

        var settings = {
            "url": "Manager_Std_Sql.php",
            "method": "POST",
            "timeout": 1000 * 60,
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form
        };

        $.ajax(settings).done(function (response) {
            try {
                var res = JSON.parse(response);
                if (res != undefined) {
                    if (res.code == 200) {
                        alert("ทำรายการสำเร็จ");
                        CancelFile();
                    } else {
                        throw new Error(res.msg);
                    }
                }
            } catch (ex) {
                alert(ex.message);
            }
        }).fail(function (xhr, textStatus, errorThrown) {
            alert(xhr.responseText);

        });
    }
    </script>
</body>
</html>
