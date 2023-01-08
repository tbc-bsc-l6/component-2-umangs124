<?php

namespace App\Interfaces;

interface ProductHistoryRepositoryInterface
{
    public function addProductHistory($productHistory);
    public function getALlProductHistories();
    public function deleteProductHistory($id);
}
