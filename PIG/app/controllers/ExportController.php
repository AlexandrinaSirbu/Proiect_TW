<?php
class ExportController
{
    public function export()
    {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(403);
            echo "Acces interzis.";
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);
        $format = $_GET['format'] ?? 'json';

        require_once MODEL . '/GeneratedInput.php';
        $input = GeneratedInput::getById($id);

        if (!$input || $input['user_id'] != $_SESSION['user_id']) {
            http_response_code(404);
            echo "Inputul nu a fost găsit.";
            exit;
        }

        $filename = "input_" . $id . "." . $format;
        $content = json_decode($input['content'], true);

        if ($format === 'csv') {
            header("Content-Type: text/csv");
            header("Content-Disposition: attachment; filename=$filename");

            $fp = fopen('php://output', 'w');
            foreach ($content as $value) {
                fputcsv($fp, [$value]);
            }
            fclose($fp);
        } else {
            header("Content-Type: application/json");
            header("Content-Disposition: attachment; filename=$filename");
            echo json_encode($content, JSON_PRETTY_PRINT);
        }

        exit;
    }
}
