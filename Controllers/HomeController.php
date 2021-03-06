<?php

    namespace Controllers;

    use Controllers\MovieController as MovieController;

    class HomeController {

        public function Index() {
            $movieController = new MovieController();
            $movies = $movieController->moviesNowPlayingOnShow();
            $upcoming = $movieController->moviesUpcoming();
            $title = 'MoviePass';
			require_once(VIEWS_PATH . "header.php");
			require_once(VIEWS_PATH . "nav-video.php");
            require_once(VIEWS_PATH . "navbar.php");
            require_once(VIEWS_PATH . "index.php");
            require_once(VIEWS_PATH . "footer.php");
        }
        
    }
?>
