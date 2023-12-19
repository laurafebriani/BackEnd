<?php

namespace App\Http\Controllers;

use App\Models\Pantai;
use Illuminate\Http\Request;

class PantaiController extends Controller
{
    public function getpantai(){
        $data = Pantai::all();
        if($data){
            return response()->json([
                'nama_pantai'=>200,
                'message'=>'berhasil menampilkan data',
                'data'=> $data
            ]);
        }
        return response()->json([
            'status'=> 404,
            'message'=> 'Data tidak tersedia'
        ]);
    }

    public function postpantai(Request $request){
        $data = Pantai::create([
            'nama_pantai' => $request->nama_pantai,
            'gambar' => $request->gambar,
            'deskripsi' => $request->deskripsi,
            
        ]);
        if($data){
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil Menambahkan Data',
                'data'=> $data
            ]);
        }
        return response()->json([
            'status' => 404,
            'message' => 'Gagal Menambahkan Data'
        ]);
    }
}