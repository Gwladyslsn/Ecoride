<?php
require_once ROOTPATH . '/src/Templates/header.php';

if (!isset($_SESSION['admin']) && !isset($_SESSION['employee'])) {
    header('Location: /register');
    exit;
}

?>

<h1>Dashboard Employee</h1>

<?php
require_once ROOTPATH . '/src/Templates/footer.php'; ?>