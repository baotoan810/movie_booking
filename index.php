<?php
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

require_once 'views/layout/sidebar.php';

switch ($controller) {
    case 'home':
        require_once 'views/layout/home.php';
        break;
    case 'user':
        require_once 'controllers/UserAdminController.php';
        break;
    case 'movie':
        require_once 'controllers/MovieAdminController.php';
        break;
    case 'theater':
        require_once 'controllers/TheaterAdminController.php';
        break;
    case 'genres':
        require_once 'controllers/GenresAdminController.php';
        break;
}

require_once 'views/layout/footer.php';

?>