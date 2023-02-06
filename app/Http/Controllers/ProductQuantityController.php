<?php

namespace App\Http\Controllers;

use App\Http\Resources\productResource;
use App\Models\productQuantity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductQuantityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = DB::table('products as a')
            ->select('a.nama_product', 'b.qty')
            ->join('product_quantitiy as b', function ($query) {
                $query->on('a.sku', '=', 'b.sku_product');
            })
            ->get();
        return new productResource(true, 'list data productQuantity', $query);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'sku_product' => 'required',
            'qty' => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $productQuantity = ProductQuantity::create([
            'sku_product' => $request->sku_product,
            'qty' => $request->qty,
        ]);

        return new productResource(true, 'Data ProductQuantity Berhasil Ditambahkan!', $productQuantity);
    }
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $sku = $request->productqty;

        $query = DB::table('products as a')
            ->select('a.nama_product', 'b.qty')
            ->join('product_quantitiy as b', function ($query) {
                $query->on('a.sku', '=', 'b.sku_product');
            })
            ->where('a.sku', $sku)
            ->get();

        return new productResource(true, 'list data productQuantity', $query);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductQuantity $productQuantity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required'
        ]);

        $input = $request->all();
        $productQuantity = productQuantity::where('sku_product', $id)->update($input);
        return new productResource(true, 'Data ProductQuantity Berhasil Di Update!', $productQuantity);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductQuantity $productQuantity
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductQuantity $productQuantity)
    {
        $productQuantity->delete();
        return new productResource(true, 'Data ProductQuantity Berhasil Di Hapus!', null);
    }
}
