<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
    <h1>Welcome</h1>
    <p><?php echo $name;?></p>
    <ul>
    <?php foreach ($colours as $key => $value) :?>
        <li><?php echo $value;?></li>   
    <?php endforeach;?>
    </ul>
</body>
</html>
