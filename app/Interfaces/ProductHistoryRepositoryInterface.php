<?php

namespace App\Interfaces;

interface ProductHistoryRepositoryInterface
{
    public function addProductHistory($productHistory);
    public function getAllProductHistories();
    public function deleteProductHistory($id);
}
