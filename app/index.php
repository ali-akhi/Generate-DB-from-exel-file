<?php


///show php errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();

$connection = mysqli_connect("localhost", "aliakhi", "Ali1998?", "test");
    if (isset($_POST['import'])) {
        $array = explode(".", $_FILES["excel"]["name"]);
        $extension = end($array);
        $allowed_extension = array("xls", "xlsx", "csv");
        if(in_array($extension, $allowed_extension)){
            $file = $_FILES["excel"]["tmp_name"];
            include("../Classes/PHPExcel/IOFactory.php");
            $objPHPExcel = PHPExcel_IOFactory::load($file);
            $output = "<label class='text-success'>Data Inserted</label><br /><table class='table table-bordered'>";
            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
            {
                $highestRow = $worksheet->getHighestRow();
                for($row=2; $row<=$highestRow; $row++)
                {
                    $output .= "<tr>";
                    $name = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
                    $email = mysqli_real_escape_string($connection, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
                    $query = "INSERT INTO tbl_excel(excel_name, excel_email) VALUES ('".$name."', '".$email."')";
                    mysqli_query($connection, $query);
                    $output .= '<td>'.$name.'</td>';
                    $output .= '<td>'.$email.'</td>';
                    $output .= '</tr>';
                }
            }
            $output .= '</table>';

        }
        else
        {
            $output = '<label class="text-danger">Invalid File</label>'; //if non excel file then
        }
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../style/Style.css">
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
<div class="container box dropzone" style="text-align: center">
    <h3 align="center">Import Excel to Mysql using PHPExcel in PHP</h3><br />
    <img src="http://100dayscss.com/codepen/upload.svg" class="upload-icon" /><br>
    <form method="post" enctype="multipart/form-data"><br>
        <label>Select Excel File</label>
        <input type="file" name="excel" class="upload-input"/><br>
        <br />
        <input type="submit" name="import" class="btn btn-info" value="Import" />
    </form>
    <br />
    <br />
    <?php
    global $output;
    echo $output;
    ?>
</div>


</body>
</html>