<?php
require_once 'CRUD.php';

header("Content-Type: application/json");

$crud = new CRUD();
$response = ['status' => 'error', 'message' => 'Ação inválida.'];

try {
    // Verifica a ação solicitada
    $action = isset($_GET['action']) ? $_GET['action'] : null;

    switch ($action) {
        // Criar um agendamento
        case 'create':
            $uid = $_POST['uid'] ?? null;
            $vid = $_POST['vid'] ?? null;
            $sid = $_POST['sid'] ?? null;
            $data = $_POST['data'] ?? null;
            $hora = $_POST['hora'] ?? null;

            if ($uid && $vid && $sid && $data && $hora) {
                $sql = "INSERT INTO agendamento (uid, vid, sid, data, hora) VALUES (:uid, :vid, :sid, :data, :hora)";
                $params = ['uid' => $uid, 'vid' => $vid, 'sid' => $sid, 'data' => $data, 'hora' => $hora];
                $crud->execute($sql, $params);

                $response = ['status' => 'success', 'message' => 'Agendamento criado com sucesso.'];
            } else {
                $response['message'] = 'Parâmetros incompletos.';
            }
            break;

        // Listar agendamentos
        case 'list':
            $sql = "SELECT * FROM agendamento";
            $result = $crud->query($sql);

            $response = ['status' => 'success', 'data' => $result];
            break;

        // Buscar agendamento por ID
        case 'get':
            $id = $_GET['id'] ?? null;

            if ($id) {
                $sql = "SELECT * FROM agendamento WHERE id = :id";
                $result = $crud->query($sql, ['id' => $id]);

                $response = $result ? ['status' => 'success', 'data' => $result] : ['status' => 'error', 'message' => 'Agendamento não encontrado.'];
            } else {
                $response['message'] = 'ID não fornecido.';
            }
            break;

        // Atualizar um agendamento
        case 'update':
            $id = $_POST['id'] ?? null;
            $data = $_POST['data'] ?? null;
            $hora = $_POST['hora'] ?? null;

            if ($id && ($data || $hora)) {
                $sql = "UPDATE agendamento SET data = :data, hora = :hora WHERE id = :id";
                $params = ['id' => $id, 'data' => $data, 'hora' => $hora];
                $crud->execute($sql, $params);

                $response = ['status' => 'success', 'message' => 'Agendamento atualizado com sucesso.'];
            } else {
                $response['message'] = 'Parâmetros incompletos.';
            }
            break;

        // Deletar um agendamento
        case 'delete':
            $id = $_POST['id'] ?? null;

            if ($id) {
                $sql = "DELETE FROM agendamento WHERE id = :id";
                $crud->execute($sql, ['id' => $id]);

                $response = ['status' => 'success', 'message' => 'Agendamento deletado com sucesso.'];
            } else {
                $response['message'] = 'ID não fornecido.';
            }
            break;

        default:
            $response['message'] = 'Ação não reconhecida.';
    }
} catch (Exception $e) {
    $response = ['status' => 'error', 'message' => $e->getMessage()];
}

// Retorna a resposta em JSON
echo json_encode($response);
?>
