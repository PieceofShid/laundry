<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('user.index', compact('users'));
    }

    public function post(Request $request)
    {
        $menu = $request->menu;
        $count = count($request->menu);
        try{
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'readonly' => $request->readonly
            ]);

            for($i = 0; $i < $count; $i++){
                Access::create([
                    'user_id' => $user->id,
                    'hak_akses' => $menu[$i]
                ]);
            }

            return redirect()->route('user.index')->with('success', 'User berhasil ditambah');
        }catch(Exception $x){
            return redirect()->route('user.index')->with('error', $x->getMessage());
        }
    }

    public function edit($id)
    {
        $user = User::with('access')->find($id);

        return $user;
    }

    public function update(Request $request, $id)
    {
        $menu = $request->menu;
        $count = count($request->menu);
        try{
            $user = User::find($id);

            if($request->password == ''){
                $user->update($request->except('password'));
            }else{
                $user->update([
                    'name' => $request->name,
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'readonly' => $request->readonly
                ]);
            }
            
            Access::where('user_id', $id)->delete();
            
            for($i = 0; $i < $count; $i++){
                Access::create([
                    'user_id' => $user->id,
                    'hak_akses' => $menu[$i]
                ]);
            }

            return redirect()->route('user.index')->with('success', 'User berhasil diupdate');
        }catch(Exception $x){
            return redirect()->route('user.index')->with('error', $x->getMessage());
        }
    }

    public function delete($id)
    {
        Access::where('user_id', $id)->delete();
        User::find($id)->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }
}
