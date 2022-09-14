<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Laundry;
use Exception;
use Illuminate\Http\Request;

class LaundryController extends Controller
{
    public function index()
    {
        $laundries = Laundry::all();

        return view('laundry.index', compact('laundries'));
    }

    public function create()
    {
        $counters = Counter::all();

        return view('laundry.create', compact('counters'));
    }

    public function post(Request $request)
    {
        try{
            Laundry::create($request->all());

            return redirect()->back()->with('success', 'Data berhasil ditambah');
        }catch(Exception $x){
            return redirect()->back()->with('error', $x->getMessage());
        }
    }

    public function edit()
    {
        $laundries = Laundry::where('status', '!=', 'Y')->get();

        return view('laundry.edit', compact('laundries'));
    }

    public function select($id)
    {
        $laundry = Laundry::with('counter')->find($id);

        return $laundry;
    }

    public function update(Request $request, $id)
    {
        $laundry    = Laundry::find($id);
        $item       = $request->jumlah_item;
        $selesai    = $request->jumlah_item_selesai;
        if($item == $selesai){
            $status = 'Y';
        }elseif($item > $selesai && $selesai > 0){
            $status = 'W';
        }elseif($selesai == 0){
            $status = 'N';
        }

        try{
            $laundry->update([
                'tanggal_selesai' => $request->tanggal_selesai,
                'menggunakan_kartu_spotting' => $request->menggunakan_kartu_spotting,
                'catatan' => $request->catatan,
                'jumlah_item_selesai' => $selesai,
                'status' => $status
            ]);

            return redirect()->back()->with('success', 'Data berhasil diupdate');
        }catch(Exception $x){
            return redirect()->back()->with('error', $x->getMessage());
        }
    }

    public function laporan(Request $request)
    {
        $from   = $request->dari;
        $to     = $request->sampai;
        $tipe   = $request->tipe;
        if($tipe == 'proses'){
            $status = 'W';
        }elseif($tipe == 'keluar'){
            $status = 'Y';
        }

        if($tipe == 'spotting'){
            $laundries = Laundry::whereBetween('tanggal_input', [$from, $to])
            ->where('menggunakan_kartu_spotting', 'Ya')->get();
        }elseif($tipe == 'masuk'){
            $laundries = Laundry::whereBetween('tanggal_input', [$from, $to])->get();
        }else{
            $laundries = Laundry::whereBetween('tanggal_input', [$from, $to])
            ->where('status', $status)->get();
        }

        return view('laundry.download', compact('laundries', 'tipe'));
    }
}
