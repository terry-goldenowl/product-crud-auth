<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public static function index()
    {
        try {
            return Product::query();
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
    }

    public static function create($data)
    {
        try {
            $newProduct = Product::create($data);
            return $newProduct;
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
    }

    public static function update($data, $id)
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

    public static function delete($id)
    {
        try {
            return Product::destroy($id);
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
    }
}
