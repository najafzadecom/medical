<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Country;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Milon\Barcode\Facades\DNS1DFacade;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:order-list|order-create|order-edit|order-delete', ['only' => ['index','store']]);
        $this->middleware('permission:order-create', ['only' => ['create','store']]);
        $this->middleware('permission:order-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::with('country')->query();
            return Datatables::eloquent($data)
                ->filter(function ($query) {


                    if (!is_null(request()->get('primary_key'))) {
                        $query->where('id', '=', request('primary_key'));
                    }


                })->smart(false)->startsWithSearch()
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group btn-group-justified">
                        <div class="btn-group">
                            <a href="'.route('order.show', $row->id).'"  class="show btn btn-light btn-sm"><i class="icon-eye2"></i></a>
                        </div>

                        <div class="btn-group">
                            <a href="'.route('order.edit', $row->id).'"  class="edit btn btn-light btn-sm"><i class="icon-pencil"></i></a>
                        </div>

                        <div class="btn-group">
                            <a href="'.route('order.destroy', $row->id).'"  class="delete btn btn-light btn-sm"><i class="icon-cross"></i></a>
                        </div>
                    </div>';
                    return $btn;
                })
                ->addColumn('country', function ($row) {
                    return $row->country ? $row->country->name : '';
                })
                ->addColumn('barcode', function ($row) {
                    return DNS1DFacade::getBarcodeHTML($row->id, 'UPCA');
                })
                ->rawColumns(['action', 'barcode'])
                ->toJson();
        }
        return view('admin.page.order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('admin.page.order.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOrderRequest $request
     * @return RedirectResponse
     */
    public function store(StoreOrderRequest $request)
    {
        $input = $request->all();
        $order = Order::create($input);

        return redirect()->route('order.index')->with(['message' => 'Müvəffəqiyyətlə yaradıldı.']);
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $countries = Country::all();
        return view('admin.page.order.show', compact('order', 'countries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('admin.page.order.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOrderRequest $request
     * @param Order $order
     * @return RedirectResponse
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $input = $request->all();
        $order->update($input);
        return redirect()->route('order.index')->with(['message' => 'Müvəffəqiyyətlə yeniləndi.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return JsonResponse
     */
    public function destroy(Order $order)
    {
        $delete = $order->delete();
        if($delete) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
