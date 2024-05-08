<?php

class ProductByTask
{
    private $iProductByTask;
    private $idProduct;
    private $idTask;
    private $quantityProduct;
    private $unitPriceProduct;

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = "set" . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * Get the value of idProduct
     */
    public function getIdProduct()
    {
        return $this->idProduct;
    }

    /**
     * Set the value of idProduct
     *
     * @return  self
     */
    public function setIdProduct($idProduct)
    {
        $this->idProduct = $idProduct;

        return $this;
    }

    /**
     * Get the value of idTask
     */
    public function getIdTask()
    {
        return $this->idTask;
    }

    /**
     * Set the value of idTask
     *
     * @return  self
     */
    public function setIdTask($idTask)
    {
        $this->idTask = $idTask;

        return $this;
    }

    /**
     * Get the value of quantityProduct
     */
    public function getQuantityProduct()
    {
        return $this->quantityProduct;
    }

    /**
     * Set the value of quantityProduct
     *
     * @return  self
     */
    public function setQuantityProduct($quantityProduct)
    {
        $this->quantityProduct = $quantityProduct;

        return $this;
    }

    /**
     * Get the value of unitPriceProduct
     */
    public function getUnitPriceProduct()
    {
        return $this->unitPriceProduct;
    }

    /**
     * Set the value of unitPriceProduct
     *
     * @return  self
     */
    public function setUnitPriceProduct($unitPriceProduct)
    {
        $this->unitPriceProduct = $unitPriceProduct;

        return $this;
    }

    /**
     * Get the value of iProductByTask
     */ 
    public function getIProductByTask()
    {
        return $this->iProductByTask;
    }

    /**
     * Set the value of iProductByTask
     *
     * @return  self
     */ 
    public function setIProductByTask($iProductByTask)
    {
        $this->iProductByTask = $iProductByTask;

        return $this;
    }
}
