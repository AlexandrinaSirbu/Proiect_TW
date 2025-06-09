<?php

class GeneratorController
{
    public function numbers()
    {
        include VIEW . '/generators/numbers.php';
    }

    public function numbersAjax()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'POST required']);
            return;
        }

        $length = (int)($_POST['length'] ?? 10);
        $min = (int)($_POST['min'] ?? 0);
        $max = (int)($_POST['max'] ?? 100);
        $sort = $_POST['sort'] ?? 'none';

        $generated = [];

        for ($i = 0; $i < $length; $i++) {
            $generated[] = rand($min, $max);
        }

        if ($sort === 'asc') {
            sort($generated);
        } elseif ($sort === 'desc') {
            rsort($generated);
        }

        if (isset($_SESSION['user_id'])) {
            require_once MODEL . '/GeneratedInput.php';
            GeneratedInput::save($_SESSION['user_id'], 'numbers', $generated);
        }

        header('Content-Type: application/json');
        echo json_encode($generated);
    }

    public function string()
    {
        include VIEW . '/generators/string.php';
    }

    public function stringAjax()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'POST required']);
            return;
        }

        $length = (int)($_POST['length'] ?? 10);
        $prefix = $_POST['prefix'] ?? '';
        $suffix = $_POST['suffix'] ?? '';

        $includeLower = isset($_POST['lowercase']);
        $includeUpper = isset($_POST['uppercase']);
        $includeDigits = isset($_POST['digits']);
        $includeSymbols = isset($_POST['symbols']);

        $pool = '';
        if ($includeLower) $pool .= 'abcdefghijklmnopqrstuvwxyz';
        if ($includeUpper) $pool .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($includeDigits) $pool .= '0123456789';
        if ($includeSymbols) $pool .= '!@#$%^&*()_+-=[]{}|;:,.<>?';

        if ($pool === '') $pool = 'abcdefghijklmnopqrstuvwxyz';

        $generatedCore = '';
        for ($i = 0; $i < $length; $i++) {
            $generatedCore .= $pool[random_int(0, strlen($pool) - 1)];
        }

        $final = $prefix . $generatedCore . $suffix;

        if (isset($_SESSION['user_id'])) {
            require_once MODEL . '/GeneratedInput.php';
            GeneratedInput::save($_SESSION['user_id'], 'string', json_encode($final));
        }

        header('Content-Type: application/json');
        echo json_encode(['generated' => $final]);
    }
    public function matrix()
    {
        include VIEW . '/generators/matrix.php';
    }

    public function matrixAjax()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'POST required']);
            return;
        }

        $rows = (int)($_POST['rows'] ?? 5);
        $cols = (int)($_POST['cols'] ?? 5);
        $min = (int)($_POST['min'] ?? 0);
        $max = (int)($_POST['max'] ?? 9);
        $type = $_POST['type'] ?? 'random';

        $matrix = [];

        for ($i = 0; $i < $rows; $i++) {
            $row = [];
            for ($j = 0; $j < $cols; $j++) {
                switch ($type) {
                    case 'binary':
                        $row[] = rand(0, 1);
                        break;
                    case 'uniform':
                        $row[] = $min;
                        break;
                    default:
                        $row[] = rand($min, $max);
                        break;
                }
            }
            $matrix[] = $row;
        }

        if (isset($_SESSION['user_id'])) {
            require_once MODEL . '/GeneratedInput.php';
            GeneratedInput::save($_SESSION['user_id'], 'matrix', json_encode($matrix));
        }

        header('Content-Type: application/json');
        echo json_encode($matrix);
    }

    public function graph()
{
    include VIEW . '/generators/graph.php';
}

public function graphAjax()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'POST required']);
        return;
    }

    $nodes = (int)($_POST['nodes'] ?? 5);
    $edges = (int)($_POST['edges'] ?? 6);
    $type = $_POST['type'] ?? 'undirected';

    $graph = [];

    $existingEdges = [];

    while (count($graph) < $edges) {
        $from = rand(0, $nodes - 1);
        $to = rand(0, $nodes - 1);

        if ($from === $to) continue; // evită auto-muchii

        // Sortare pentru a evita dubluri (ex: (1,2) == (2,1) la neorientat)
        $key = $type === 'undirected'
            ? implode('-', [min($from, $to), max($from, $to)])
            : "$from-$to";

        if (isset($existingEdges[$key])) continue;

        $existingEdges[$key] = true;

        if ($type === 'weighted') {
            $weight = rand(1, 10);
            $graph[] = [$from, $to, $weight];
        } else {
            $graph[] = [$from, $to];
        }
    }

    if (isset($_SESSION['user_id'])) {
        require_once MODEL . '/GeneratedInput.php';
        GeneratedInput::save($_SESSION['user_id'], 'graph', json_encode($graph));
    }

    header('Content-Type: application/json');
    echo json_encode($graph);
}

}
