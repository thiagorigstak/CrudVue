<?php

//action.php

$connect = new PDO("pgsql:host=localhost;dbname=postgres", "postgres", "CBR123"); //root
$received_data = json_decode(file_get_contents("php://input"));
$data = array();
if ($received_data->action == 'fetchusers') {
    $query = "
 SELECT * FROM users 
 ORDER BY id
 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data);
}
if ($received_data->action == 'insert') {
    $data = array(
        ':nome' => $received_data->user,
        ':email' => $received_data->email,
        ':telefone' => $received_data->telefone
    );
    //print_r($data);
    $query = "
 INSERT INTO users(nome, email, telefone) 
 VALUES (:nome, :email, :telefone);
 ";
    try {
        $statement = $connect->prepare($query);
        $statement->execute($data);
    } catch (PDOException $e) {
        echo "ERRO:" . $e->getMessage() . "<br/>" . $query;
    }

    $output = array(
        'message' => 'Data Inserted'
    );

    echo json_encode($output);
}
if ($received_data->action == 'fetchSingle') {
    $query = "SELECT * FROM users WHERE id = '" . $received_data->id . "'";
    try {
        $statement = $connect->prepare($query);
        $statement->execute();
    } catch (PDOException $e) {
        echo json_encode("ERRO:" . $e->getMessage() . "<br/>" . $query);
        echo "ERRO:" . $e->getMessage() . "<br/>" . $query;
    }

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $data['nome'] = $row['nome'];
        $data['email'] = $row['email'];
        $data['telefone'] = $row['telefone'];
        $data['id'] = $row['id'];
    }
    echo json_encode($data);
}
if ($received_data->action == 'update') {
    $data = array(
        ':nome' => $received_data->user,
        ':email' => $received_data->email,
        ':telefone' => $received_data->telefone,
        ':id'   => $received_data->id
    );

    $query = "UPDATE users SET nome = :nome, email = :email,telefone = :telefone WHERE id = :id";
    try {
        $statement = $connect->prepare($query);

        $statement->execute($data);
    } catch (PDOException $e) {
        echo "ERRO:" . $e->getMessage() . "<br/>" . $query;
    }
    $output = array(
        'message' => 'Data Updated'
    );

    echo json_encode($output);
}

if ($received_data->action == 'delete') {
    $query = "
 DELETE FROM users 
 WHERE id = '" . $received_data->id . "'
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $output = array(
        'message' => 'Data Deleted'
    );

    echo json_encode($output);
}
