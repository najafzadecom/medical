<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExperimentRequest;
use App\Http\Requests\UpdateExperimentRequest;
use App\Models\Experiment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ExperimentController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:experiment-list|experiment-create|experiment-edit|experiment-delete', ['only' => ['index','store']]);
        $this->middleware('permission:experiment-create', ['only' => ['create','store']]);
        $this->middleware('permission:experiment-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:experiment-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Experiment::query();
            return Datatables::eloquent($data)
                ->filter(function ($query) {

                    if (!is_null(request()->get('primary_key'))) {
                        $query->where('id', '=', request('primary_key'));
                    }

                    if (!is_null(request()->get('type'))) {
                        $query->where('type', '=', request('type'));
                    }

                    if (!is_null(request()->get('name'))) {
                        $query->where('name', 'like', "%" . request('name') . "%");
                    }

                })->smart(false)->startsWithSearch()
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group btn-group-justified">
                        <div class="btn-group">
                            <a href="'.route('experiment.show', $row->id).'"  class="show btn btn-light btn-sm"><i class="icon-eye2"></i></a>
                        </div>

                        <div class="btn-group">
                            <a href="'.route('experiment.edit', $row->id).'"  class="edit btn btn-light btn-sm"><i class="icon-pencil"></i></a>
                        </div>

                        <div class="btn-group">
                            <a href="'.route('experiment.destroy', $row->id).'"  class="delete btn btn-light btn-sm"><i class="icon-cross"></i></a>
                        </div>
                    </div>';
                    return $btn;
                })
                ->addColumn('type_name', function($row){
                    return config('app.experiment_type')[$row->type] ?? "Seçilməyib";
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('admin.page.experiment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.page.experiment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreExperimentRequest $request
     * @return RedirectResponse
     */
    public function store(StoreExperimentRequest $request)
    {
        $experiment = Experiment::create($request->all());
        return redirect()->route('experiment.index')->with(['message' => 'Müvəffəqiyyətlə yaradıldı.']);
    }

    /**
     * Display the specified resource.
     *
     * @param Experiment $experiment
     * @return Application|Factory|View
     */
    public function show(Experiment $experiment)
    {
        return view('admin.page.experiment.show', compact('experiment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Experiment $experiment
     * @return Application|Factory|View
     */
    public function edit(Experiment $experiment)
    {
        return view('admin.page.experiment.edit', compact('experiment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateExperimentRequest $request
     * @param Experiment $experiment
     * @return RedirectResponse
     */
    public function update(UpdateExperimentRequest $request, Experiment $experiment)
    {
        $experiment->update($request->all());
        return redirect()->route('experiment.index')->with(['message' => 'Müvəffəqiyyətlə yeniləndi.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Experiment $experiment
     * @return JsonResponse
     */
    public function destroy(Experiment $experiment)
    {
        $delete = $experiment->delete();
        if($delete) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
