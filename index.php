<?php
require_once 'config/config.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

require_once VIEW_PATH . 'layout/sidebar.php';
switch ($controller) {
    case 'home':
        require_once VIEW_PATH . 'layout/home.php';
        break;
    case 'user':
        require_once CONTROLLER_PATH . 'UserAdminController.php';
        break;
    case 'movie':
        require_once CONTROLLER_PATH . 'MovieAdminController.php';
        break;
    case 'genres':
        require_once CONTROLLER_PATH . 'GenresAdminController.php';
        break;
    case 'theater':
        require_once CONTROLLER_PATH . 'TheaterAdminController.php';
        break;

    default:
        require_once VIEW_PATH . 'layout/error.php';
        break;

}

require_once VIEW_PATH . 'layout/footer.php';

?>