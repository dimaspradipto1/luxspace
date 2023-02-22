<?php

namespace App\Http\Controllers;


use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\TransactionRequest;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Transaction::query();
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <a class="bg-indigo-500 hover:-bg-yellow-700 text-white font-bold px-2 py-1 rounded-md" href="' . route('dashboard.transaction.show', $item->id) . '">Show</a>
                    <a class="bg-yellow-500 hover:-bg-yellow-700 text-white font-bold px-2 py-1 rounded-md" href="' . route('dashboard.transaction.edit', $item->id) . '">Edit</a>
                    ';
                })
                ->editColumn('total_price', function ($item) {
                    return 'Rp. ' . number_format($item->total_price);
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('pages.dashboard.transaction.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        if (request()->ajax()) {
            $query = TransactionItem::with(['product'])->where('transactions_id', $transaction->id);
            return DataTables::of($query)

                ->editColumn('product.price', function ($item) {
                    return 'Rp. ' . number_format($item->product->price);
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('pages.dashboard.transaction.show', compact(['transaction']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        return view('pages.dashboard.transaction.edit', compact(['transaction']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionRequest $request, Transaction $transaction)
    {
        $data = $request->all();
        $transaction->update($data);

        return redirect()->route('dashboard.transaction.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
