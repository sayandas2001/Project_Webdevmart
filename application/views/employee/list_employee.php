<!DOCTYPE html>
<html>
<head>
    <title>Employee List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: #fff;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .add-button {
            display: inline-block;
            margin-bottom: 15px;
            padding: 10px 15px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .add-button:hover {
            background-color: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        td img {
            border-radius: 6px;
        }

        td a {
            margin-right: 10px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        td a:hover {
            text-decoration: underline;
        }

        .no-image {
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Employee List</h2>
    <a class="add-button" href="<?php echo site_url('EmployeeController/add_employee'); ?>">+ Add New Employee</a>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Designation</th>
                <th>Salary</th>
                <th>Picture</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $emp) { ?>
                <tr>
                    <td><?php echo $emp->name; ?></td>
                    <td><?php echo $emp->address; ?></td>
                    <td><?php echo $emp->designation; ?></td>
                    <td><?php echo $emp->salary; ?></td>
                    <td>
                        <?php if (!empty($emp->picture)) { ?>
                            <img src="<?php echo base_url('assets/employee/original/' . $emp->picture); ?>" width="60" alt="Photo">
                        <?php } else { ?>
                            <span class="no-image">No image</span>
                        <?php } ?>
                    </td>
                    <td>
                        <a href="<?php echo base_url('index.php/EmployeeController/edit_employee/' . $emp->id); ?>">Edit</a>
                        <a href="<?php echo base_url('index.php/EmployeeController/delete_employee/' . $emp->id); ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html> 
