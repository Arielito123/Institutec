<?php
class model_sql
{
    private $pdo; // Propiedad para almacenar la conexión

    public function __construct()
    {
        $this->pdo = $this->connectToDatabase();
    }
//funcion que conecta la base de dato
    private function connectToDatabase()
    {
        $hostname = "db";
        $database = getenv("DB_NAME");
        $username = getenv("MYSQL_USER");
        $password = getenv("MYSQL_ROOT_PASSWORD");
        $charset = "utf8";

        try {
            $connection = "mysql:host=" . $hostname . ";dbname=" . $database . ";charset=" . $charset;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $pdo = new PDO($connection, $username, $password, $options);
            return $pdo;
        } catch (PDOException $e) {
            echo 'Error de conexión: ' . $e->getMessage();
            exit;
        }
    }
//funcion para probar la base de dato
    public function test_db()
    {
        try {
            $stmt = $this->pdo->query('SELECT 1');
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result && $result['1'] == 1) {
                echo 'Conexión exitosa a la base de datos.';
            } else {
                echo 'Error al conectar a la base de datos.';
            }
        } catch (PDOException $e) {
            echo 'Error de conexión: ' . $e->getMessage();
        }
    }

    //funcion credencial login
    public function login($user, $password)
{
    $query = "SELECT dni, name FROM internal_users WHERE dni = :user AND password = :password";
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':user', $user);
    $statement->bindParam(':password', $password);
    $statement->execute();

    $row = $statement->fetch(PDO::FETCH_ASSOC);
    
    if ($row) {
        return $row; // Devuelve la fila si las credenciales son correctas
    } else {
        return false; // Devuelve false si las credenciales son incorrectas
    }
}

//funcion para Mostrar un registro

public function show_table($table){

$query="SELECT * FROM $table";
$statement=$this->pdo->prepare($query);
$statement->execute();
$list_data=$statement->fetchAll();

return $list_data;

}
//para mostrar de la tabla los que tengan estado 1
public function show_state($table){

    $query="SELECT * FROM $table WHERE state = 1";
    $statement=$this->pdo->prepare($query);
    $statement->execute();
    $list_data=$statement->fetchAll();
    
    return $list_data;
    
    }
    //mostrar un elemento de la tabla
    public function getSingleShow($table,$value)
    {
        $query = "SELECT * FROM $table WHERE id_pre_user = :id_pre_user AND state = 1";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':id_pre_user', $value, PDO::PARAM_INT);
        $statement->execute();
        
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getFirstValidCredential(){
        $query = "SELECT email, token FROM credential_email";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    
// Función para la validación de duplicados en una base de datos
public function checkForDuplicates($value1, $value2)
{
    try {
        // Verificar si ya existe un registro con el mismo DNI o correo electrónico
        $checkQuery = "SELECT COUNT(*) FROM pre_registration WHERE dni = :dni OR mail = :mail";
        $checkStatement = $this->pdo->prepare($checkQuery);
        $checkStatement->bindParam(':dni', $value1, PDO::PARAM_STR);
        $checkStatement->bindParam(':mail', $value2, PDO::PARAM_STR);
        $checkStatement->execute();

        $count = $checkStatement->fetchColumn();

        if ($count > 0) {
            // Ya existe un registro con el mismo DNI o correo electrónico
            return "Email o DNI ya registrados anteriormente.";
        }

        return false;
    } catch (PDOException $e) {
        echo "Error en la validación de duplicados: " . $e->getMessage();
        return false;
    }
}

//funcion para insertar alumnos preinscriptos
public function pre_registration($value1, $value2, $value3, $value4
, $value5, $value6
, $value7, $value8, $value9)
{
    $query = "INSERT INTO pre_registration (name, last_name, phone, mail, date, dni, carrer,heigth_street,gender,state)
              VALUES (:name, :last_name, :phone, :mail, :date, :dni, :career, :heigth_street, :gender,1)";

    $statement = $this->pdo->prepare($query);

    $statement->bindParam(':name', $value1, PDO::PARAM_STR);
    $statement->bindParam(':last_name', $value2, PDO::PARAM_STR);
    $statement->bindParam(':phone', $value3, PDO::PARAM_STR);
    $statement->bindParam(':mail', $value4, PDO::PARAM_STR);
    $statement->bindParam(':date', $value5, PDO::PARAM_STR);
    $statement->bindParam(':dni', $value6, PDO::PARAM_STR);
    $statement->bindParam(':career', $value7, PDO::PARAM_STR);
    $statement->bindParam(':heigth_street', $value8, PDO::PARAM_STR);
    $statement->bindParam(':gender', $value9, PDO::PARAM_STR);

    try {
        if ($statement->execute()) {
            return true; // Devuelve verdadero si la inserción fue exitosa
        }
    } catch (PDOException $e) {
        echo "Error en la inserción: " . $e->getMessage();
        return false;
    }
}
//buscador para los pre_inscriptos
public function search_pre_register($search) {
    $query = "SELECT * FROM pre_registration 
            WHERE name LIKE :name 
            OR last_name LIKE :last_name 
            OR dni LIKE :dni 
            OR mail LIKE :mail";
    
    // Preparar la declaración
    $statement = $this->pdo->prepare($query);

    // Asignar el valor de búsqueda a los marcadores de posición
    $searchParam = "%$search%"; // Agregar comodines para buscar coincidencias parciales
    $statement->bindParam(':name', $searchParam, PDO::PARAM_STR);
    $statement->bindParam(':last_name', $searchParam, PDO::PARAM_STR);
    $statement->bindParam(':dni', $searchParam, PDO::PARAM_STR);
    $statement->bindParam(':mail', $searchParam, PDO::PARAM_STR);

    // Ejecutar la consulta
    $statement->execute();

    // Obtener y devolver los resultados
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    return $results;
}

//funcion para traer el usuario que coincida con el id
public function getUserData($userId)
{
    $query = "SELECT * FROM pre_registration WHERE id_pre_user = :userId and state=1";
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

public function updateUserData($user_id, $name, $last_name, $phone, $mail, $career, $heigth_street)
{
    try {
        // Create the SQL query
        $query = "UPDATE pre_registration SET 
                name = :name, 
                last_name = :last_name, 
                phone = :phone, 
                mail = :mail, 
                carrer = :career, 
                heigth_street = :heigth_street 
                WHERE id_pre_user = :user_id";

        // Prepare and execute the SQL statement
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
        $statement->bindParam(':mail', $mail, PDO::PARAM_STR);
        $statement->bindParam(':career', $career, PDO::PARAM_STR);
        $statement->bindParam(':heigth_street', $heigth_street, PDO::PARAM_STR);

        $result = $statement->execute();

        return $result; 
    } catch (PDOException $e) {
        echo "Error in update: " . $e->getMessage();
        return false;
    }
}

function eliminated_register($table, $id_user)
{
    try {
        // Luego, actualiza el estado del registro a 0
        $query = "UPDATE $table SET state = 0 WHERE id_pre_user = :id_user";
        $updateStatement = $this->pdo->prepare($query);
        $updateStatement->bindParam(':id_user', $id_user, PDO::PARAM_INT);

        // Ejecuta la actualización
        $updateStatement->execute();

        // Verifica si se actualizó al menos una fila
        $rowCount = $updateStatement->rowCount();

        if ($rowCount > 0) {
            // La eliminación se realizó con éxito
            return true;
        } 
    } catch (PDOException $e) {
        echo "Error al actualizar: " . $e->getMessage();
        return false;
    }
}

}
?>