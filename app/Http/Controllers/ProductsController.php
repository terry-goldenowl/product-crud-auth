<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class ProductsController extends Controller
{
    private function filterProducts($query)
    {
        if (request()->has('name')) {
            $query->where('name', 'like', request('name') . "%");
        }
        if (request()->has('description')) {
            $query->where('description', 'like', request('description') . "%");
        }
    }

    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            $products = ProductService::index();
            if ($products) {
                if (Auth::user()->can('update product') && Auth::user()->can('delete product')) {
                    $editBtn = "<button class='edit btn-primary btn btn-sm update-btn'>Edit</button>";
                    $deleteBtn = "<button class='delete btn-danger btn btn-sm delete-btn'>Delete</button>";
                    return DataTables::of($products)->addColumn('actions', $editBtn . " " . $deleteBtn)->rawColumns(['actions'])->toJson();
                } else {
                    return DataTables::of($products)->toJson();
                }
            }
        }

        $columns = [
            ['data' => 'id', 'title' => 'Id'],
            ['data' => 'name', 'title' => 'Name'],
            ['data' => 'price', 'title' => 'Price'],
            ['data' => 'image', 'title' => 'Image URL'],
            ['data' => 'description', 'title' => 'Description']
        ];
        if (Auth::user()->can('update product') && Auth::user()->can('delete product')) {
            array_push($columns, ['data' => 'actions', 'title' => 'Actions', 'orderable' => false, 'searchable' => false]);
        }

        $html = $builder->columns($columns);
        // ->parameters([
        //     'paging' => true,
        //     'searching' => true
        // ]);

        return view('products.index', compact('html'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:products', 'max:200'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['required'],
        ]);

        $newProduct = ProductService::create($request->except('_token', '_method'));
        if (!$newProduct) {
            return back()->withErrors('error', "Something went wrong when creating new product!");
        }

        return back()->with('success', "Create product successfully (Product Id: $newProduct->id).");
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required', 'min:0'],
            'image' => ['required', 'string'],
        ]);

        // dd($validated);

        $updatedProduct = ProductService::update($request->all(), $id);
        if (!$updatedProduct) {
            return back()->withErrors('error', "Something went wrong when updating product!");
        }

        return back()->with('success', "Update product $id successfully");
    }

    public function delete(Request $request, $id)
    {
        $isDeleted = ProductService::delete($id);
        if ($isDeleted == 0) {
            return back()->withErrors(['error' => "Something went wrong when deleting product!"]);
        }

        return back()->with('success', "Delete product $id successfully");
    }
}
