<?php
class GraphUtils {
    public static function isConnected($graph, $nodes) {
        $adj = [];
        foreach ($graph as $e) {
            $adj[$e[0]][] = $e[1];
            $adj[$e[1]][] = $e[0];
        }

        $visited = array_fill(0, $nodes, false);
        $queue = [0];
        $visited[0] = true;

        while ($queue) {
            $v = array_shift($queue);
            foreach ($adj[$v] ?? [] as $nei) {
                if (!$visited[$nei]) {
                    $visited[$nei] = true;
                    $queue[] = $nei;
                }
            }
        }

        return !in_array(false, $visited);
    }

    public static function isBipartite($graph, $nodes) {
        $adj = [];
        foreach ($graph as $e) {
            $adj[$e[0]][] = $e[1];
            $adj[$e[1]][] = $e[0];
        }

        $colors = array_fill(0, $nodes, -1);
        for ($i = 0; $i < $nodes; $i++) {
            if ($colors[$i] === -1) {
                $queue = [$i];
                $colors[$i] = 0;
                while ($queue) {
                    $v = array_shift($queue);
                    foreach ($adj[$v] ?? [] as $nei) {
                        if ($colors[$nei] === -1) {
                            $colors[$nei] = 1 - $colors[$v];
                            $queue[] = $nei;
                        } elseif ($colors[$nei] === $colors[$v]) {
                            return false;
                        }
                    }
                }
            }
        }
        return true;
    }

    public static function isTree($graph, $nodes) {
        return count($graph) === $nodes - 1 && self::isConnected($graph, $nodes);
    }

    public static function adjacencyMatrix($graph, $nodes) {
        $matrix = array_fill(0, $nodes, array_fill(0, $nodes, 0));
        foreach ($graph as $e) {
            $from = $e[0];
            $to = $e[1];
            $matrix[$from][$to] = 1;
            $matrix[$to][$from] = 1;
        }
        return $matrix;
    }

    public static function parentVector($graph, $nodes) {
        $adj = [];
        foreach ($graph as $e) {
            $adj[$e[0]][] = $e[1];
            $adj[$e[1]][] = $e[0];
        }

        $parents = array_fill(0, $nodes, -1);
        $visited = array_fill(0, $nodes, false);
        $queue = [0];
        $visited[0] = true;

        while ($queue) {
            $node = array_shift($queue);
            foreach ($adj[$node] ?? [] as $nei) {
                if (!$visited[$nei]) {
                    $visited[$nei] = true;
                    $parents[$nei] = $node;
                    $queue[] = $nei;
                }
            }
        }
        return $parents;
    }
}
