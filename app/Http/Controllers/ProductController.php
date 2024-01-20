<?php

namespace App\Http\Controllers;

use App\Mail\Email;
use App\Models\Product;
use App\Models\ProductHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function productAdd(Request $request){
        try{
            $request->validate([
                'name' => 'required|string|min:3|max:255',
                'price' => 'required|numeric',
                'status' => 'required|string',
                'seller' => 'string|min:3|max:255',
                'type' => 'required|string|min:3|max:255',
            ]);
            $product = Product::create([
                'name' => $request['name'],
                'price' => $request['price'],
                'status' => 'active',
                'seller' => $request['seller'] ?? Auth::user()->name,
                'type' => $request['type'],
            ]);

            ProductHistory::create([
                'product_id' => $product->id,
                'field_name' => 'New',
            ]);


            /**
             * Example mail sent
             *
                try {
                    Mail::to(Auth::user()->email)->send(new Email());
                    $mail = 'Mail sent successfully';
                } catch (\Exception $e) {
                    $mail = $e->getMessage();
                }
            */
            return response()->json([
                'msg' => 'Created succesfully',
                'data' => $product,
            ]);


        }catch (ValidationException $e){
            return response()->json([
                'msg' => 'Validation error',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function productInfo ($productId){
        $product = Product::find($productId);
        if ($product->exists()){
            return response()->json([
                'msg' => 'Product is listed.',
                'data' => $product,
            ]);
        }else{
            return response()->json([
                'msg' => 'The product does not exist.',
            ],404);
        }
    }

    public function productView (Request $request){
        if ($request->hasAny(['name','seller'])){
            $productName = str_replace('-', ' ', $request['name']);
            $sellerName = str_replace('-', ' ', $request['seller']);
            $query = Product::query();
            if ($productName !== ''){
                $query->where('name', $productName);
            }
            if ($sellerName !== ''){
                $query->where('seller', $sellerName);
            }
            $products = $query->get();
        }else{
            $products = Product::all();
        }

        if ($products->count() > 0){
            return response()->json([
                'msg' => 'Products have been listed.',
                'data' => $products,
            ]);
        }else{
            return response()->json([
                'msg' => 'The product does not exist.',
            ],404);
        }
    }

    public function productUpdate (Request $request, $productId){
        $product = Product::find($productId);
        if ($product){
            $allowedColumns = ['name', 'price', 'status', 'seller', 'type'];
            $updateData = $request->only($allowedColumns);
            $originalValues = $product->only($allowedColumns);

            $product->update($updateData);

            $updatedColumns = array_diff_assoc($updateData, $originalValues);

            if (empty($updatedColumns)){
                return response()->json([
                    'msg' => 'Product is already updated.',
                ]);
            }else{
                foreach ($updatedColumns as $key => $updatedColumn){
                    ProductHistory::create([
                        'product_id' => $product->id,
                        'field_name' => $key,
                        'new_value' => $updatedColumn,
                        'old_value' => $originalValues[$key],
                    ]);
                    $changedVariables[$key] = $originalValues[$key];
                }

                return response()->json([
                    'msg' => 'Product has been updated successfully.',
                    'data' => $product,
                    'updated' => $changedVariables,
                ]);
            }
        }else{
            return response()->json([
                'msg' => 'The product does not exist.',
            ],404);
        }
    }

    public function productDelete ($productId){
        $product = Product::find($productId);
        if ($product){
            $isDeleted = $product->delete();
            if ($isDeleted) {
                ProductHistory::create([
                    'product_id' => $productId,
                    'field_name' => 'Deleted',
                ]);
            }
            return response()->json([
                'msg' => 'Product has been deleted.',
            ]);
        }else{
            return response()->json([
                'msg' => 'The product does not exist.',
            ],404);
        }
    }
}
