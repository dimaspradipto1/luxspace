<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Yajra\DataTables\Facades\DataTables;

use function Ramsey\Uuid\v1;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Product::query();
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <a class="bg-indigo-500 hover:-bg-yellow-700 text-white font-bold px-2 py-1 rounded-md" href="' . route('dashboard.product.gallery.index', $item->id) . '">Gallery</a>
                    <a class="bg-yellow-500 hover:-bg-yellow-700 text-white font-bold px-2 py-1 rounded-md" href="' . route('dashboard.product.edit', $item->id) . '">Edit</a>

                    <form class="inline-block" action="' . route('dashboard.product.destroy', $item->id) . '" method="POST">
                    <button class="bg-red-500 text-white font-bold rounded-md px-2 py-1 m-2 ">
                    Delete
                    </button>
                    ' . method_field('delete') . csrf_field() . '
                    </form>
                    ';
                })
                ->editColumn('price', function ($item) {
                    return 'Rp. ' . number_format($item->price);
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('pages.dashboard.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        Product::create($data);

        return view('pages.dashboard.product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('pages.dashboard.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $product->update($data);

        return redirect()->route('dashboard.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('dashboard.product.index');
    }
}
