<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $product = Product::with('user')->latest()->paginate(5);
        return $this->successResponse($product, "Product List");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        //
        $validator = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imgName = uniqid() . '_' . date('Y-m-d H:i:s') . '_' . $file->getClientOriginalName();
            $path = $request->file('image')->storeAs('public/uploads', $imgName);
            $validator['image'] = $imgName;
        }
        // $validator['user_id'] = auth()->user()->id;

        $product = Product::create($validator);
        if ($product) {
            return $this->successResponse($product, 'Success! Data with Store');
        } else {
            return $this->errorResponse('Error! Empty data with Store');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        if ($product = $product->with('user')) {
            return $this->successResponse($product, 'Product With Id');
        } else {
            return $this->errorResponse('Error! Product With Id');
        }
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        //
        $validation = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imgName = uniqid() . '_' . date('Y-m-d H:m:i') . '_' . $file->getClientOriginalName();
            $path = $request->file('image')->storeAs('public/uploads', $imgName);
            $validatedData['image'] = $imgName;

            if (Storage::exists('public/uploads/' . $product->image)) {
                Storage::delete('public/uploads/' . $product->image);
            }
        }
        // $updated = $product->update($validation);
        if ($product->update($validation)) {
            return $this->successResponse($product, 'Success! Data updated successfully');
        } else {
            return $this->errorResponse('Error! Unable to update data');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
        if ($product) {
            if (Storage::exists($product->image)) {
                Storage::delete('public/uploads/' . $product->image);
            }
            $product->delete();
            return $this->successResponse($product, 'Delete done');
        } else {
            return $this->errorResponse('update error');
        }
    }

    public function search(Request $request, $keyword)
    {
        $product = Product::with('user')->where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('description', 'LIKE', '%' . $keyword . '%')
            ->orWhere('price', 'LIKE', '%' . $keyword . '%')
            ->orWhere('type', 'LIKE', '%' . $keyword . '%')
            ->get();
        if ($product) {
            return $this->successResponse($product, 'Search done');
        } else {
            return $this->errorResponse('Search error');
        }
    }
}
