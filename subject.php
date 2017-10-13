<?php 
  require_once('database.php');

  $SubjectAbbr = $_POST['subjectSelect'];
  

    $query1 = "SELECT CRN, Section, Days, ClassTime, Locations.Building, Locations. RoomNum, Instructors.LastName, Instructors.FirstName
                FROM Classes, Locations, Courses, Instructors, Subjects
                WHERE Classes.SubjectID = Subjects.SubjectID
                AND Subjects.SubjectAbbr = ?
                AND Classes.CourseID = Courses.CourseID
                AND Classes.InstructorID = Instructors.InstructorID
                AND Classes.LocationID = Locations.LocationID;";

    
    $stmt1= $db->prepare($query1);
    $stmt1->bind_param('s', $SubjectAbbr);
    $stmt1->execute();
    $stmt1->store_result();
    // Three variables we will bind the results to
    $stmt1->bind_result($CRN, $Section, $Days, $ClassTime, $Building, $RoomNum, $LastName, $FirstName);
  

?>\

<?php while ($stmt->fetch()) { ?>
                <tr>
                    <td><?php echo $SubjectAbbr; ?></td>
              
                </tr>

                <!-- result set is available -->

                  <?php } 
    $stmt->free_result();
    $db->close();?>