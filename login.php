<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style type="text/css">
        table {
            margin-top: 150px;
            border: 1px solid;
            background-color: #eee;
        }

        td {
            border: 0px;
            padding: 10px;
        }

        th {
            border-bottom: 1px solid;
            background-color: #add;
        }
    </style>
</head>
<body>
<form action="login_process.php" method="post">
    <table align="center">
        <tr>
            <th colspan="2"><h2 align="center">Login</h2></th>
        </tr>
        <tr>
            <td>Username:</td>
            <td><input type="text" name="uname"></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="pwd"></td>
        </tr>
        <tr>
            <td align="right" colspan="2"><input type="submit" name="login" value="Login"></td>
        </tr>
    </table>
</form>
</body>
</html>
