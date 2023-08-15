<?php

namespace App\Http\Controllers;

use App\Helpers\DatatableHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::query()->get();
            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return DatatableHelper::createAction($row, 'users', true, true, true);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.user.index');
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,farmer',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->save();


        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = [
            "edit" => User::where("id", $id)->first()
        ];

        return view("admin.user.edit", $data);
    }

    public function update(Request $request, $id)
    {
        User::where("id", $id)->update([
            "name" => $request->name,
            "email" => $request->email,
        ]);

        return redirect()->route('users.index')->with('success', 'Update user successfully');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->forceDelete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
