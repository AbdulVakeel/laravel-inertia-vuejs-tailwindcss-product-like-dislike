<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $data['columns'] = collect([
            ['key' => 'sr', 'label' => 'Sr.', 'sortable' => false, 'searchable' => false],
            ['key' => 'name', 'label' => 'Name', 'sortable' => true, 'searchable' => false, 'show' => true],
            ['key' => 'admin_like_count', 'label' => 'Admin Like', 'sortable' => true, 'searchable' => false, 'show' => true],
            ['key' => 'admin_dislike_count', 'label' => 'Admin Dislike', 'sortable' => true, 'searchable' => false, 'show' => true],
            ['key' => 'status', 'label' => 'Status', 'sortable' => true, 'searchable' => false, 'show' => true],
            ['key' => 'actions', 'label' => 'Action', 'sortable' => true, 'searchable' => false, 'show' => true],

        ]);

        $data['products'] = Product::get();

        return inertia('Admin/Product/Index', [
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $this->validation($request);
        $product = new Product();

        $this->saveData($product, $request);

        $notify[] = ['success', 'product added successfully'];

        return redirect()->route('admin.products.index')
            ->with('success', $notify[0][1])
            ->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $this->validation($request);
        $product = Product::findOrFail($id);
        $this->saveData($product, $request);

        $notify[] = ['success', 'product updated successfully'];

        return redirect()->route('admin.products.index')
            ->with('success', $notify[0][1])
            ->withNotify($notify);
    }

    protected function saveData($product, $request)
    {

        $product->name = $request->name;
        $product->admin_like_count = $request->admin_like_count ?? 0;
        $product->admin_dislike_count = $request->admin_dislike_count ?? 0;

        return $product->save();
    }

    protected function validation($request)
    {
        $request->validate([
            'name' => 'required',
            'admin_like_count' => 'nullable|numeric|gt:0',
            'admin_dislike_count' => 'nullable|numeric|gt:0',
        ]);
    }

    public function status($id)
    {

        $product = Product::findOrFail($id);
        $status = $product->status;
        $product->status = $status == 1 ? 0 : 1;
        $product->save();

        $notification = $product->status ? 'enabled' : 'disabled';
        $notify[] = ['success', "Product $notification successfully"];

        return redirect()->route('admin.products.index')
            ->with('success', $notify[0][1]);
    }
}