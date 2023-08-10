<?php

namespace App\Http\Controllers\retailer;

use App\Http\Controllers\Controller;
use App\Models\Retailer;
use DataTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class RetailerController extends Controller
{
    public function index()
    {
        return view('content.retailers.create-retailer');
    }
    public function createRetailer(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'required|mimes:png,jpg,jpeg,svg|max:2048',
            'energy' => 'required',
            'broadband' => 'required',
            'retailer_status' => 'required',
            'tncText' => 'required',
        ], [
            'tncText.required' => 'The terms & conditions field is required.',
        ]);
        try {
            $retailer = new Retailer();
            $retailer->name = $request->name;
            $retailer->energy = $request->energy;
            $retailer->broadband = $request->broadband;
            $retailer->tncText = $request->tncText;
            $retailer->active = $request->retailer_status;

            if ($request->hasFile('logo')) {

                $img = Image::make($request->file('logo'));
                $destination = public_path('storage/retailerLogos/');
                $file = $request->file('logo');
                $imageName = time() . "-" . Str::slug($request->name) . "-logo." . $file->extension();
                // $image->move($destination, $imageName);

                $canvas = Image::canvas(500, 150);
                $image = $img->resize(500, 150, function ($constraint) {
                    $constraint->aspectRatio();
                    // $constraint->upsize();
                });
                $canvas->insert($image, 'center');
                $canvas->save($destination . $imageName, 100);
                $retailer->logo = $imageName;
            }

            $retailer->save();
            return redirect()->route('retailer-retailers-list')->with('success', 'Retailer Successfully Created.');
        } catch (Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }

    }
    public function retailers()
    {
        return view('content.retailers.retailer-list');
    }

    public function retailerList(Request $request)
    {
        if ($request->ajax()) {
            $data = Retailer::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('logo', function ($row) {
                    $logo = $row->logo != "" ? '<a href="' . asset('storage/retailerLogos/' . $row->logo) . '" data-lightbox="image-'.$row->id.'" data-title="'.$row->name.'"><img src="' . asset('storage/retailerLogos/' . $row->logo) . '" alt="" width="100" height="60"></a>' : '<a href="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png" data-lightbox="image-'.$row->id.'" data-title="'.$row->name.'"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png" alt="" width="100" height="60"></a>';
                    return $logo;

                })
                ->addColumn('energy', function ($row) {
                    $energyBtn = $row->energy == 1 ? 'Yes' : 'No';
                    return $energyBtn;
                })
                ->addColumn('broadband', function ($row) {
                    $broadbandBtn = $row->broadband == 1 ? 'Yes' : 'No';
                    return $broadbandBtn;
                })
                ->addColumn('status', function ($row) {
                    $statusBtn = '<div class="form-check form-switch" style="padding-left: 6em !important;">';
                    $statusBtn .= '<input class="form-check-input" onclick="statusChange(' . $row->id . ')" type="checkbox" id="statusBtn"';
                    $statusBtn .= $row->active == 'Yes' ? ' checked' : '';
                    $statusBtn .= '>';
                    $statusBtn .= '</div>';
                    return $statusBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route("retailer-edit", ['id' => $row->id]) . '" class="edit btn btn-success btn-sm"><i class="bx bx-edit"></i></a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" onclick="retailerDelete(' . $row->id . ')"><i class="bx bx-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['logo', 'energy', 'broadband', 'status', 'action'])
                ->make(true);
        }
    }

    public function retailerStatusChange(Request $request)
    {
        try {
            $retailer = Retailer::find($request->retailer_id);
            $retailer->active = $retailer->active == "Yes" ? "No" : "Yes";
            $retailer->update();
            return response()->json(['status' => 'success', 'msg' => 'retailer Status Changed.']);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'msg' => $e->getMessage()]);
        }

    }
    public function editForm($id)
    {
        $retailer = Retailer::where('id', $id)->first();
        return view('content.retailers.edit-retailer', ['retailer' => $retailer]);
    }

    public function updateRetailer(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'logo' => 'mimes:png,jpg,jpeg,svg',
            'energy' => 'required',
            'broadband' => 'required',
            'retailer_status' => 'required',
            'tncText' => 'required',
        ], [
            'tncText.required' => 'The terms & conditions field is required.',
        ]);

        try {
            $retailer = Retailer::find($request->retailer_id);
            $retailer->name = $request->name;
            $retailer->energy = $request->energy;
            $retailer->broadband = $request->broadband;
            $retailer->tncText = $request->tncText;
            $retailer->active = $request->retailer_status;

            if ($request->hasFile('logo')) {
                $img = Image::make($request->file('logo'));
                $destination = public_path('storage/retailerLogos/');
                $file = $request->file('logo');
                if ($retailer->logo != null) {
                    $oldImg = $destination . '' . $retailer->logo;
                    unlink($oldImg);
                }
                $imageName = time() . "-" . Str::slug($request->name) . "-logo." . $file->extension();

                $canvas = Image::canvas(500, 150);
                $image = $img->resize(500, 150, function ($constraint) {
                    $constraint->aspectRatio();
                    // $constraint->upsize();
                });
                $canvas->insert($image, 'center');
                $canvas->save($destination . $imageName, 100);

                $retailer->logo = $imageName;
            }

            $retailer->update();
            return redirect()->route('retailer-retailers-list')->with('success', 'Retailer Successfully Update.');
        } catch (Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }

    }
    public function retailerDelete(Request $request)
    {
        try {
            $retailer = Retailer::find($request->retailer_id);
            if ($retailer->logo != null) {
                $destination = public_path('storage/retailerLogos/');
                $oldImg = $destination . '' . $retailer->logo;
                unlink($oldImg);
            }
            $retailer->delete();
            return response()->json(['status' => 'success', 'msg' => 'Retailer Successfully Deleted.']);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'msg' => $e->getMessage()]);
        }
    }

}
