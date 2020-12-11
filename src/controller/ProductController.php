<?php

namespace app\controller;
use app\model\ProductModel;
use app\model\Products;

class ProductController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel=new ProductModel();
    }

    public function show()
    {
        $products=$this->productModel->getAll();
        include_once 'src/view/list.php';
    }

    public function add()
    {

        if($_SERVER['REQUEST_METHOD']=="GET"){
            include_once 'src/view/add.php';
        }else{
            $name=$_REQUEST['name'];
            $type=$_REQUEST['type'];
            $price=$_REQUEST['price'];
            $count=$_REQUEST['count'];
            $date=$_REQUEST['date'];
            $note=$_REQUEST['note'];
            $product=new Products($name,$type,$price,$count,$date,$note);
            $this->productModel->addProduct($product);
            header('location:index.php');
        }
    }

    public function edit()
    {
        if($_SERVER['REQUEST_METHOD']=="GET"){
            $id=$_REQUEST['id'];
            $product=$this->productModel->getProductById($id);
            include_once 'src/view/edit.php';
        }else{
            $id=$_REQUEST['id'];
            $name=$_REQUEST['name'];
            $type=$_REQUEST['type'];
            $price=$_REQUEST['price'];
            $count=$_REQUEST['count'];
            $date=$_REQUEST['date'];
            $note=$_REQUEST['note'];
            $newProduct=new Products($name,$type,$price,$count,$date,$note);
            $this->productModel->editProduct($newProduct,$id);
            header('location:index.php');
        }
    }

    public function delete()
    {
        $id=$_REQUEST['id'];
        $this->productModel->deleteProduct($id);
        header('location:index.php');
    }

    public function search()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            $search = "%".$_REQUEST['search']."%";
            $this->productModel->search($search);
            include_once "src/view/list.php";
        }
    }
}