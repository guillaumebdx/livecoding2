<?php


namespace App\Controller;


use App\Model\FavoriteManager;
use App\Model\ItemManager;
use App\Model\UserManager;

class UserController extends AbstractController
{
    public function index()
    {
        echo $_SESSION['name'] . ' id : ' . $_SESSION['id'];
    }
    public function new()
    {
        if (isset($_SESSION['name'])) {
            echo $_SESSION['name'] . ' id : ' . $_SESSION['id'];
        }
        return $this->twig->render('User/new.html.twig', [
            'action' => 'add'
        ]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'post') {
            $userManager = new UserManager();
            $userData = [
                'name'     => $_POST['name'],
                'password' => password_hash($_POST['password'], PASSWORD_ARGON2I),
            ];
            $userManager->insert($userData);
            echo "compte créé";
        }

    }

    public function log()
    {
        return $this->twig->render('User/new.html.twig', [
            'action' => 'check',
        ]);
    }

    public function check()
    {
        $userManager = new UserManager();
        $userData = $userManager->selectOneByName($_POST['name']);
        if (password_verify($_POST['password'], $userData['password'])){
            $_SESSION['name'] = $_POST['name'];
            $_SESSION['id']   = $userData['id'];
            header('location: /');
        } else {
            header('location: /user/log');
        }
    }

    public function logout()
    {
        session_destroy();
        header('location: /');
    }

    public function favorite()
    {
        $json = file_get_contents('php://input');
        $obj  = json_decode($json);
        $favoriteManager = new FavoriteManager();
        $favoriteManager->insert([
            'userId' => $obj->user,
            'itemId' => $obj->item,
        ]);
        $itemManager = new ItemManager();
        $item = $itemManager->selectOneById($obj->item);
        return json_encode(['id' => $item['title']]);
    }

}