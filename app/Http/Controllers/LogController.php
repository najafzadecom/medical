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

                    $query->orderBy('created_at', 'desc');


                })->smart(false)->startsWithSearch()
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d-m-Y H:i:s');
                })
                ->addColumn('subject', function ($row) {
                    if($row->subject_type == 'App\Models\User') {
                        return '<a href="'.route('user.show', $row->subject_id).'">İstifadəçi ID '.$row->subject_id.'</a>';
                    }
                    if($row->subject_type == 'App\Models\Order') {
                        return '<a href="'.route('order.show', $row->subject_id).'">Sifariş ID '.$row->subject_id.'</a>';
                    }
                    if($row->subject_type == 'App\Models\Package') {
                        return '<a href="'.route('package.show', $row->subject_id).'">Qablaşdırma ID '.$row->subject_id.'</a>';
                    }
                    if($row->subject_type == 'App\Models\Experiment') {
                        return '<a href="'.route('experiment.show', $row->subject_id).'">Nümunədə aparılacaq sınaqlar ID '.$row->subject_id.'</a>';
                    }
                })
                ->addColumn('subject_type', function ($row) {
                    return $row->subject_type ? config('activitylog.subject_types')[$row->subject_type] : 'Digər';
                })
                ->addColumn('description', function ($row) {
                    return $row->description == 'created' ? 'Yaratdı' : $row->description == 'updated' ? 'Yenilədi' : $row->description;
                })
                ->rawColumns(['action', 'subject'])
                ->toJson();
        }

        return view('admin.page.log.index');
    }
}
