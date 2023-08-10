<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class ProductsController extends Controller
{
    public $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            $products = $this->productService->index();

            // Products after searchings
            $productsSearched = DataTables::eloquent($products)
                ->filterColumn('name', function ($query, $keyword) {
                    $sql = "products.name like ?";
                    $query->whereRaw($sql, ["$keyword%"]);
                })
                ->filterColumn('description', function ($query, $keyword) {
                    $sql = "products.description like ?";
                    $query->whereRaw($sql, ["$keyword%"]);
                });

            if ($products) {
                // when user have access
                if ($this->getUser()->can('update product') && $this->getUser()->can('delete product')) {
                    $editBtn = "<button class='edit btn-primary btn btn-sm update-btn me-1'>Edit</button>";
                    $deleteBtn = "<button class='delete btn-danger btn btn-sm delete-btn'>Delete</button>";
                    $actionsDiv = "<div class='d-flex'>$editBtn$deleteBtn</div>";

                    return $productsSearched
                        ->addColumn('actions', $actionsDiv)->rawColumns(['actions'])
                        ->toJson();
                    // when users dont have accress
                } else {
                    return $productsSearched->toJson();
                }
            }
        }

        $columns = [
            ['data' => 'id', 'title' => 'Id'],
            ['data' => 'name', 'title' => 'Name'],
            ['data' => 'price', 'title' => 'Price'],
            ['data' => 'image', 'title' => 'Image URL', 'searchable' => false],
            ['data' => 'description', 'title' => 'Description']
        ];
        if ($this->getUser()->can('update product') && $this->getUser()->can('delete product')) {
            array_push($columns, ['data' => 'actions', 'title' => 'Actions', 'orderable' => false, 'searchable' => false]);
        }

        $html = $builder->columns($columns);
        // ->parameters([
        //     'paging' => true,
        //     'searching' => true
        // ]);

        return view('products.index', compact('html'));
    }

    public function create(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'unique:products', 'max:200'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['required'],
        ]);

        $newProduct = $this->productService->create($request->except('_token', '_method'));
        if (!$newProduct) {
            return back()->withErrors('error', "Something went wrong when creating new product!");
        }

        return back()->with('success', "Create product successfully (Product Id: $newProduct->id).");
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required', 'min:0'],
            'image' => ['required', 'string'],
        ]);

        // dd($validated);

        $updatedProduct = $this->productService->update($request->all(), $id);
        if (!$updatedProduct) {
            return back()->withErrors('error', "Something went wrong when updating product!");
        }

        return back()->with('success', "Update product $id successfully");
    }

    public function delete(Request $request, int $id): RedirectResponse
    {
        $isDeleted = $this->productService->delete($id);
        if (!!!$isDeleted) {
            return back()->withErrors(['error' => "Something went wrong when deleting product or product not found!"]);
        }

        return back()->with('success', "Delete product $id successfully");
    }
}
