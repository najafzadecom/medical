<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:log-list', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Activity::with(['causer', 'subject']);
            return Datatables::eloquent($data)
                ->filter(function ($query) {

                    if (!is_null(request()->get('primary_key'))) {
                        $query->where('id', '=', request('primary_key'));
                    }

                })->smart(false)->startsWithSearch()
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('admin.page.log.index');
    }
}
