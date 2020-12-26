<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>
    <?php 
    function query(...$bindings) {
        $sql = array_shift($bindings);
        if (count($bindings) == 1 && is_array($bindings[0]))
            $bindings = $bindings[0];
        pre($sql);
        pre($bindings);
    }
    query("SELECT * FORM user WHERE id = ? AND name = ?",1,'mi5a');
    ?>
    </h1>
</body>
</html>