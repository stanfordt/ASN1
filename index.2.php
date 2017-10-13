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
              <select name="semesterSelect">
                <option value="">Select...</option>
                <option value="1">Spring</option>
                <option value="2">Summer</option>
                <option value="3">Fall</option>
              </select>
              </br>
              <input type ="submit">
              </form>
            <div class="table">
            <table>
                <tr>
                    <th>Subject</th>
                </tr>
                <?php while ($stmt->fetch()) { ?>
                <tr>
                    <td><?php echo $SubjectAbbr; ?></td>
              
                </tr>

                <!-- result set is available -->

                  <?php } 
    $stmt->free_result();
    $db->close();?>
                    
            </table>
                
                
                
                
            </div>
            </br>
        </div>
    </div>

 <!-- shared footer information comes from include file -->
        <p><?php include 'footer.php'; ?></p>