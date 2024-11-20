<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{

    public function dashboard()
    {
        $products = Product::paginate(7);
        
        $allproducts = Product::all();
    
        
        $totalProducts = Product::count();
    
        
        $totalStockValue = $allproducts->sum(function ($allproducts) {
            return $allproducts->price * $allproducts->quantity;
        });
    
        
        $lowStockProducts = $allproducts->where('quantity', '<', 5);
    
        return view('dashboard', compact('products', 'totalProducts', 'totalStockValue', 'lowStockProducts'));
    }
    

    public function categories()
    {

        $categories = Category::paginate(10);


        return view('product.categories', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('categories')->with('success', 'Category created successfully!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
    
        if ($category->products()->count() > 0) {
            return redirect()->route('categories')->with('error', 'This category cannot be deleted because it is being used by products.');
        }
    

        $category->delete();
    
        return redirect()->route('categories')->with('success', 'Category deleted successfully!');
    }
    

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::paginate(10);
        return view('product.editCateg', compact('category'), compact('categories'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('categories')->with('success', 'Category updated successfully!');
    }

    public function storeProduct(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);


        $product = Product::create([
            'name' => $request->name,
            'sku' => $request->sku,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
        ]);


        return redirect()->route('product')->with('success', 'Product added successfully!');
    }

    public function product()
    {

        $products = Product::paginate(10);
        $categories = Category::all();


        return view('product.product', compact('products', 'categories'));;
    }

    public function editProduct($id)

    {

        $product = Product::findOrFail($id);
        $categories = Category::all();
        $products = Product::paginate(10);

        return view('product.editProduct', compact('product', 'categories', 'products'));
    }

    public function updateProduct(Request $request, $id)

    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku,' . $id,
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);
        $product = Product::findOrFail($id);
        $product->update($validatedData);

        return redirect()->route('product')
            ->with('success', 'Product updated successfully!');
    }


    public function destroyProduct($id)
    {

        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product')->with('success', 'Product deleted successfully!');
    }


    public function exportToCsv()
    {

        $products = Product::all();
        $filename = 'products_' . now()->format('Y_m_d_H_i_s') . '.csv';

        $handle = fopen('php://memory', 'w');
        fputcsv($handle, ['ID', 'Name', 'SKU', 'Price', 'Quantity', 'Category']);

        foreach ($products as $product) {
            fputcsv($handle, [
                $product->id,
                $product->name,
                $product->sku,
                $product->price,
                $product->quantity,
                $product->category ? $product->category->name : 'No Category',
            ]);
        }


        rewind($handle);
        return Response::stream(function () use ($handle) {

            fpassthru($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function trashed()
    {
        $products = Product::onlyTrashed()->get(); 
        return view('product.trashed', compact('products'));
    }

    
    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('products.trashed')->with('success', 'Product restored successfully.');
    }

    public function forceDelete($id)
{
    $product = Product::onlyTrashed()->findOrFail($id);
    $product->forceDelete();  

    return redirect()->route('products.trashed')->with('success', 'Product permanently deleted.');
}

}
