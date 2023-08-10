<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function index()
    {
        try {
            return Product::query();
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
    }

    public function create(array $data): Product
    {
        try {
            $newProduct = Product::create($data);
            return $newProduct;
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
    }

    public function update(array $data, int $id): Product
    {
        try {
            $product = Product::where('id', $id)->first();
            if ($product) {
                $product->update($data);
                return $product;
            }
            return null;
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $delete = Product::destroy($id);
            $output = $delete == 0 ? true : false;
            return $output;
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
    }
}
