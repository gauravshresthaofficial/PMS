<?php
$filename = 'invoice_number.txt';

if(isset($_POST['act']))
{
    $act = $_POST['act'];
    if($act == "get")
    {
        get_invoice_number();
    }
    else if($_POST['put']) {
        put_invoice_number();

    }
}


function get_invoice_number()
{
    global $filename;

    if (file_exists($filename)) {
        // File exists, so we can read the last invoice number from it
        $last_invoice_number = file_get_contents($filename);
        // Increment the last invoice number to get the new one
        $new_invoice_number = $last_invoice_number + 1;
    } else {
        // File doesn't exist, so we create it and set the initial invoice number to 1
        $new_invoice_number = 1000;
        file_put_contents($filename, $new_invoice_number);
    }

    $json_data['invoice_number'] = $new_invoice_number;

    echo json_encode($json_data);
}

function put_invoice_number(){
    global $filename;

    if (file_exists($filename)) {
        // File exists, so we can read the last invoice number from it
        $last_invoice_number = file_get_contents($filename);
        // Increment the last invoice number to get the new one
        $new_invoice_number = $last_invoice_number + 1;
        //Update the invoice number
        file_put_contents($filename, $new_invoice_number);
    }
}