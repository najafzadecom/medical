<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;

class PackageController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:package-list|package-create|package-edit|package-delete|package-show', ['only' => ['index','store']]);
        $this->middleware('permission:package-create', ['only' => ['create','store']]);
        $this->middleware('permission:package-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:package-delete', ['only' => ['destroy']]);
        $this->middleware('permission:package-show', ['only' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Package::query();
            return Datatables::eloquent($data)
                ->filter(function ($query) {

                    if (!is_null(request()->get('primary_key'))) {
                        $query->where('id', '=', request('primary_key'));
                    }

                    if (!is_null(request()->get('name'))) {
                        $query->where('name', 'like', "%" . request('name') . "%");
                    }

                })->smart(false)->startsWithSearch()
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group btn-group-justified">';

                    if(auth()->user()->can('package-show')) {
                        $btn .= '<div class="btn-group">
                            <a href="'.route('package.show', $row->id).'"  class="show btn btn-light btn-sm"><i class="icon-eye2"></i></a>
                        </div>';
                    }

                    if(auth()->user()->can('package-edit')) {
                        $btn .= '<div class="btn-group">
                                <a href="' . route('package.edit', $row->id) . '"  class="edit btn btn-light btn-sm"><i class="icon-pencil"></i></a>
                            </div>';
                    }

                    if(auth()->user()->can('package-delete')) {
                        $btn .= '<div class="btn-group">
                            <a href="'.route('package.destroy', $row->id).'"  class="delete btn btn-light btn-sm"><i class="icon-cross"></i></a>
                        </div>';
                    }

                    $btn .= '</div>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('admin.page.package.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.page.package.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePackageRequest  $request
     * @return Response
     */
    public function store(StorePackageRequest $request)
    {
        $package = Package::create($request->all());
        return redirect()->route('package.index')->with(['message' => 'Müvəffəqiyyətlə yaradıldı.']);
    }

    /**
     * Display the specified resource.
     *
     * @param Package $package
     * @return Application|Factory|View
     */
    public function show(Package $package)
    {
        return view('admin.page.package.show', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Package $package
     * @return Application|Factory|View
     */
    public function edit(Package $package)
    {
        return view('admin.page.package.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePackageRequest  $request
     * @param Package $package
     * @return RedirectResponse
     */
    public function update(UpdatePackageRequest $request, Package $package)
    {
        $package->update($request->all());
        return redirect()->route('package.index')->with(['message' => 'Müvəffəqiyyətlə yeniləndi.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Package $package
     * @return JsonResponse
     */
    public function destroy(Package $package)
    {
        $delete = $package->delete();
        if($delete) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
