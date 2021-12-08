<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function __construct()
    {
//        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
//        $this->middleware('permission:role-create', ['only' => ['create','store']]);
//        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::query();
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
                    $btn = '<div class="btn-group btn-group-justified">
                        <div class="btn-group">
                            <a href="'.route('role.show', $row->id).'"  class="show btn btn-light btn-sm"><i class="icon-eye2"></i></a>
                        </div>

                        <div class="btn-group">
                            <a href="'.route('role.edit', $row->id).'"  class="edit btn btn-light btn-sm"><i class="icon-pencil"></i></a>
                        </div>

                        <div class="btn-group">
                            <a href="'.route('role.destroy', $row->id).'"  class="delete btn btn-light btn-sm"><i class="icon-cross"></i></a>
                        </div>
                    </div>';
                    return $btn;
                })
                ->addColumn('enable', function ($row) {
                    return $row->enable;
                })
                ->rawColumns(['action', 'enable'])
                ->toJson();
        }

        return view('admin.page.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('admin.page.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRoleRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->all());
        $role->syncPermissions($request->input('permissions'));

        return redirect()->route('role.index')->with(['message' => 'Müvəffəqiyyətlə yaradıldı.']);
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return Response
     */
    public function show(Role $role)
    {
        return view('admin.page.role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::get();
        return view('admin.page.role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRoleRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->all());
        $role->syncPermissions($request->input('permissions'));
        return redirect()->route('role.index')->with(['message' => 'Müvəffəqiyyətlə yeniləndi.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return JsonResponse
     */
    public function destroy(Role $role)
    {
        $delete = $role->delete();
        if($delete) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
