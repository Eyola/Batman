<?php

class ProductsManager extends PDOServer
{

    public function addProducts(Products $product)
    {
        $req = $this->db->prepare("
                                    INSERT INTO products (name, type, length, recovery, summary, descriptionProduct, price, unit) 
                                    VALUES (:name, :type, :length, :recovery, :summary, :descriptionProduct, :price, :unit)");
        $req->bindValue(":name", $product->getName(), PDO::PARAM_STR);
        $req->bindValue(":type", $product->getType(), PDO::PARAM_STR);
        $req->bindValue(":length", $product->getLength(), PDO::PARAM_STR);
        $req->bindValue(":recovery", $product->getRecovery(), PDO::PARAM_STR);
        $req->bindValue(":summary", $product->getSummary(), PDO::PARAM_STR);
        $req->bindValue(":descriptionProduct", $product->getDescriptionProduct(), PDO::PARAM_STR);
        $req->bindValue(":price", $product->getPrice(), PDO::PARAM_STR);
        $req->bindValue(":unit", $product->getUnit(), PDO::PARAM_STR);
        $req->execute();
    }

    public function showAllProducts()
    {
        $products = [];
        $req = $this->db->query("SELECT * FROM products ORDER BY name");
        $req->execute();
        $datas = $req->fetchAll();
        foreach ($datas as $data) {
            $product = new Products($data);
            $products[] = $product;
        }
        return $products;
    }

    public function showProductsCatalog()
    {
        $products = [];
        $req = $this->db->query("SELECT * FROM products WHERE NOT type = 5 ORDER BY name");
        $req->execute();
        $datas = $req->fetchAll();
        foreach ($datas as $data) {
            $product = new Products($data);
            $products[] = $product;
        }
        return $products;
    }

    public function updateProducts(Products $product, $id)
    {
        $req = $this->db->prepare("UPDATE products SET name = :name, type = :type, summary = :summary, descriptionProduct = :descriptionProduct, length = :length, recovery = :recovery, price = :price, unit =:unit WHERE id = :id");
        $req->bindValue(":id", $id, PDO::PARAM_INT);
        $req->bindValue(":name", $product->getName(), PDO::PARAM_STR);
        $req->bindValue(":type", $product->getType(), PDO::PARAM_STR);
        $req->bindValue(":length", $product->getLength(), PDO::PARAM_STR);
        $req->bindValue(":recovery", $product->getRecovery(), PDO::PARAM_STR);
        $req->bindValue(":summary", $product->getSummary(), PDO::PARAM_STR);
        $req->bindValue(":descriptionProduct", $product->getDescriptionProduct(), PDO::PARAM_STR);
        $req->bindValue(":price", $product->getPrice(), PDO::PARAM_STR);
        $req->bindValue(":unit", $product->getUnit(), PDO::PARAM_STR);
        $req->execute();
    }

    public function getProductsById(int $id)
    {
        $req = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $req->bindValue(":id", $id, PDO::PARAM_INT);
        $req->execute();
        $data = $req->fetch();
        $product = new Products($data);
        return $product;
    }
    public function getProductsByName($name)
    {
        $req = $this->db->prepare("SELECT * FROM products WHERE name = :name");
        $req->bindValue(':name', $name, PDO::PARAM_STR);
        $req->execute();
        $data = $req->fetch();
        $product = new Products($data);
        return $product;
    }

    public function deleteProducts(int $id)
    {
        $req = $this->db->prepare("DELETE FROM products WHERE id = :id");
        $req->bindValue(":id", $id, PDO::PARAM_INT);
        $req->execute();
    }

    public function getNameProductsByIdTask($idTask)
    {
        $req = $this->db->query("SELECT name FROM products WHERE id = '$idTask'");
        $data = $req->fetch();
        return $data;
    }

    public function verifyNameManager(string $name)
    {
        $req = $this->db->prepare("SELECT name from products WHERE name = :name");
        $req->bindValue(":name", $name, PDO::PARAM_STR);
        $req->execute();
        $data = $req->fetch();
        return $data;
    }
}
