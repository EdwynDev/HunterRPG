<?php
class Router {
    public function dispatch() {
        $url = isset($_GET['url']) ? explode('/', rtrim($_GET['url'], '/')) : [];
        $controllerName = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'HomeController';
        $method = $url[1] ?? 'index';
        $params = array_slice($url, 2);

        $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

        if (file_exists($controllerFile)) {
            require_once __DIR__ . '/Controller.php';
            require_once $controllerFile;
            
            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                if (method_exists($controller, $method)) {
                    call_user_func_array([$controller, $method], $params);
                } else {
                    $this->error404("Méthode $method introuvable.");
                }
            } else {
                $this->error404("Classe $controllerName introuvable.");
            }
        } else {
            $this->error404("Contrôleur $controllerName introuvable.");
        }
    }
    
    private function error404($message = "Page non trouvée") {
        http_response_code(404);
        require_once __DIR__ . '/../views/errors/404.php';
    }
}