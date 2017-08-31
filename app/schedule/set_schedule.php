<?php include('../../Includes/database.php') ?>
<?php include('../../Includes/functions.php') ?>
<?php session_start(); ?>
<?php isLogin() ?>	
<?php

	if (isset($_GET['update']) ) {
		$_SESSION['success'] = "Room $_GET[update] Schedule Updated Successfully";
		
	}
	if(isset($_POST['submit'])) {
		if (empty($_POST['room_no']) && empty($_POST['room_name']) && empty($_POST['room_level'])){
			$_SESSION['error'] = "All Fields Is Required";
		}else if (empty($_POST['room_no'])) {
			$_SESSION['error'] = "Room No Is Required";
		}else if (empty($_POST['room_name'])) {
			$_SESSION['error'] = "Room Name Is Required";
		}else if (empty($_POST['room_level'])) {
			$_SESSION['error'] = "Room Level Is Required";
		}else {
			$room_no = mysqli_real_escape_string($con,$_POST['room_no']);
			$room_name = mysqli_real_escape_string($con,$_POST['room_name']);
			$room_level = mysqli_real_escape_string($con,$_POST['room_level']);
			$dateTime = getDateTime();
			$sql = "INSERT INTO room (room_number,room_name,floor_level,date_added) VALUES('$room_no','$room_name','$room_level','$dateTime')";

			$exec = mysqli_query($con,$sql);
			if ($exec) {
				$_SESSION['success'] = "Room Added Successfully";
			}else {
				$_SESSION['error'] = "Opps.. Something Went Wrong please try again";
				printf(mysqli_error($con));
			}

		}
	}

	if (isset($_POST['update_sched'])) {
		if (empty($_POST['subject_name'])) {
			$_SESSION['error'] = "Subject Name is Required";
 		}else if (empty($_POST['day'])){
 			$_SESSION['error'] = "Day is Required";
		}else if (empty($_POST['start_time'])) {
			$_SESSION['error'] = "Start Time is Required";
		}else if (empty($_POST['end_time'])) {
			$_SESSION['error'] = "End Time is Required";
		}
	}
?>
<!DOCTYPE html>
<html>
<?php include('../layout/head.php') ?>
<body>
<div class="header">
	<div class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<a href="" class="navbar-brand">Classroom Management System</a>
			</div>
		</div>
	</div>
</div>
<?php include('../layout/navigation.php') ?>
<div class="container">
<div class="row">
	<div class="col-md-12 set-schedule-main">
		<div class="row">

			<?php
			if (!isset($_GET['room_no'])) {
				?>
				<div class="set-schedule-header">
				Select Room To Set Schedule
				</div>
				<div class="col-md-12 room-wrapper"  >
					<?php echo successMessage() ?>
					<?php echo errorMessage() ?>
					<?php
					$sql = "SELECT * FROM room ORDER BY room_number";
					$exec = mysqli_query($con,$sql);
					while ($row = mysqli_fetch_assoc($exec)) {
						?>
						<div class="col-md-2 room-box">
							<div class="room-box-content bg-success">
								<div class="room-number text-center">
									Room <?php echo $row['room_number'] ?>
								</div>	
								<div class="room-description text-center">
									<p>Status: <span style="color: green">Available</span></p>
									<a href="set_room_schedule.php?room_no=<?php echo $row['room_number'] ?>&id=<?php echo $row['room_id'] ?>">

										<button class="btn btn-success ">New Schedule</button>
									</a>
								</div>
							</div>
						</div>

						<?php
					}
					?>

				</div>

				<?php
			}
			?>
			
		</div>
	</div>
</div>

</div>
</body>
</html>