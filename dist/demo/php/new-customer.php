<?php
if (isset($_POST['submit']))
    insert();

else {
    show_form();
}
function show_form()
{

    print <<<HTML
        <form action="$_SERVER[PHP_SELF]" method="post">
            <table>
                <tr>
                    <th>Customer Name:</th>
                    <td><input type="text" name="c_name" id=""></td>
                </tr>
                <tr>
                    <th>Customer Address:</th>
                    <td><input type="text" name="c_address" id=""></td>
                </tr>
                <tr>
                    <th>Phone Number:</th>
                    <td><input type="text" name="c_number" id=""></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="submit" value="Submit"></td>
                </tr>
            </table>
        </form>
HTML;
}
function insert()
{

    $c_name = $_POST['c_name'];
    $c_address = $_POST['c_address'];
    $c_number = $_POST['c_number'];

    include "../../connection.php";
    $sql = "INSERT INTO customer (c_id, c_name, c_address,   c_number) VALUES (NULL, '$c_name', '$c_address', '$c_number')";

    if ($result = $conn->query($sql)) {
        $conn->close();
        header("location: customer.php");
    } else {
        echo "Inserted Unucesssful! ";
    }
}
?>