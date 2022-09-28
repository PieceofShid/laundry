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
        $counters  = Counter::all();

        return view('laundry.index', compact('laundries', 'counters'));
    }

    public function create()
    {
        $counters = Counter::all();

        return view('laundry.create', compact('counters'));
    }

    public function post(Request $request)
    {
        try{
            $check = Laundry::where('no_invoice', $request->no_invoice)->get();
            if(count($check)){
                return redirect()->back()->with('invoice', 'Invoice sudah pernah diinput silahkan ganti nomor invoice');
            }else{
                Laundry::create($request->all());   
            }

            return redirect()->back()->with('success', 'Data berhasil ditambah');
        }catch(Exception $x){
            return redirect()->back()->with('error', $x->getMessage());
        }
    }

    public function edit($id)
    {
        $laundry = Laundry::find($id);
        $counters = Counter::all();

        return view('laundry.edit', compact('laundry', 'counters'));
    }

    public function update(Request $request, $id)
    {
        try{
            Laundry::find($id)->update($request->all());

            return redirect()->back()->with('success', 'Data berhasil diupdate');
        }catch(Exception $x){
            return redirect()->back()->with('error', $x->getMessage());
        }
    }

    public function pending()
    {
        $laundries = Laundry::where('status', 'W')->get();

        return view('laundry.pending', compact('laundries'));
    }

    public function edit_pending($id)
    {
        $laundry = Laundry::find($id);

        return view('laundry.pending_edit', compact('laundry'));
    }

    public function update_pending(Request $request, $id)
    {
        $laundry = Laundry::find($id);

        $pending = $request->jumlah_item_pending;
        $selesai = $request->jumlah_item_selesai;
        $sum     = $pending + $selesai;
        $awal    = $request->jumlah_item;
        $result  = $awal - $sum;
        if($result == 0){
            $status = 'Y';
        }else{
            $status = 'W';
        }

        try{
            $laundry->update([
                'tanggal_input_pending' => $request->tanggal_input_pending,
                'jumlah_item_pending' => $result,
                'jumlah_item_selesai' => $sum,
                'status' => $status
            ]);

            return redirect()->back()->with('success', 'Data berhasil diupdate');
        }catch(Exception $x){
            return redirect()->back()->with('error', $x->getMessage());
        }
    }

    public function selesai()
    {
        $laundries = Laundry::where('status', 'N')->get();

        return view('laundry.selesai', compact('laundries'));
    }

    public function edit_selesai($id)
    {
        $laundry = Laundry::find($id);

        return view('laundry.selesai_edit', compact('laundry'));
    }

    public function select($id)
    {
        $laundry = Laundry::with('counter')->find($id);

        return $laundry;
    }

    public function update_selesai(Request $request, $id)
    {
        $laundry    = Laundry::find($id);
        $item       = $request->jumlah_item;
        $selesai    = $request->jumlah_item_selesai;
        $pending    = $item - $selesai;
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
                'jumlah_item_pending' => $pending,
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
            $status = 'N';
        }elseif($tipe == 'keluar'){
            $status = 'Y';
        }elseif($tipe == 'pending'){
            $status = 'W';
        }

        $counter = $request->counter;
        if($counter == 'semua'){
            $conn = '!=';
            $reff = 0;
        }else{
            $conn = '=';
            $reff = $counter;
        }

        if($tipe == 'spotting'){
            $laundries = Laundry::whereBetween('tanggal_input', [$from, $to])
            ->where('counter_id', $conn, $reff)->where('menggunakan_kartu_spotting', 'Ya')->get();
        }elseif($tipe == 'masuk'){
            $laundries = Laundry::whereBetween('tanggal_input', [$from, $to])
            ->where('counter_id', $conn, $reff)->get();
        }else{
            $laundries = Laundry::whereBetween('tanggal_input', [$from, $to])
            ->where('counter_id', $conn, $reff)->where('status', $status)->get();
        }

        return view('laundry.download', compact('laundries', 'tipe', 'from', 'to'));
    }

    public function delete($id)
    {
        Laundry::find($id)->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
