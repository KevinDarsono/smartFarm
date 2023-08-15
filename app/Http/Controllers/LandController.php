<?php

namespace App\Http\Controllers;

use App\Helpers\DatatableHelper;
use App\Models\Land;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class LandController extends Controller
{

    public function index(Request $request)
    {

        if (Auth::user()->role == "admin") {
            if ($request->ajax()) {
                $users = Land::with("user")->get();
                return Datatables::of($users)
                    ->addIndexColumn()
                    ->addColumn("data_relasi", function($row) {
                        return $row->user->name;
                    })
                    ->addColumn('action', function ($row) {
                        return DatatableHelper::createAction($row, 'lands', true, true, true);
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view("admin.land.index");
        } else {
            $lands = Land::query()->get()->where('user_id', auth()->user()->id);
            if ($request->ajax()) {
                return $lands;
                return Datatables::of($lands)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    return '<img src="' . $row->getFirstMediaUrl('land-images', 'thumb') . '" alt="' . $row->name . '" class="img-thumbnail" style="width: 100px;">';
                })
                ->setRowId(function ($row) {
                    return $row->id;
                })
                ->rawColumns(['image'])
                ->make(true);
            }
            return view('land.index', compact('lands'));
        }
    }

    public function create()
    {
        $farmers = User::where('role', 'farmer')->get();
        return view('land.create', compact('farmers'));
    }

    public function store(Request $request)
    {
        // validate and store
        $request->validate([
            'name' => 'required',
            'image' => 'nullable',
            'description' => 'nullable',
            'polygon' => 'nullable',
            'area' => 'nullable',
            'crop_status' => 'nullable',
            'crop_planted_at' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'image' => $request->image,
            'description' => $request->description,
            'polygon' => $request->polygon,
            'area' => $request->area,
            'crop_status' => $request->crop_status,
            'crop_planted_at' => $request->crop_planted_at,
            'user_id' => Auth()->user()->id,
        ];

        $land = Land::create($data);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $land->addMedia($request->image)->toMediaCollection('land-images');
        }

        return redirect()->route('lands.index')
        ->with('success', 'Land created successfully.');
    }

    public function show($id)
    {
        $land = Land::findOrFail($id);
        return view('land.show', compact('land'));
    }

    public function edit($id)
    {
        $land = Land::findOrFail($id);
        $farmers = User::where('role', 'farmer')->get();
        return view('land.edit', compact('land', 'farmers'));
    }

    public function update(Request $request, $id)
    {
        try {
            $land = Land::findOrFail($id);
            $request->validate([
                'name' => 'required',
                'image' => 'nullable',
                'description' => 'nullable',
                'polygon' => 'nullable',
                'area' => 'nullable',
                'crop_status' => 'nullable',
                'crop_planted_at' => 'required',
            ]);

            $data = [
                'name' => $request->name,
                'image' => $request->image,
                'description' => $request->description,
                'polygon' => $request->polygon,
                'area' => $request->area,
                'crop_status' => $request->crop_status,
                'crop_planted_at' => $request->crop_planted_at,
                'user_id' => Auth()->user()->id,
            ];

            $land->update($data);

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $land->clearMediaCollection('land-images');
                $land->addMedia($request->image)->toMediaCollection('land-images');
            }

            return redirect()->route('lands.edit', $land->id)
            ->with('success', 'Land updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('lands.edit', $land->id)
            ->with('error', 'Land not updated.');
        }
    }

    public function destroy($id)
    {
        try {
            $land = Land::findOrFail($id);
            $land->delete();
            return redirect()->route('lands.index')->with(['success' => 'Lands deleted successfully.']);
        } catch (\Exception $e) {
            return redirect()->route('lands.index')->with(['error' => 'Land could not be deleted.']);
        }
    }

}
