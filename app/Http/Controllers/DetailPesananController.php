<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use Illuminate\Http\Request;

class DetailPesananController extends Controller
{
    public function index()
    {
        return view('page.user.detail_pesanan.index');
    }

    public function showDetailPesanan(Request $request)
    {
        $totalFilteredRecord = $totalDataRecord = 0;
        $columns_list = [
            0 => 'idDetail',
            1 => 'idPesanan',
            2 => 'idMakanan',
            3 => 'hargasatuan',
            4 => 'jumlah',
            5 => 'total',
        ];

        $totalDataRecord = DetailPesanan::count();
        $totalFilteredRecord = $totalDataRecord;

        $limit_val = $request->input('length');
        $start_val = $request->input('start');
        $order_column = $columns_list[$request->input('order.0.column')];
        $order_dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $detailPesanan_data = DetailPesanan::offset($start_val)
                ->limit($limit_val)
                ->orderBy($order_column, $order_dir)
                ->get();
        } else {
            $search_text = $request->input('search.value');

            $detailPesanan_data = DetailPesanan::where('idDetail', 'LIKE', "%{$search_text}%")
                ->orWhere('idPesanan', 'LIKE', "%{$search_text}%")
                ->orWhere('idMakanan', 'LIKE', "%{$search_text}%")
                ->orWhere('hargasatuan', 'LIKE', "%{$search_text}%")
                ->orWhere('jumlah', 'LIKE', "%{$search_text}%")
                ->orWhere('total', 'LIKE', "%{$search_text}%")
                ->offset($start_val)
                ->limit($limit_val)
                ->orderBy($order_column, $order_dir)
                ->get();

            $totalFilteredRecord = DetailPesanan::where('idDetail', 'LIKE', "%{$search_text}%")
                ->orWhere('idPesanan', 'LIKE', "%{$search_text}%")
                ->orWhere('idMakanan', 'LIKE', "%{$search_text}%")
                ->orWhere('hargasatuan', 'LIKE', "%{$search_text}%")
                ->orWhere('jumlah', 'LIKE', "%{$search_text}%")
                ->orWhere('total', 'LIKE', "%{$search_text}%")
                ->count();
        }

        $data_val = [];
        if (!empty($detailPesanan_data)) {
            foreach ($detailPesanan_data as $detailPesanan_val) {
                $url = route('detail-pesanan.edit', ['id' => $detailPesanan_val->idDetail]);
                $urlHapus = route('detail-pesanan.delete', $detailPesanan_val->idDetail);

                $detailPesananNestedData = [
                    'idDetail' => $detailPesanan_val->idDetail,
                    'idPesanan' => $detailPesanan_val->idPesanan,
                    'idMakanan' => $detailPesanan_val->idMakanan,
                    'hargasatuan' => $detailPesanan_val->hargasatuan,
                    'jumlah' => $detailPesanan_val->jumlah,
                    'total' => $detailPesanan_val->total,
                    'options' => "<a href='$url'><i class='fas fa-edit fa-lg'></i></a> <a style='border: none; background-color:transparent;' class='hapusData' data-id='$detailPesanan_val->idDetail' data-url='$urlHapus'><i class='fas fa-trash fa-lg text-danger'></i></a>",
                ];

                $data_val[] = $detailPesananNestedData;
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

    public function ubahDetailPesanan($id, Request $request)
    {
        $detailPesanan = DetailPesanan::findOrFail($id);

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'idPesanan' => 'required|numeric',
                'idMakanan' => 'required|numeric',
                'hargasatuan' => 'required|numeric|min:1',
                'jumlah' => 'required|numeric|min:1',
                'total' => 'required|numeric|min:1',
            ]);

            $detailPesanan->update([
                'idPesanan' => $request->idPesanan,
                'idMakanan' => $request->idMakanan,
                'hargasatuan' => $request->hargasatuan,
                'jumlah' => $request->jumlah,
                'total' => $request->total,
            ]);

            return redirect()->route('detail-pesanan.edit', ['id' => $detailPesanan->idDetail])
                ->with('status', 'Data detail pesanan telah tersimpan di database');
        }

        return view('page.admin.detail_pesanan.ubahDetailPesanan', compact('detailPesanan'));
    }

    public function tambahDetailPesanan(Request $request)
    {
        if ($request->isMethod('post')) {
            DetailPesanan::create([
                'idPesanan' => $request->idPesanan,
                'idMakanan' => $request->idMakanan,
                'hargasatuan' => $request->hargasatuan,
                'jumlah' => $request->jumlah,
                'total' => $request->total,
            ]);
            return redirect()->route('detail-pesanan.add')->with('status', 'Data telah tersimpan di database');
        }

        return view('page.admin.detail_pesanan.addDetailPesanan');
    }

    public function hapusDetailPesanan($id)
    {
        $detailPesanan = DetailPesanan::findOrFail($id);
        $detailPesanan->delete();

        return response()->json([
            'msg' => 'Data yang dipilih telah dihapus'
        ]);
    }

    // Tambahkan fungsi-fungsi lain sesuai kebutuhan

}
