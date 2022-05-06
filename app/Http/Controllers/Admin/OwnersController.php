<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Throwable;
use Illuminate\Support\Facades\Log;
class OwnersController extends Controller
{
    public function __construct()
    {
        // routeに書いているのでここに書かなくてもよい
        // $this->middleware('auth:admin');
    }
    
    public function index()
    {
        // $date_now = Carbon::now();
        // $date_parse = Carbon::parse(now());
        // echo $date_now;
        // echo $date_parse;
        // $e_all = Owner::all();
        // $q_get = DB::table('owners')->select('name', 'created_at')->get();
        // $q_first = DB::table('owners')->select('name', 'created_at')->first();
        // $c_test = collect([
        //     'name' => 'test',
        // ]);
        // var_dump($q_first);
        // dd($e_all, $q_get, $q_first, $c_test);

        $owners = Owner::select('id', 'name', 'email', 'created_at')->paginate(5);
        return view('admin.owners.index', compact('owners'));
    }

    public function create()
    {
        return view('admin.owners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:owners'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        try {
            DB::transaction(function() use ($request){
                $owner = Owner::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                Shop::create([
                    'owner_id' => $owner->id,
                    'name' => '店名を入力してください',
                    'information' => '',
                    'filename' => '',
                    'is_selling' => true,
                ]);
            }, 2);
        } catch(Throwable $e) {
            Log::error($e);
            throw $e;
        }

        return redirect()
        ->route('admin.owners.index')
        ->with([
            'message' => 'オーナー登録を実施しました。',
            'status' => "info",
        ]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $owner = Owner::findOrFail($id);
        // dd($owner);
        return view('admin.owners.edit', compact('owner'));
    }

    public function update(Request $request, $id)
    {
        $owner = Owner::findOrFail($id);
        $owner->name = $request->name;
        $owner->email = $request->email;
        $owner->password = Hash::make($request->password);
        $owner->save();
        return redirect()->
        route('admin.owners.index')->
        with([
            'message' => "オーナー情報を更新しました。",
            'status' => "info",
        ]);
    }

    public function destroy($id)
    {
        Owner::findOrFail($id)->delete();
        return redirect()->
        route('admin.owners.index')->
        with([
            'message' => "オーナー情報を削除しました。",
            'status' => "alert",
        ]);
    }

    public function expiredOwnerIndex(){
        $expiredOwners = Owner::onlyTrashed()->get();
        return view('admin.expired-owners', compact('expiredOwners'));
    }
    
    public function expiredOwnerRestore($id){
        Owner::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->
        route('admin.owners.index')->
        with([
            'message' => "オーナー情報を復元しました。",
            'status' => "info",
        ]);
    }
    public function expiredOwnerDestroy($id){
        Owner::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.expired-owners.index')->
        with([
            'message' => "オーナー情報を完全に削除しました。",
            'status' => "alert",
        ]);;
    }
}
