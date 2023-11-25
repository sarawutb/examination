<style>
.dotaddmin {
  height: 10px;
  width: 10px;
  background-color: #51E842;
  border-radius: 50%;
  display: inline-block;
}
.dotth {
  height: 10px;
  width: 10px;
  background-color: #42A7E8;
  border-radius: 50%;
  display: inline-block;
}
</style>
  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="">ระบบข้อสอบออนไลน์</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>


    <!-- Navbar Search -->
    <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
     <?php if($status_teacher==1){
							echo '<font color="white"><span class="dotaddmin"></span> สถานะ : แอดมิน</font>';
								}else{
									echo '<font color="white"><span class="dotth"></span> สถานะ : อาจารย์</font>';
								}
						?>
    </div>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">

      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php if($data_name_teacher_subject==null){ header("location:Login.php"); }else{echo $data_name_teacher_subject;} ?> <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#myAccount">บัญชี</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">ออกจากระบบ</a>
        </div>
      </li>
    </ul>

  </nav>
