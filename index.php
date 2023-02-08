<?php 


$servername = "localhost:3306";
$username = "";
$password = "";
$dbname = "";
$duplicate=0;
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if($_POST["form_submit"]=="1")
{
    // insert to db
    $sql = "SELECT * FROM country";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
        $duplicate = 1;
        }
        else {
    $sql = "INSERT INTO layoff_data_2023 set name='".$_POST["name"]."', email_id='".$_POST["email"]."', 
    country='".$_POST["country"]."', company='".$_POST["company"]."', department='".$_POST["department"]."',date_time='".Date('Y-m-d H:i:s',time())."'
    ,remote_addr='".$_SERVER["REMOTE_ADDR"]."'";
    $conn->query($sql);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>2023 layoff DB</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css
" rel="stylesheet"></link>
    
      <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Country', 'Layoffs'],
          <?php 
            $sql1 = "select t2.country_name as country_name, t2.id,(select count(name) from layoff_data_2023 as t1 where t1.country=t2.id) as cnt from country as t2";
            $result1 = $conn->query($sql1);
            $numr1 = $result1->num_rows;
            if ($numr1 > 0) {
              // output data of each row
              while($row = $result1->fetch_assoc()) { 
                $i++;
                if($i==$numr)
                {
                  ?>
                  ['<?php echo $row["country_name"] ?>',<?php echo $row["cnt"]; ?>]
                  <?php
                }
                else 
                {
                  ?>
                  ['<?php echo $row["country_name"] ?>',<?php echo $row["cnt"]; ?>],
                  <?php
                }
                
              }
            }
          ?>
        ]);

        var options = {
          chart: {
            title: 'Country Performance',
            subtitle: 'Layoff 2023',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));

        var data1 = google.visualization.arrayToDataTable([
          ['Companies', 'Layoffs'],
          <?php 
            $sql1 = "select t2.company_name as company_name, t2.id, (select count(name) from layoff_data.layoff_data_2023 
as t1 where t1.company=t2.id) as cnt from layoff_data.companies_data as t2;";
            $result1 = $conn->query($sql1);
            $numr1 = $result1->num_rows;
            if ($numr1 > 0) {
              // output data of each row
              while($row = $result1->fetch_assoc()) { 
                $i++;
                if($i==$numr)
                {
                  ?>
                  ['<?php echo $row["company_name"] ?>',<?php echo $row["cnt"]; ?>]
                  <?php
                }
                else 
                {
                  ?>
                  ['<?php echo $row["company_name"] ?>',<?php echo $row["cnt"]; ?>],
                  <?php
                }
                
              }
            }
          ?>
        ]);

        var options1 = {
          chart: {
            title: 'Company Performance',
            subtitle: 'Layoff 2023',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material1'));

        chart.draw(data1, google.charts.Bar.convertOptions(options1));

        var data2 = google.visualization.arrayToDataTable([
          ['Departments', 'Layoffs'],
          <?php 
            $sql1 = "select t2.department_name as department_name, t2.id, (select count(name) from layoff_data.layoff_data_2023 
as t1 where t1.country=t2.id) as cnt from layoff_data.department as t2";
            $result1 = $conn->query($sql1);
            $numr1 = $result1->num_rows;
            if ($numr1 > 0) {
              // output data of each row
              while($row = $result1->fetch_assoc()) { 
                $i++;
                if($i==$numr)
                {
                  ?>
                  ['<?php echo $row["department_name"] ?>',<?php echo $row["cnt"]; ?>]
                  <?php
                }
                else 
                {
                  ?>
                  ['<?php echo $row["department_name"] ?>',<?php echo $row["cnt"]; ?>],
                  <?php
                }
                
              }
            }
          ?>
        ]);

        var options2 = {
          chart: {
            title: 'Department Performance',
            subtitle: 'Layoff 2023',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material2'));

        chart.draw(data2, google.charts.Bar.convertOptions(options2));
      }
    </script>
      
    
</head>
<style>
    .send-button{
background: #54C7C3;
width:100%;
font-weight: 600;
color:#fff;
padding: 8px 25px;
}
</style>
<body>

<div class="container" style="width:50%;border:1px solid #ededed;padding:20px;margin-top:10%;">
  <h2><center>2023 layoff DB</center></h2>
    <div class="container" <?php if($_POST["form_submit"]!="1") { ?> style="display:none" <?php } ?>>
        <form action="" method="Post"> 
            <div style="margin-top:-40px;" class="col-md-6 bg-light text-right">
                <input class="btn btn-primary" type="submit" value="Reset" id="form_submit" name="form_submit" />
                <?php if($duplicate=="1" || $duplicate==1)
                {
                    ?>
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'You already submitted your layoff!',
                            
                            })
                    </script>
                    <?php
                } 
                ?>
            </div>
            
        </form>
    <div id="columnchart_material" style="width: 700px; height: 500px;"></div><br>
    <div id="columnchart_material1" style="width: 700px; height: 500px;"></div>
    <div id="columnchart_material2" style="width: 700px; height: 500px;"></div>
    </div>
  <form action="" method="Post"  <?php if($_POST["form_submit"]=="1") { ?> style="display:none" <?php } ?>>
    <input type="hidden" value="1" id="form_submit" name="form_submit" />
    <div class="form-group">
      <label for="name">Name </label>
      <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" required>
    </div>
    <div class="form-group">
      <label for="email">Email </label>
      <input type="Email" class="form-control" id="email" placeholder="Enter email" name="email" required>
    </div>
    <div class="form-group">
      <label for="country">Country</label>
      <select class="form-control" name="country" required>
        <option value="">Selected</option>
      <?php 
        $sql = "SELECT * FROM country";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
            ?>
            <option value="<?php echo $row["id"]; ?>"><?php echo $row["country_name"]; ?></option>
            <?php
            //echo "id: " . $row["id"]. " - Name: " . $row["country_name"]. "<br>";
          }
        } else {
          echo "0 results";
        }
      ?>
      </select>
      
    </div>
    <div class="form-group">
      <label for="company_name">Company Name </label>
      <select class="form-control" name="company" required>
        <option value="">Selected</option>
      <?php 
        $sql = "SELECT * FROM companies_data";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
            ?>
            <option value="<?php echo $row["id"]; ?>"><?php echo $row["company_name"]; ?></option>
            <?php
          }
        } else {
          echo "0 results";
        }
      ?>
      </select>
    </div>
    <div class="form-group">
      <label for="department">Department </label>
      <select class="form-control" name="department" required>
        <option value="">Selected</option>
      <?php 
        $sql = "SELECT * FROM department";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
            ?>
            <option value="<?php echo $row["id"]; ?>"><?php echo $row["department_name"]; ?></option>
            <?php
          }
        } else {
          echo "0 results";
        }
      ?>
      </select>
    </div>
    <button type="submit" class="btn btn-block send-button tx-tfm">Submit</button>
  </form>
</div>

</body>
</html>
