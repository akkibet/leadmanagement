<?php
session_start();
include('dbconfig.php');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

if(isset($_POST['export_excel-btn']))
{
    $file_ext_name = $_POST['export_file_type'];
    $fileName = "student-sheet";

    $external_data = "SELECT * FROM external_data";
    $query_run = mysqli_query($conn, $external_data);

    if(mysqli_num_rows($query_run)>0)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'id');
        $sheet->setCellValue('B1', 'firstname');
        $sheet->setCellValue('C1', 'middlename');
        $sheet->setCellValue('D1', 'lastname');
        $sheet->setCellValue('E1', 'gender');
        $sheet->setCellValue('F1', 'birthday');
        $sheet->setCellValue('G1', 'email');
        $sheet->setCellValue('H1', 'contact');
        $sheet->setCellValue('I1', 'address');
        $sheet->setCellValue('J1', 'other_info');
        $sheet->setCellValue('K1', 'interested_in');
        $sheet->setCellValue('L1', 'lead_source');
        $sheet->setCellValue('M1', 'remarks');
        $sheet->setCellValue('N1', 'assigned_to');
        $sheet->setCellValue('O1', 'status');

        $rowCount = 2;
        foreach($query_run as $data)
        {
            $sheet->setCellValue('A'.$rowCount , $data['id']);
            $sheet->setCellValue('B'.$rowCount , $data['fullname']);
            $sheet->setCellValue('C'.$rowCount , $data['middlename']);
            $sheet->setCellValue('D'.$rowCount , $data['lastname']);
            $sheet->setCellValue('E'.$rowCount , $data['gender']);
            $sheet->setCellValue('F'.$rowCount , $data['birthday']);
            $sheet->setCellValue('G'.$rowCount , $data['email']);
            $sheet->setCellValue('H'.$rowCount , $data['contact']);
            $sheet->setCellValue('I'.$rowCount , $data['address']);
            $sheet->setCellValue('J'.$rowCount , $data['other_info']);
            $sheet->setCellValue('K'.$rowCount , $data['interested_in']);
            $sheet->setCellValue('L'.$rowCount , $data['lead_source']);
            $sheet->setCellValue('M'.$rowCount , $data['remarks']);
            $sheet->setCellValue('N'.$rowCount , $data['assigned_to']);
            $sheet->setCellValue('O'.$rowCount , $data['status']);
            $rowCount++;
        }

        if($file_ext_name == 'xlsx')
        {
            $writer = new Xlsx($spreadsheet);
            $final_filename = $fileName .'.xlsx';
        }
        elseif($file_ext_name == 'xls')
        {
            $writer = new Xls($spreadsheet);
            $final_filename = $fileName .'.xls';
        }
        elseif($file_ext_name == 'csv')
        {
            $writer = new Csv($spreadsheet);
            $final_filename = $fileName .'.csv';
        }

        $writer->save($final_filename);
    }
    else
    {
        $_SESSION['message'] = "Not Record Found";
            header('Location: index.php');
            exit(0);
    }
}

if(isset($_POST['save_excel_data']))
{
    $fileName = $_FILES['import_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowed_ext = ['xls','csv','xlsx'];

    if(in_array($file_ext, $allowed_ext))
    {
        $inputFileNamePath = $_FILES['import_file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();
}

        $count = "0";
        foreach($data as $row)
        {

            if($count > 0){
            $firstname = $row['0'];
            $middlename = $row['1'];
            $lastname = $row['2'];
            $gender = $row['3'];
            $birthday = $row['4'];
            $email = $row['5'];
            $contact  = $row['6'];
            $address = $row['7'];
            $other_info = $row['8'];
            $interested_in = $row['9'];
            $lead_source = $row['10'];
            $remarks = $row['11'];
            $assigned_to = $row['12'];
            $status = $row['13'];

            $external_dataQuery = "INSERT INTO external_data (firstname, middlename, lastname, gender, birthday, email, contact, address, other_info, interested_in, lead_source, remarks, assigned_to, status)
            VALUES ('$firstname', '$middlename', '$lastname', '$gender', '$birthday', '$email', '$contact', '$address', '$other_info','$interested_in','$lead_source','$remarks','$assigned_to','$status')";
            $result = mysqli_query($conn, $external_dataQuery);
            $msg = true;

            }
            else
            {
                $count = "1";
            }
        }
        if(isset($msg))
        {
            $SESSION['message'] = "Successfully Imported";
            header('Location: index.php');
            exit(0);
        }
        else
        {
            $_SESSION['message'] = "Not Imported";
            header('Location: index.php');
            exit(0);
        }
    }
    else
    {
        $_SESSION['message'] = "Invalid File";
        header('Location: index.php');
        exit(0);
    }
?>