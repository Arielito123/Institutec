<?php
require_once '../controllers/views_delete_teacher.php';


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/eliminate_register.css">
    <title>Borrar</title>
</head>
<body>
    <div class="advertencia">
        <h2>Advertencia</h2>
        <p>¿Seguro que desea eliminar este Profesor?</p>
        <form action="../controllers/views_delete_teacher.php" method="post">
        <input type="hidden" name="id_teacher" value="<?php echo $get_teacher['id_teacher'];?>">
            <button type="submit" class="btn-delete" name="delete">Eliminar</button>
        </form>
        <button class="back"><a href="../views/views_teacher.php" >volver</a></button>
    </div>
</body>
</html>