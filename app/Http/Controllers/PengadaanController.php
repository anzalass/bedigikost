<?php

namespace App\Http\Controllers;

use App\Http\Requests\PengadaanRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Pengadaan;
use App\Models\User;

class PengadaanController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function index(){
        $pengadaan = Pengadaan::all();

        return response()->json([
            'results' => $pengadaan
        ],200);
    }

    public function TambahPengadaan(PengadaanRequest $request){
        try{
            Pengadaan::create([
                'namaBarang' => $request->namaBarang,
                'merek' => $request->merek,
                'hargaBarang'=> $request->hargaBarang,
                'quantity' => $request->quantity,
                'spesifikasi' => $request->spesifikasi,
                'ruang' => $request->ruang,
                'supplier' => $request->supplier,
                'buktiNota' => $request->buktiNota
            ]);
            return response()->json([
                'message' => "Pengadaan Successfully Created"
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e
            ],500);
        }
    }

    public function FindByKategori($kodeBarang,$ruang){
        try{
            $pengadaan = Pengadaan::where('kodeBarang',$kodeBarang)->first();
            if($pengadaan){
                return response()->json([
                    'results' => $pengadaan
                ],200);
            }
            return response()->json([
                'message' => "Barang tidak ditemukan"
            ],404);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e
            ],500);
        }
    }

    public function getBarangRuangan($kodeRuang){
        try{
            $pengadaan = Pengadaan::where("ruang",$kodeRuang)->first();
            if($pengadaan){
                return response()->json([
                    'results' => $pengadaan
                ],200);
            }

            return response()->json([
                'message' => 'Tidak Ada Barang'
            ],404);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e
            ],500);
        }
    }

    public function UpdatePengadaan(PengadaanRequest $request, $id){
        try{
            $pengadaan = Pengadaan::find($id);
            if(!$pengadaan){
                return response()->json([
                    'message' =>"Pengadaan not found."
                ],404);
            }

            $pengadaan->namaBarang = $request->namaBarang;
            $pengadaan->merek = $request->merek;
            $pengadaan->quantity = $request->quantity;
            $pengadaan->hargaBarang = $request->hargaBarang;
            $pengadaan->spesifikasi = $request->spesifikasi;
            $pengadaan->ruang = $request->ruang;
            $pengadaan->supplier = $request->supplier;
            $pengadaan->buktiNota = $request->buktiNota;

            $pengadaan->save();

            return response()->json([
                'message' => "Pengadaan Successfully Updated"
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e
            ],500);
        }
    }

    public function FindPengadaan($id){
        $pengadaan = Pengadaan::find($id);

        if($pengadaan){
            return response()->json([
                'results' => $pengadaan
            ],200);
        }else{
            return response()->json([
                'message' =>"Pengadaan not found."
            ],404);
        }
    }

    public function DeletePengadaan($id){
        $pengadaan = Pengadaan::find($id);

        if(!$pengadaan){
            return response()->json([
            'message' =>"Pengadaan not found."
            ],404);
        }

        $pengadaan->delete();

        return response()->json([
            'message' =>"Pengadaan successfully deleted."
        ],200);
    }
}