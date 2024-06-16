<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Load the Excel file (requires PHPExcel library or similar)
    require_once 'PHPExcel/PHPExcel.php';

    $excelFile = "users/users.xlsx";
    $objPHPExcel = PHPExcel_IOFactory::load($excelFile);
    $worksheet = $objPHPExcel->getActiveSheet();
    
    // Iterate through rows to find matching username and password
    $found = false;
    foreach ($worksheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE); // Loop through all cells, even if empty
        
        $rowArray = [];
        foreach ($cellIterator as $cell) {
            $rowArray[] = $cell->getValue();
        }
        
        if ($rowArray[0] == $username && $rowArray[1] == $password) {
            $found = true;
            break;
        }
    }

    if ($found) {
        echo "Login successful!";
        // Redirect to a logged-in page or perform other actions
    } else {
        echo "Invalid username or password.";
        // Handle incorrect credentials, maybe redirect back to login page
    }
}
?>
