<?php

namespace App\Interfaces;

interface ProductTypeRepositoryInterface
{
    public function addProductTypes($productType);
    public function getAllProductTypes();
    public function deleteProductTypes($id);
    public function getProductTypeNameById($productType);
}
