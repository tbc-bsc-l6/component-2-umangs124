<?php

namespace App\Interfaces;

interface ProductRepositoryInterface 
{
    public function getAllProducts();
    public function getAllProductTypes();
    public function addProducts(array $formFields);
    public function getProductTypeNameById($productType);
    public function getProductsByUserId($userId);
    public function getProductByProductId($productId);
    public function updateProduct($productId, $formFields);
    public function deleteProduct($productId);
    public function productsByProductType($productTypeId);
}