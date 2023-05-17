<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<body>
    <div class="grid grid-cols-10">

        <!-- sidebar -->
        <?php include "../sidebar.php"; ?>

        <!-- Header -->
        <?php include "../header.php"; ?>

        <!-- ================================== -->
        <!-- ///////INVOICE LIST/////////////// -->
        <!-- ================================== -->

        <table cellpadding="2">
            <tr>
                <th>SN</th>
                <th>Invoice Number</th>
                <th>Customer Name</th>
                <th>Date</th>
                <th>Discount</th>
                <th>Total Amount</th>
                <th>Update-Delete</th>
            </tr>
        </table>
    </div>
    </div>
</body>

</html>