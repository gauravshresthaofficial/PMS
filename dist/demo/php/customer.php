<form action="new-customer.php">
    <input type="submit" value="Add new customer" name="submit">
</form>

<table cellpadding="2">
    <tr>
        <th>SN</th>
        <th>Customer Name</th>
        <th>Address</th>
        <th>Name</th>
        <th>Update-Delete</th>
    </tr>
    <?php
    $sql = "Select * from customer";

    include "../../connection.php";

    $result = $conn->query($sql);

    if($result){
        while($row = $result->fetch_assoc())
        {
            print <<<HTML
            <tr>
                <td>$row[c_id]</td>
                <td>$row[c_name]</td>
                <td>$row[c_address]</td>
                <td>$row[c_number]</td>
            </tr>

HTML;
        }
    }


    ?>
</table>