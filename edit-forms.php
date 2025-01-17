<?php
$title = "Edit";
$css_link = "";
$jquery = true;
$auth = true;
$filter = false;
require_once('./php/require/header.php');
?>

<body>
  <?php
  include './php/require/navbar.php';
  if (!isset($_GET['edit'])) {
    header("Location:" . $_SERVER['HTTP_REFERER']);
  }
  ?>
  <div class="container vh-100">
    <div class="row vh-100 justify-content-center pt-5">
      <div class="form-group">
        <h2 class="text-center">Edit <?php echo $_GET['edit'] ?></h2>
        <form id="login" method="POST" class="col-12" action="<?php echo htmlentities('./php/update-data.php'); ?>">
          <?php
          if (empty($_GET['edit'])) {
            //header to last location 
            header("Location: " . $_SERVER['HTTP_REFERER']);
          }
          if (isset($_GET['edit'])) {
            if ($_GET['edit'] == 'course') {
              $result = DB::query("SELECT * FROM course WHERE course_id = %s", $_GET['course_id']);
              if ($result) {

                echo "<input type='hidden' name='edit' value='course'>";
                echo "<label for='course_id' class='form-label'>Course ID</label>";
                echo "<input type='text' class='form-control' id='course_id' name='course_id' value='" . $result[0]['course_id'] . "' readonly>";
                echo "<label for='course_name' class='form-label'>Course Name</label>";
                echo "<input type='text' class='form-control' id='course_name' name='course_name' value='" . $result[0]['course_name'] . "'>";
              } else {
                header("Location: ./course-manage.php");
              }
            } else if ($_GET['edit'] == 'room') {
              $result = DB::query("SELECT * FROM room WHERE room_id = %s", $_GET['room_id']);
              if ($result) {
                echo "<input type='hidden' name='edit' value='room'>";
                echo "<label for='room_id' class='form-label'>Room ID</label>";
                echo "<input type='text' class='form-control' id='room_id' name='room_id' value='" . $result[0]['room_id'] . "' readonly>";
                echo "<label for='room_code' class='form-label'>Room Code</label>";
                echo "<input type='text' class='form-control' id='room_code' name='room_code' value='" . $result[0]['room_code'] . "'>";
                echo "<label for='room_name' class='form-label'>Room Name</label>";
                echo "<input type='text' class='form-control' id='room_name' name='room_name' value='" . $result[0]['room_name'] . "'>";
                echo "<label for='room_category' class='form-label'>Room Category</label>";
                echo "<select class='form-select' id='room_category' name='room_category'>";
                echo "<option value='Lecture Room'" . ($result[0]['room_category'] == 'Lecture Room' ? ' selected' : '') . ">Lecture Room</option>";
                echo "<option value='Lab Room'" . ($result[0]['room_category'] == 'Lab Room' ? ' selected' : '') . ">Lab Room</option>";
                echo "</select>";
                echo "<label for='room_location' class='form-label'>Room Location</label>";
                echo "<select class='form-select' id='room_location' name='room_location'>";
                echo "<option value='Main'" . ($result[0]['room_location'] == 'Main' ? ' selected' : '') . ">Main</option>";
                echo "<option value='Annex'" . ($result[0]['room_location'] == 'Annex' ? ' selected' : '') . ">Annex</option>";
                echo "</select>";
              } else {
                header("Location: ./room-manage.php");
              }
            } else if ($_GET['edit'] == 'section') {
              $fields = array('section_id', 'section_name', 'section_year', 'course_id');
              $result = DB::query("SELECT * FROM section WHERE section_id = %s", $_GET['section_id']);
              if ($result) {
                echo "<input type='hidden' name='edit' value='section'>";
                echo "<label for='section_id' class='form-label'>Section ID</label>";
                echo "<input type='text' class='form-control' id='section_id' name='section_id' value='" . $result[0]['section_id'] . "' readonly>";
                echo "<label for='section_name' class='form-label'>Section Name</label>";
                echo "<input type='text' class='form-control' id='section_name' name='section_name' value='" . $result[0]['section_name'] . "'>";
                echo "<label for='section_year' class='form-label'>Section Year</label>";
                echo "<select class='form-select' id='section_year' name='section_year'>";
                echo "<option value='1'" . ($result[0]['section_year'] == '1' ? ' selected' : '') . ">1</option>";
                echo "<option value='2'" . ($result[0]['section_year'] == '2' ? ' selected' : '') . ">2</option>";
                echo "<option value='3'" . ($result[0]['section_year'] == '3' ? ' selected' : '') . ">3</option>";
                echo "<option value='4'" . ($result[0]['section_year'] == '4' ? ' selected' : '') . ">4</option>";
                echo "</select>";
                echo "<label for='course_year' class='form-label'>Course</label>";
                echo "<select class='form-select' id='course_id' name='course_id'>";
                $course = DB::query("SELECT * FROM course");
                foreach ($course as $row) {
                  echo "<option value='" . $row['course_id'] . "'" . ($result[0]['course_id'] == $row['course_id'] ? ' selected' : '') . ">" . $row['course_name'] . "</option>";
                }
                echo "</select>";
              } else {
                header("Location: ./section-manage.php");
              }
            } else if ($_GET['edit'] == 'schedule') {
              $result = DB::query("select * from `scheduling table` where `schedule_id` = %s", $_GET['schedule_id']);
              if ($result) {
                echo "<input type='hidden' name='edit' value='schedule'>";
                echo "<label for='schedule_id' class='form-label'>Schedule ID</label>";
                echo "<input type='text' class='form-control' id='schedule_id' name='schedule_id' value='" . $result[0]['schedule_id'] . "' readonly>";
                echo "<label for='section_id' class='form-label'>Section</label>";
                echo "<select class='form-select' id='section_id' name='section_id'>";
                $section = DB::query("SELECT * FROM section");
                foreach ($section as $row) {
                  echo "<option value='" . $row['section_id'] . "'" . ($result[0]['section_id'] == $row['section_id'] ? ' selected' : '') . ">" . $row['section_name'] . "</option>";
                }
                echo "</select>";
                //semester_id
                echo "<label for='semester_id' class='form-label'>Semester</label>";
                echo "<select class='form-select' id='semester_id' name='semester_id'>";
                $semester = DB::query("SELECT * FROM semester");
                foreach ($semester as $row) {
                  echo "<option value='" . $row['semester_id'] . "'" . ($result[0]['semester_id'] == $row['semester_id'] ? ' selected' : '') . ">" . $row['semester'] . "</option>";
                }
                echo "</select>";
                //subject id
                echo "<label for='subject_id' class='form-label'>Subject</label>";
                echo "<select class='form-select' id='subject_id' name='subject_id'>";
                echo "</select>";
                echo "<label for='room_id' class='form-label'>Room</label>";
                echo "<select class='form-select' id='room_id' name='room_id'>";
                $room = DB::query("SELECT * FROM room");
                foreach ($room as $row) {
                  echo "<option value='" . $row['room_id'] . "'" . ($result[0]['room_id'] == $row['room_id'] ? ' selected' : '') . ">" . $row['room_code'] . "</option>";
                }
                echo "</select>";
                //day_id
                echo "<label for='day_id' class='form-label'>Day</label>";
                echo "<select class='form-select' id='day_id' name='day_id'>";
                $day = DB::query("SELECT * FROM day");
                foreach ($day as $row) {
                  echo "<option value='" . $row['day_id'] . "'" . ($result[0]['day_id'] == $row['day_id'] ? ' selected' : '') . ">" . $row['day'] . "</option>";
                }
                echo "</select>";
                //schedule_start-time
                echo "<label for='schedule_start_time' class='form-label'>Start Time</label>";
                $start_time = new Display();
                echo "<select class='form-select' id='schedule_start_time' name='schedule_start_time'>";
                $start_time->displayTimeSelected("07:00", "21:00", "+30 minutes", $result[0]['schedule_start_time']);
                echo "</select>";
                //schedule_end-time
                echo "<label for='schedule_end_time' class='form-label'>End Time</label>";
                $end_time = new Display();
                echo "<select class='form-select' id='schedule_end_time' name='schedule_end_time'>";
                $end_time->displayTimeSelected("07:00", "21:00", "+30 minutes", $result[0]['schedule_end_time']);
                echo "</select>";
                echo "<script src='./javascript/scheduling.js?=v1'></script>";
              } else {
                header("Location: ./scheduling.php");
              }
            } else if ($_GET['edit'] == 'subject') {
              $fields = array('subject_id', 'course_id', 'semester_id', 'subject_code', 'subject_name', 'lecture_hr', 'laboratory_hr');
              $result = DB::query("SELECT * FROM subject WHERE subject_id = %s", $_GET['subject_id']);
              if ($result) {
                echo "<input type='hidden' name='edit' value='subject'>";
                echo "<label for='subject_id' class='form-label'>Subject ID</label>";
                echo "<input type='text' class='form-control' id='subject_id' name='subject_id' value='" . $result[0]['subject_id'] . "' readonly>";
                echo "<label for='course_id' class='form-label'>Course</label>";
                echo "<select class='form-select' id='course_id' name='course_id'>";
                $course = DB::query("SELECT * FROM course");
                foreach ($course as $row) {
                  echo "<option value='" . $row['course_id'] . "'" . ($result[0]['course_id'] == $row['course_id'] ? ' selected' : '') . ">" . $row['course_name'] . "</option>";
                }
                echo "</select>";
                echo "<label for='semester_id' class='form-label'>Semester</label>";
                echo "<select class='form-select' id='semester_id' name='semester_id'>";
                $semester = DB::query("SELECT * FROM semester");
                foreach ($semester as $row) {
                  echo "<option value='" . $row['semester_id'] . "'" . ($result[0]['semester_id'] == $row['semester_id'] ? ' selected' : '') . ">" . $row['semester'] . "</option>";
                }
                echo "</select>";
                echo "<label for='subject_code' class='form-label'>Subject Code</label>";
                echo "<input type='text' class='form-control' id='subject_code' name='subject_code' value='" . $result[0]['subject_code'] . "'>";
                echo "<label for='subject_name' class='form-label'>Subject Name</label>";
                echo "<input type='text' class='form-control' id='subject_name' name='subject_name' value='" . $result[0]['subject_name'] . "'>";
                echo "<label for='lecture_hr' class='form-label'>Lecture Hours</label>";
                echo "<input type='number' class='form-control' id='lecture_hr' name='lecture_hr' value='" . $result[0]['lecture_hr'] . "'>";
                echo "<label for='laboratory_hr' class='form-label'>Laboratory Hours</label>";
                echo "<input type='number' class='form-control' id='laboratory_hr' name='laboratory_hr' value='" . $result[0]['laboratory_hr'] . "'>";
              } else {
                header("Location:./subject-manage.php");
              }
            }
          }
          ?>
          <div class="form-group text-center pt-3">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>

        </form>
      </div>
    </div>
  </div>

</body>

</html>