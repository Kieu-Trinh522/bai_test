<?php


namespace app\model;


class ProductModel
{
    protected $database;

    public function __construct()
    {
        $db= new DBConnect();
        $this->database=$db->connect();
    }

    public function getAll()
    {
        $sql='SELECT * FROM products';
        $stmt=$this->database->query($sql);
        $data=$stmt->fetchAll();
        $array=[];
        foreach ($data as $item){
            $product=new Products($item['name'],$item['type'],$item['price'],$item['count'],$item['date'],$item['note']);
            $product->setId($item['id']);
            array_push($array,$product);
        }
        return$array;
    }

    public function addProduct($product)
    {
        $sql='INSERT INTO `products`(`name`, `type`, `price`, `count`, `date`, `note`) VALUES (:name,:type,:price,:count,:date,:note)';
        $stmt=$this->database->prepare($sql);


        $stmt->bindValue(':name',$product->getName());
        $stmt->bindValue(':type',$product->getType());
        $stmt->bindValue(':price',$product->getPrice());
        $stmt->bindValue(':count',$product->getCount());
        $stmt->bindValue(':date',$product->getDate());
        $stmt->bindValue(':note',$product->getNote());
        $stmt->execute();

    }

    public function getProductById($id)
    {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->database->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $item = $stmt->fetch();
        $product=new Products($item['name'],$item['type'],$item['price'],$item['count'],$item['date'],$item['note']);
        $product->setId($id);
        return $product;
    }

    public function editProduct($product,$_id)
    {
        $sql='UPDATE products SET name=:name,type=:type,price=:price,count=:count,date=:date,note=:note WHERE id=:id';
        $stmt=$this->database->prepare($sql);
        $stmt->bindParam(':name',$product->getName());
        $stmt->bindParam(':type',$product->getType());
        $stmt->bindParam(':price',$product->getPrice());
        $stmt->bindParam(':count',$product->getCount());
        $stmt->bindParam(':date',$product->getDate());
        $stmt->bindParam(':note',$product->getNote());
        $stmt->bindParam(':id',$_id);
        $stmt->execute();
    }

    public function deleteProduct($id)
    {
        $sql='DELETE FROM products WHERE id=:id';
        $stmt=$this->database->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
    }

    public function search($key)
    {
        $sql='SELECT * FROM products WHERE name LIKE :key';
        $stmt=$this->database->prepare($sql);
        $stmt->bindParam(':key',$key);
        $data=$stmt->fetchAll();
        $array=[];
        foreach ($data as $item){
            $product=new Products($item['name'],$item['type'],$item['price'],$item['count'],$item['date'],$item['note']);
            $product->setId($item['id']);
            array_push($array,$product);
        }
        return$array;
    }
}