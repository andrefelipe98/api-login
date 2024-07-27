<?php
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/loginUsuario.php';

$database = new Database();
$db = $database->getConnection();

$loginUsuario = new LoginUsuario($db);

$request_method = $_SERVER["REQUEST_METHOD"];
switch($request_method) {
    case 'GET':
        $stmt = $loginUsuario->read();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $usuarios_arr = array();
            $usuarios_arr["records"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $usuario_item = array(
                    "codusuario" => $codusuario,
                    "login" => $login,
                    "senha" => $senha,
                    "tipo_usuario" => $tipo_usuario,
                    "ativo" => $ativo,
                    "codfilial" => $codfilial
                );
                array_push($usuarios_arr["records"], $usuario_item);
            }
            http_response_code(200);
            echo json_encode($usuarios_arr);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Nenhum usuário encontrado."));
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $loginUsuario->login = $data->login;
        $loginUsuario->senha = $data->senha;
        $loginUsuario->tipo_usuario = $data->tipo_usuario;
        $loginUsuario->ativo = $data->ativo;
        $loginUsuario->codfilial = $data->codfilial;

        if($loginUsuario->create()) {
            http_response_code(201);
            echo json_encode(array("message" => "Usuário criado com sucesso."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Não foi possível criar o usuário."));
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Método não permitido."));
        break;
}
?>
