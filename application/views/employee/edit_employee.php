<!DOCTYPE html>
<html>
<head>
    <title>Edit Employee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef1f5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 450px;
            margin: 60px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #444;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Employee</h2>
    <form method="post" action="<?php echo site_url('EmployeeController/update_employee/'.$employee->id); ?>" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $employee->name; ?>" required>

        <label>Address:</label>
        <input type="text" name="address" value="<?php echo $employee->address; ?>" required>

        <label>Designation:</label>
        <input type="text" name="designation" value="<?php echo $employee->designation; ?>" required>

        <label>Salary:</label>
        <input type="number" name="salary" value="<?php echo $employee->salary; ?>" required>

        <label for="picture">Picture:</label>
        <input type="file" name="picture"><br><br>

        <?php if (isset($employee->picture) && !empty($employee->picture)) { ?>
            <img src="<?php echo base_url('assets/employee/original/' . $employee->picture); ?>" 
                alt="Current Picture" 
                width="120" 
                style="border: 1px solid #ccc; border-radius: 6px; margin-top: 10px;">
        <?php } ?>


        <input type="submit" value="Update Employee">
    </form>
</div>

</body>
</html> 
