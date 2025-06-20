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
        error_log("POST raw: " . print_r($_POST, true));

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'POST required']);
            return;
        }

        $nodes = (int)($_POST['nodes'] ?? 5);
        $edges = (int)($_POST['edges'] ?? 6);
        $type = $_POST['type'] ?? 'undirected';

        $bipartit = isset($_POST['bipartit']);
        $conex = isset($_POST['conex']);
        $arbore = isset($_POST['arbore']);

        require_once MODEL . '/GraphUtils.php';

        $attempts = 0;
        $maxAttempts = 1000;

        do {
            $graph = [];
            $existingEdges = [];

            while (count($graph) < $edges) {
                $from = rand(0, $nodes - 1);
                $to = rand(0, $nodes - 1);

                if ($from === $to) continue;

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

            $valid = true;
            if ($conex && !GraphUtils::isConnected($graph, $nodes)) $valid = false;
            if ($bipartit && !GraphUtils::isBipartite($graph, $nodes)) $valid = false;
            if ($arbore && !GraphUtils::isTree($graph, $nodes)) $valid = false;

            $attempts++;
        } while (!$valid && $attempts < $maxAttempts);

        if (isset($_SESSION['user_id'])) {
            require_once MODEL . '/GeneratedInput.php';
            GeneratedInput::save($_SESSION['user_id'], 'graph', json_encode($graph));
        }

        $results = [
            'edges' => $graph,
            'isConnected' => GraphUtils::isConnected($graph, $nodes),
            'isBipartite' => GraphUtils::isBipartite($graph, $nodes),
            'isTree' => GraphUtils::isTree($graph, $nodes),
            'adjacencyMatrix' => GraphUtils::adjacencyMatrix($graph, $nodes),
            'parentVector' => GraphUtils::parentVector($graph, $nodes)
        ];

        header('Content-Type: application/json');
        ob_clean();
        echo json_encode($results);
        exit;
    }
}
