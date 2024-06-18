<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function titleChart()
    {
        $customer = DB::table('customers')->groupBy('address')->orderBy('total')->pluck(DB::raw('count(address) as total'), 'address')->all();
        $labels = (array_keys($customer));
        $data = array_values($customer);
        return response()->json(array('data' => $data, 'labels' => $labels));
    }

    public function salesChart()
    {
        $sales = DB::table('orders AS o')
            ->join('order_has_product AS ohp', 'o.id', '=', 'ohp.order_id')
            ->join('products AS p', 'ohp.product_id', '=', 'p.id')
            ->orderBy(DB::raw('month(o.date_placed)'), 'ASC')
            ->groupBy(DB::raw('monthname(o.date_placed)'))
            ->pluck(
                DB::raw('sum(ohp.quantity * p.cost) AS total'),
                DB::raw('monthname(o.date_placed) AS month')
            )
            ->all();
        $labels = (array_keys($sales));
        $data = array_values($sales);
        return response()->json(array('data' => $data, 'labels' => $labels));
    }

    public function stockChart() {

        $stockData = Product::join('stocks', 'products.id', '=', 'stocks.product_id')
            ->select('products.name', DB::raw('SUM(stocks.stock) as total_stock'))
            ->groupBy('products.name')
            ->orderBy('total_stock', 'asc')
            ->get();

        $labels = (array_keys($stockData));
        $data= array_values($stockData);
        return response()->json(array('data' => $data, 'labels' => $labels));
    }

    public function productChart() {

        $items = DB::table('orderlines AS ol')
            ->join('products AS p', 'ol.product_id', '=', 'p.id')
            ->groupBy('p.description')
            ->orderBy('total', 'DESC')
            ->pluck(DB::raw('sum(ol.qty) AS total'), 'description')
            ->all();

        $labels = (array_keys($stockData));
        $data= array_values($stockData);
        return response()->json(array('data' => $data, 'labels' => $labels));
    }
}
