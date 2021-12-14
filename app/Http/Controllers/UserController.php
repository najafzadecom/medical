<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:user-show', ['only' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::query();
            return Datatables::eloquent($data)
                ->filter(function ($query) {

                    if (!is_null(request()->get('name'))) {
                        $query->where('name', 'like', "%" . request('name') . "%");
                    }

                    if (!is_null(request()->get('username'))) {
                        $query->where('username', 'like', "%" . request('username') . "%");
                    }


                    if (!is_null(request()->get('primary_key'))) {
                        $query->where('id', '=', request('primary_key'));
                    }


                })->smart(false)->startsWithSearch()
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group btn-group-justified">';

                    if(auth()->user()->can('user-show')) {
                        $btn .= '<div class="btn-group">
                            <a href="'.route('user.show', $row->id).'"  class="show btn btn-light btn-sm"><i class="icon-eye2"></i></a>
                        </div>';
                    }

                    if(auth()->user()->can('user-edit')) {
                        $btn .= '<div class="btn-group">
                                <a href="' . route('user.edit', $row->id) . '"  class="edit btn btn-light btn-sm"><i class="icon-pencil"></i></a>
                            </div>';
                    }

                    if(auth()->user()->can('user-delete')) {
                        $btn .= '<div class="btn-group">
                            <a href="'.route('user.destroy', $row->id).'"  class="delete btn btn-light btn-sm"><i class="icon-cross"></i></a>
                        </div>';
                    }

                    $btn .= '</div>';

                    return $btn;
                })
                ->addColumn('enable', function ($row) {
                    return $row->enable;
                })
                ->rawColumns(['action', 'enable'])
                ->toJson();
        }
        return view('admin.page.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.page.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->input('password'));

        if($request->hasFile('photo')) {
            $photoName = time().'.'.$request->photo->extension();
            $request->photo->move(storage_path('app/public/user'), $photoName);

            $input['photo'] = $photoName ? 'user/'.$photoName : '';
        } else {
            $input['photo'] = '';
        }

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('user.index')->with(['message' => 'Müvəffəqiyyətlə yaradıldı.']);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.page.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.page.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $input = $request->all();
        unset($input['password']);



        if($request->hasFile('photo')) {
            $photoName = time().'.'.$request->photo->extension();
            $request->photo->move(storage_path('app/public/user'), $photoName);

            $input['photo'] = $photoName ? 'user/'.$photoName : '';
        } else {
            $input['photo'] = $user->photo;
        }

        $user->update($input);
        $user->syncRoles($request->input('roles'));

        if ($request->get('password')){
            $user->update(['password' => Hash::make($request->get('password'))]);
        }


        return redirect()->route('user.index')->with(['message' => 'Müvəffəqiyyətlə yeniləndi.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        $delete = $user->delete();
        if($delete) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
