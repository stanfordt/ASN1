<?php 
  require_once('database.php');
  $SemesterID = $_POST['semesterSelect'];
  

    $query = "SELECT DISTINCT Subjects.SubjectAbbr
              FROM Classes, Subjects, Semesters
              WHERE Semesters.SemesterID = ?
              AND Classes.SubjectID = Subjects.SubjectID
              AND Classes.SemesterID = Semesters.SemesterID";

    
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $SemesterID);
    $stmt->execute();
    $stmt->store_result();
    // Three variables we will bind the results to
    $stmt->bind_result($SubjectAbbr);
  

?>
<?php 

  $SelectedSub = $_POST['subjectSelect'];
  

    $query2 = "SELECT CRN, Section, Days, ClassTime, Locations.Building, Locations. RoomNum, Instructors.LastName, Instructors.FirstName
                FROM Classes, Locations, Courses, Instructors, Subjects
                WHERE Classes.SubjectID = Subjects.SubjectID
                AND Subjects.SubjectAbbr = ?
                AND Classes.CourseID = Courses.CourseID
                AND Classes.InstructorID = Instructors.InstructorID
                AND Classes.LocationID = Locations.LocationID;";

    
    $stmt2= $db->prepare($query2);
    $stmt2->bind_param('s', $SelectedSub);
    $stmt2->execute();
    $stmt2->store_result();
    // Three variables we will bind the results to
    $stmt2->bind_result($CRN, $Section, $Days, $ClassTime, $Building, $RoomNum, $LastName, $FirstName);
  

?>



<p><?php include 'header.php'; ?></p>

    <div id="header">
        <h1>Class Lookup</h1>
    </div>

    <div id="main">

        <h1>Semester Availability</h1>

        <div id="content">
            <!-- display a list of customers -->
            
            <h3>Please choose a semester to display the subjects.</h3>
            <form name="semesterSelect" method="POST" action="index.php">
              <select name="semesterSelect" required>
                <option value="">Select...</option>
                <option value="1" <?php echo isset($_POST['semesterSelect']) && $_POST['semesterSelect'] == 1 ? "selected" : "" ?>>Spring</option>
                <option value="2" <?php echo isset($_POST['semesterSelect']) && $_POST['semesterSelect'] == 2 ? "selected" : "" ?>>Summer</option>
                <option value="3" <?php echo isset($_POST['semesterSelect']) && $_POST['semesterSelect'] == 3 ? "selected" : "" ?>>Fall</option>
              </select>
              <input type ="submit">
            </form>
            <?php if(isset($SemesterID)) { ?>
            <form name="subjectSelect" method="POST" action="index.php">
                <select name="subjectSelect" required>
                    
                    <?php
                    echo '<option value="">Select...</option>';
                    while($stmt->fetch()) 
                    {
                        echo '<option value="'.$SubjectAbbr.'">'.$SubjectAbbr.'</option>';
                        $value = $value + 1;
                    } 
                    ?>
                </select>
                <input type="submit">
            </form>
             <?php } ?>
             
             
            <?php if(isset($SelectedSub)) { ?>
                <table>
                <tr>
                    <th>CRN</th>
                    <th>Section</th>
                    <th>Days</th>
                    <th>Meeting Time</th>
                    <th>Building</th> 
                    <th>Room #</th>
                    <th>Instructor Last Name</th>
                    <th>Instructor First Name</th>
                </tr>
                <?php while ($stmt2->fetch()) { ?>
                <tr>
                    <!-- echo all results to table rows -->
                    <td><?php echo $CRN; ?></td>
                    <td><?php echo $Section; ?></td>
                    <td><?php echo $Days; ?></td>
                    <td><?php echo $ClassTime; ?></td>
                    <td><?php echo $Building; ?></td>
                    <td><?php echo $RoomNum; ?></td>
                    <td><?php echo $FirstName; ?></td>
                    <td><?php echo $LastName; ?></td>
                </tr>
                <!-- result set is available -->

                <?php }
                    $stmt->free_result();
                    $db->close();
                ?>
                    
            </table>
             <?php } ?>
             
            </br>
        </div>
    </div>

 <!-- shared footer information comes from include file -->
        <p><?php include 'footer.php'; ?></p>