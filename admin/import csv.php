<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://assets.ubuntu.com/v1/vanilla-framework-version-3.2.0.min.css" />

    <style>

    </style>
</head>
<body>
    
</body>
</html>


<?php
$conn = mysqli_connect("localhost", "root", "", "ecommerceapp");
include_once("./templates/top.php");

// Get status message
if(!empty($_GET['status'])){
    switch($_GET['status']){
        case 'succ':
            $statusType = 'alert-success';
            $statusMsg = 'Members data has been imported successfully.';
            break;
        case 'err':
            $statusType = 'alert-danger';
            $statusMsg = 'Some problem occurred, please try again.';
            break;
        case 'invalid_file':
            $statusType = 'alert-danger';
            $statusMsg = 'Please upload a valid CSV file.';
            break;
        default:
            $statusType = '';
            $statusMsg = '';
    }
}
?>


<?php if(!empty($statusMsg)){ ?>
<div class="col-xs-12">
    <div class="alert <?php echo $statusType; ?>"><?php echo $statusMsg; ?></div>
</div>
<?php } ?>
    
<form action="importData.php" class="" method="post" name="uploadCSV" enctype="multipart/form-data">
    <div>
        <label>Choose CSV File to Import</label>
        <input type="file" name="file" accept=".csv">
        <button type="submit" class="" name="importSubmit">Import CSV File</button>
    </div>
</form>



    <form action="exportData.php" class="form-horizontal" method="post" name="uploadCSV" enctype="multipart/form-data">
    <div>
        <button type="submit" class="btn btn-primary" name="exportSubmit">Export CSV File</button>
    </div>
</form>


<?php include_once("./templates/footer.php");?>