<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Makanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MakananController extends Controller
{
    public function index()
    {
        return view('page.admin.makanan.index');
    }

    public function showMakanan(Request $request)
    {
        $totalFilteredRecord = $totalDataRecord = 0;
        $columns_list = [
            0 => 'idMakanan',
            1 => 'namaMakanan',
            2 => 'hargaMakanan',
        ];
    
        $totalDataRecord = Makanan::count();
        $totalFilteredRecord = $totalDataRecord;
    
        $limit_val = $request->input('length');
        $start_val = $request->input('start');
        $order_column = $columns_list[$request->input('order.0.column')];
        $order_dir = $request->input('order.0.dir');
    
        if (empty($request->input('search.value'))) {
            $makanan_data = Makanan::offset($start_val)
                ->limit($limit_val)
                ->orderBy($order_column, $order_dir)
                ->get();
        } else {
            $search_text = $request->input('search.value');
    
            $makanan_data = Makanan::where('idMakanan', 'LIKE', "%{$search_text}%")
                ->orWhere('namaMakanan', 'LIKE', "%{$search_text}%")
                ->orWhere('hargaMakanan', 'LIKE', "%{$search_text}%")
                ->offset($start_val)
                ->limit($limit_val)
                ->orderBy($order_column, $order_dir)
                ->get();
    
            $totalFilteredRecord = Makanan::where('idMakanan', 'LIKE', "%{$search_text}%")
                ->orWhere('namaMakanan', 'LIKE', "%{$search_text}%")
                ->orWhere('hargaMakanan', 'LIKE', "%{$search_text}%")
                ->count();
        }
    
        $data_val = [];
        if (!empty($makanan_data)) {
            foreach ($makanan_data as $makanan_val) {
                $url = route('makanan.edit', ['id' => $makanan_val->idMakanan]);
                $urlHapus = route('makanan.delete', $makanan_val->idMakanan);
    
                $makananNestedData = [
                    'idMakanan' => $makanan_val->idMakanan,
                    'namaMakanan' => $makanan_val->namaMakanan,
                    'hargaMakanan' => $makanan_val->hargaMakanan,
                    'options' => "<a href='$url'><i class='fas fa-edit fa-lg'></i></a> <a style='border: none; background-color:transparent;' class='hapusData' data-id='$makanan_val->idMakanan' data-url='$urlHapus'><i class='fas fa-trash fa-lg text-danger'></i></a>",
                ];
    
                $data_val[] = $makananNestedData;
            }
        }
    
        $draw_val = $request->input('draw');
        $draw = is_numeric($draw_val) ? intval($draw_val) : 0;
    
        $get_json_data = [
            "draw" => $draw,
            "recordsTotal" => intval($totalDataRecord),
            "recordsFiltered" => intval($totalFilteredRecord),
            "data" => $data_val,
        ];
    
        return response()->json($get_json_data);
    }
    

    


    // public function showMakanan(Request $request)
    // {
    //     $makanans = Makanan::select(['id', 'namaMakanan', 'hargaMakanan'])->get();

    //     return response()->json(['data' => $makanans]);
    // }


    public function ubahMakanan($id, Request $request)
{
    $makanan = Makanan::findOrFail($id);

    if ($request->isMethod('post')) {
        $this->validate($request, [
            'namaMakanan' => 'required|string|max:200|min:3',
            'hargaMakanan' => 'required|numeric|min:1',
            // Add other validation rules as needed
        ]);

        // Update the makanan with the new data
        $makanan->update([
            'namaMakanan' => $request->namaMakanan,
            'hargaMakanan' => $request->hargaMakanan,
            // Add other fields as needed
        ]);

        return redirect()->route('makanan.edit', ['id' => $makanan->idMakanan])
            ->with('status', 'Data makanan telah tersimpan di database');
    }

    return view('page.admin.makanan.ubahMakanan', compact('makanan'));
}


    

    public function tambahMakanan(Request $request)
    {
        if ($request->isMethod('post')) {
            Makanan::create([
                'namaMakanan' => $request->namaMakanan,
                'hargaMakanan' => $request->hargaMakanan,
            ]);
            return redirect()->route('makanan.add')->with('status', 'Data telah tersimpan di database');
        }
        return view('page.admin.makanan.addMakanan');
    }

    


    public function hapusMakanan($id)
    {
        $makanan = Makanan::findOrFail($id);

        if ($makanan->user_image && Storage::exists($makanan->user_image)) {
            // Delete the image file if it exists
            Storage::delete($makanan->user_image);
        }

        $makanan->delete();

        return response()->json([
            'msg' => 'Data yang dipilih telah dihapus'
        ]);
    }

}
