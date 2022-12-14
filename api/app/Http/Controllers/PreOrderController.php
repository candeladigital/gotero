<?php

namespace App\Http\Controllers;

use App\Models\CurrentStock;
use Illuminate\Http\Request;
use App\Models\PreOrder;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

function getViews($category)
{
    if($category === 'popular')
    {
        return rand(4,6);
    }

    else if($category === 'average')
    {
        return rand(0,3);
    }

    else if($category === 'common')
    {
        return rand(0,2);
    }
}

class PreOrderController extends Controller
{
    //
    public $pre_order;

    function preOrders()
    {
        $new_data = [];
        $data = PreOrder::all();
        foreach($data as $record)
        {
            $new_data[] = 
            [
                'id' => $record->id,
                'name' => $record->name,
                'category' => $record->category,
                'image' => $record->image,
                'items_left' => $record->items_left
            ];
        }

        return $new_data;
    }

    function filterByBatch(Request $request)
    {
        
        if($request->batch == 'Batch 1')
        {
            $preOrders = Products::orderBy("item_category")
            ->where('received', 0)
            ->where('batch', 1)
            ->get();

            $unique = $preOrders->unique('item_category');

            $collection = $unique->map(function ($array) {
                return collect($array)->unique('item_category')->all();
            });

            $finalPro = Products::orderBy("item_category")
            ->whereIn('id', $collection)
            ->get();


            return $finalPro;
        }
        else if($request->batch == 'Batch 2')
        {
            $preOrders = DB::table('products')
            ->select()
            ->where('received', 0)
            ->where('batch', 2)
            ->get();

            return $preOrders;
        }
        else if($request->batch == 'Batch 3')
        {
            $preOrders = DB::table('products')
            ->select()
            ->where('received', 0)
            ->where('batch', 3)
            ->get();

            return $preOrders;           
        }
        else if($request->batch == 'Batch 4')
        {
            $preOrders = DB::table('products')
            ->select()
            ->where('received', 0)
            ->where('batch', 4)
            ->get();

            return $preOrders;           
        }
       
    }
}
