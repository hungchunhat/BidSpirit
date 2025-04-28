<?php

namespace App\Http\Controllers;

use App\Events\BidInc;
use App\Models\Bid;
use App\Models\Product;
use Illuminate\Http\Request;

class BidController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'auction_id' => 'required|exists:auctions,id',
            'bid_step' => 'required|integer',
            'user_bid' => 'required|integer|min:1',
        ]);
        $product = Product::find($request->product_id);
        if($product->bid->isEmpty()){
            $current_price = $product->price;
        }else{
            $current_price = $product->bid->last()->bid_price;
        }
        if (($request->user_bid - $current_price) % $request->bid_step !== 0 || $request->user_bid <= $current_price) {
            return response()->json([
                'message' => 'The user_bid must be greater than current_price and the difference must be a multiple of bid_step.',
            ], 400);
        }
        $bid = Bid::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'auction_id' => $request->auction_id,
            'bid_price' => $request->user_bid,
        ]);
        broadcast(new BidInc($bid));
    }
}
