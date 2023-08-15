<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Land;
use App\Models\Sensor;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\DataTables;

class LandDeviceController extends Controller
{
	public function index(Request $request, Land $land)
	{
		if ($request->ajax()) {
			try {
				$devices = Device::query()->where('land_id', $land->id)->with('land')->get();
			} catch (\Throwable $th) {
				$devices = [];
			}
			return Datatables::of($devices)
				->addIndexColumn()
				->setRowId(function ($row) {
					return $row->id;
				})
				->make(true);
		}
		return view('device.index', compact('land'));
	}

	public function create(Land $land)
	{
		return view('device.create', compact('land'));
	}

	public function store(Request $request, Land $land)
	{
		//validate request
		$request->validate([
			'id' => 'required|unique:devices',
			'name' => 'required',
		]);

		//create new device
		$device = new Device;
		$device->id = $request->id;
		$device->name = $request->name;
		$device->land_id = $land->id;
		$device->save();

		//return response
		return view('device.index', compact('land'));
	}

	public function show(Land $land, Device $device)
	{
        return view('device.show', compact('land', 'device'));
	}

	public function edit($id)
	{
		$data = [
			"land" => Land::get(),
			"edit" => Device::where("id", $id)->first()
		];

		return view('device.index', compact('land'));

	}

	public function update(Request $request, $id)
	{
		//validate
		$request->validate([
			'name' => 'required',
		]);
		//update device
		$device = Device::find($id);
		$device->name = $request->name;
		$device->save();
		//return response
		return view('device.index', compact('land'));
	}

	public function destroy(Land $land, $id)
	{
		try {
			$device = Device::findOrFail($id);
			$device->delete();
			return redirect()->route('lands.devices.index', $land)->with(['success' => 'devices deleted successfully.']);
		} catch (\Exception $e) {
			return redirect()->route('lands.devices.index', $land)->with(['error' => 'device could not be deleted.']);
		}
	}
}
