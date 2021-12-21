<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Country;
use App\Models\Experiment;
use App\Models\Order;
use App\Models\Package;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Milon\Barcode\Facades\DNS1DFacade;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:order-list|order-create|order-edit|order-delete|order-show', ['only' => ['index','store']]);
        $this->middleware('permission:order-create', ['only' => ['create','store']]);
        $this->middleware('permission:order-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy']]);
        $this->middleware('permission:order-show', ['only' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {


        $packages = Package::all();
        $countries = Country::all();
        if ($request->ajax()) {
            $data = Order::with('country');
            return Datatables::eloquent($data)
                ->filter(function ($query) {


                    if (!is_null(request()->get('primary_key'))) {
                        $query->where('id', '=', request('primary_key'));
                    }

                    if (!is_null(request()->get('country_id'))) {
                        $query->where('country_id', '=', request('country_id'));
                    }

                    if (!is_null(request()->get('package_id'))) {
                        $query->where('package_id', '=', request('package_id'));
                    }

                    if(auth()->user()->hasRole('Registrator')) {
                        $query->where('created_by', auth()->user()->id);
                        $query->whereIn('status', [0, 3]);
                    } elseif(auth()->user()->hasRole('Laboperator')) {
                        $query->where('status', 1);
                    } elseif(auth()->user()->hasRole('Manager')) {
                        $query->whereIn('status', [2]);
                    }

                    $query->orderBy('created_at', 'desc');


                })->smart(false)->startsWithSearch()
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group btn-group-justified">';

                    if(auth()->user()->can('order-show')) {
                        $btn .= '<div class="btn-group">
                            <a href="'.route('order.show', $row->id).'"  class="show btn btn-light btn-sm"><i class="icon-eye2"></i></a>
                        </div>';
                    }

                    if(auth()->user()->can('order-show')) {
                        $btn .= '<div class="btn-group">
                            <a href="'.route('order.print', $row->id).'"  class="show btn btn-light btn-sm"><i class="icon-printer4"></i></a>
                        </div>';
                    }

                    if(auth()->user()->can('order-edit')) {
                        $btn .= '<div class="btn-group">
                                <a href="' . route('order.edit', $row->id) . '"  class="edit btn btn-light btn-sm"><i class="icon-pencil"></i></a>
                            </div>';
                    }

                    if(auth()->user()->can('order-delete')) {
                        $btn .= '<div class="btn-group">
                            <a href="'.route('order.destroy', $row->id).'"  class="delete btn btn-light btn-sm"><i class="icon-cross"></i></a>
                        </div>';
                    }

                    $btn .= '</div>';

                    return $btn;
                })
                ->addColumn('country', function ($row) {
                    return $row->country ? $row->country->name : '';
                })
                ->addColumn('package', function ($row) {
                    return $row->package ? $row->package->name : '';
                })
                ->addColumn('barcode', function ($row) {
                    return DNS1DFacade::getBarcodeHTML($row->number, 'UPCA');
                })
                ->rawColumns(['action', 'barcode'])
                ->toJson();
        }
        return view('admin.page.order.index', compact('packages', 'countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        $packages = Package::all();

        $experiments = [];
        foreach (config('app.experiment_type') as $key => $value) {
            $experiments[$key] = Experiment::where('type', $key)->get();
        }

        return view('admin.page.order.create', compact('countries', 'packages', 'experiments'));
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

        $input['date'] = date('Y-m-d H:i:s');
        $input['created_by'] = auth()->user()->id;
        $input['updated_by'] = auth()->user()->id;
        $input['production_date'] = date('Y-m-d', strtotime($input['production_date']));
        $input['expiry_date'] = date('Y-m-d', strtotime($input['expiry_date']));

        if(!isset($input['experiments'])) {
            $input['experiments'] = [];
        }

        $order = Order::create($input);
        $order->update(['number' => sprintf("%06d", $order->id)]);

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

        $experiments = [];
        foreach (config('app.experiment_type') as $key => $value) {
            $experiments[$key] = Experiment::where('type', $key)->get();
        }

        $result = json_decode($order->result, true);
        if(!$result) {
            foreach ($order->experiments as $exp) {
                $result[$exp] = ['', '', '', '', '', '', ''];
            }
        }

        return view('admin.page.order.show', compact('order', 'experiments', 'result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Order $order
     * @return Application|Factory|View
     */
    public function edit(Order $order)
    {
        $countries = Country::all();
        $packages = Package::all();

        $experiments = [];
        foreach (config('app.experiment_type') as $key => $value) {
            $experiments[$key] = Experiment::where('type', $key)->get();
        }

        $result = json_decode($order->result, true);
        if(!$result) {
            foreach ($order->experiments as $exp) {
                $result[$exp] = ['', '', '', '', '', '', ''];
            }
        }

        return view('admin.page.order.edit', compact('order', 'countries', 'packages', 'experiments', 'result'));
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
        $input['updated_by'] = auth()->user()->id;

        $input['production_date'] = date('Y-m-d', strtotime($input['production_date']));
        $input['expiry_date'] = date('Y-m-d', strtotime($input['expiry_date']));

        if(!isset($input['experiments'])) {
            $input['experiments'] = [];
        }

        $input['result'] = json_encode($request->get('result'), JSON_PRETTY_PRINT);

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

    public function print(Order $order)
    {
        return view('admin.page.order.print', compact('order'));
    }
}
