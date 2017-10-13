<?php 
  require_once('database.php');
  $action = "semester";
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