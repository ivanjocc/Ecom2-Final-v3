<?php

class LogoutController {
    public function logout() {
        // Limpia la sesión
        $_SESSION = array();
        session_destroy();

        header("Location: view/auth/login.php");
        exit;
    }
}

?>
