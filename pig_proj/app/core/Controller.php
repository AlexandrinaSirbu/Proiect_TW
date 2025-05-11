<?php
class Controller {
    protected function model($modelName){
        require_once __DIR__ . "/../models/$modelName.php";
        return new $modelName;
    }

    protected function view(string $viewPath, array $data = []){
        extract($data);
        require __DIR__ . "/../views/$viewPath.php";
    }
}
