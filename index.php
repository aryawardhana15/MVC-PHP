<?php
session_start();
require_once 'controllers/MahasiswaController.php';

$controller = new MahasiswaController();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'store':
        $controller->store();
        break;
    case 'edit':
        $controller->edit($_GET['id']);
        break;
    case 'update':
        $controller->update($_POST['id']);
        break;
    case 'delete':
        $controller->delete($_GET['id']);
        break;
    case 'search':
        $controller->search($_GET['query']);
        break;
    case 'filter':
        $controller->filter($_GET);
        break;
    case 'export':
        $controller->export($_GET['type']);
        break;
    case 'upload_photo':
        $controller->uploadPhoto($_POST['id']);
        break;
    default:
        $controller->index();
        break;
}