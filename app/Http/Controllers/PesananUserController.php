<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pesanan;
use App\Models\Makanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use App\Enums\StatusPesanan;
use Illuminate\Support\Facades\DB;


class PesananUserController extends Controller
{
    protected $enumStatus = ['belum_dibayar', 'dalam_antrian', 'sedang_dibuat', 'dalam_pengiriman', 'selesai'];

    protected $fillable = [
        'namaPemesan',
        'totalHarga',
        'status',
        // Add other fields as needed
    ];
    public function index()
    {
        return view('page.user.pesanan.index');
    }

    public function getMakananList(Request $request)
    {
        $search = $request->input('search');
    
        $makananList = Makanan::where('namaMakanan', 'LIKE', '%' . $search . '%')
            ->select('idMakanan', 'namaMakanan', 'hargaMakanan')
            ->get();
    
        return response()->json($makananList);
    }
    

    public function showPesanan(Request $request)
    {
        $totalFilteredRecord = $totalDataRecord = 0;
        $columns_list = [
            0 => 'idPesanan',
            1 => 'namaPemesan',
            2 => 'totalHarga',
            3 => 'status'
        ];
    
        $totalDataRecord = Pesanan::count();
        $totalFilteredRecord = $totalDataRecord;
    
        $limit_val = $request->input('length');
        $start_val = $request->input('start');
        $order_column = $columns_list[$request->input('order.0.column')];
        $order_dir = $request->input('order.0.dir');
    
        if (empty($request->input('search.value'))) {
            $pesanan_data = Pesanan::offset($start_val)
                ->limit($limit_val)
                ->orderBy($order_column, $order_dir)
                ->get();
        } else {
            $search_text = $request->input('search.value');
    
            $pesanan_data = Pesanan::where('idPesanan', 'LIKE', "%{$search_text}%")
                ->orWhere('namaPemesan', 'LIKE', "%{$search_text}%")
                ->orWhere('totalHarga', 'LIKE', "%{$search_text}%")
                ->orWhere('status', 'LIKE', "%{$search_text}%")
                ->offset($start_val)
                ->limit($limit_val)
                ->orderBy($order_column, $order_dir)
                ->get();
    
            $totalFilteredRecord = Pesanan::where('idPesanan', 'LIKE', "%{$search_text}%")
                ->orWhere('namaPemesan', 'LIKE', "%{$search_text}%")
                ->orWhere('totalHarga', 'LIKE', "%{$search_text}%")
                ->orWhere('status', 'LIKE', "%{$search_text}%")
                ->count();
        }
    
        $data_val = [];
        if (!empty($pesanan_data)) {
            foreach ($pesanan_data as $pesanan_val) {
                $url = route('user.pesanan.user.edit', ['id' => $pesanan_val->idPesanan]);
                $urlHapus = route('user.pesanan.user.delete', $pesanan_val->idPesanan);
    
                $pesananNestedData = [
                    'idPesanan' => $pesanan_val->idPesanan,
                    'namaPemesan' => $pesanan_val->namaPemesan,
                    'totalHarga' => $pesanan_val->totalHarga,
                    'status' => $pesanan_val->status,
                    'options' => "<a href='$url'><i class='fas fa-edit fa-lg'></i></a> <a style='border: none; background-color:transparent;' class='hapusData' data-id='$pesanan_val->idPesanan' data-url='$urlHapus'><i class='fas fa-trash fa-lg text-danger'></i></a>",
                ];
    
                $data_val[] = $pesananNestedData;
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

    public function ubahPesanan($id, Request $request)
{
    $pesanan = Pesanan::findOrFail($id);

    if ($request->isMethod('post')) {
        $this->validate($request, [
            'namaPemesan' => 'required|string|max:200|min:3',
            'totalHarga' => 'required|numeric|max:200|min:4',
            'status' => 'required|in:belum_dibayar,dalam_antrian,sedang_dibuat,dalam_pengiriman,selesai',
            // Add other validation rules as needed
        ]);

        // Update the pesanan with the new data
        $pesanan->update([
            'namaPemesan' => $request->namaPemesan,
            'totalHarga' => $request->totalHarga,
            'status' => $request->status,
            // Add other fields as needed
        ]);

        return redirect()->route('pesanan.edit', ['id' => $pesanan->idPesanan])
            ->with('status', 'Data pesanan telah tersimpan di database');
    }

    return view('page.admin.pesanan.ubahPesanan', compact('pesanan'));
}




    
public function tambahPesanan(Request $request)
{
    try {
        if ($request->isMethod('post')) {
            $user_id = Auth::id(); // Mendapatkan ID pengguna yang sedang login

            // Create a new Pesanan instance
            $pesanan = Pesanan::create([
                'user_id' => $user_id,
                'namaPemesan' => $request->namaPemesan,
                'totalHarga' => $request->totalHarga,
                'status' => $request->status,
                // Tambahkan kolom lain sesuai kebutuhan
            ]);
            

           // Iterate through the pesananList and insert each item into detail_pesanan
            foreach ($request->pesananList['idMakanan'] as $key => $idMakanan) {
                $makanan = Makanan::find($idMakanan); // Retrieve the Makanan model
                $hargaSatuan = $makanan->hargaMakanan; // Get the hargaSatuan from the Makanan model
                try {
                    // Your database operations here
                    DB::table('detail_pesanan')->insert([
                        'idPesanan' => $pesanan->idPesanan, // Use the ID of the created pesanan
                        'jumlah' => $request->pesananList['jumlah'][$key],
                        'hargasatuan' => $hargaSatuan, // Insert hargaSatuan
                        'total' => $request->pesananList['jumlah'][$key] * $hargaSatuan, // Calculate the total harga
                        'idMakanan' => $idMakanan,
                        // Add other columns as needed
                    ]);
                } catch (\Exception $e) {
                    // Log or print the exception
                    dd($e->getMessage());
                }
                
                
            }


            return redirect()->route('user.pesanan.user.add')->with('status', 'Data telah tersimpan di database');
        }
    } catch (ValidationException $e) {
        // Tangani pengecualian validasi jika diperlukan
        return back()->withErrors($e->validator->errors())->withInput();
    } catch (QueryException $e) {
        // Tangani pengecualian query database jika diperlukan
        return back()->with('error', 'Terjadi kesalahan dalam menyimpan data.');
    } catch (Exception $e) {
        // Tangani pengecualian umum jika diperlukan
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }

    return view('page.user.pesanan.addPesanan');
}


// public function tambahPesanan(Request $request)
// {
//     if ($request->isMethod('post')) {
//         $this->validate($request, [
//             'namaPemesan' => 'required|string|max:200|min:3',
//             'totalHarga' => 'required|numeric|max:200|min:4',
//             'status' => 'required|in:belum_dibayar,dalam_antrian,sedang_dibuat,dalam_pengiriman,selesai',
//             // Tambahkan aturan validasi lainnya jika diperlukan
//         ]);

//         // Gunakan input dari request untuk membuat objek Pesanan
//         $pesanan = new Pesanan([
//             'namaPemesan' => $request->input('namaPemesan'),
//             'totalHarga' => $request->input('totalHarga'),
//             'status' => $request->input('status'),
//             // Tambahkan kolom lain jika diperlukan
//         ]);

//         // Simpan objek Pesanan ke database
//         $pesanan->save();

//         return redirect()->route('pesanan.add')->with('status', 'Data telah tersimpan di database');
//     }

//     return view('page.admin.pesanan.addPesanan');
// }


    


    public function hapusPesanan($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        if ($pesanan->user_image && Storage::exists($pesanan->user_image)) {
            // Delete the image file if it exists
            Storage::delete($pesanan->user_image);
        }

        $pesanan->delete();

        return response()->json([
            'msg' => 'Data yang dipilih telah dihapus'
        ]);
    }

}