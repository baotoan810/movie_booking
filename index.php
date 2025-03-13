<?php
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'user';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

require_once 'views/layout/sidebar.php';

switch ($controller) {
    case 'user':
        require_once 'controllers/UserAdminController.php';
        break;
    case 'movie':
        require_once 'controllers/MovieAdminController.php';
        break;
    case 'theater':
        require_once 'controllers/TheaterAdminController.php';
        break;
}

require_once 'views/layout/footer.php';

?>