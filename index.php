<?php
require __DIR__."/vendor/autoload.php";
$productController=new \app\controller\ProductController();
$page=isset($_REQUEST['page'])?$_REQUEST['page']:NULL;
switch ($page){
    case 'add':
        $productController->add();
        break;
    case 'edit':
        $productController->edit();
        break;
    case 'delete':
        $productController->delete();
        break;
    case'search':
        $productController->search();
        break;
    default:
        $productController->show();
}