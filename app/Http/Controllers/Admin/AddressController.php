<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use App\Models\Society;
use App\Models\SocietyPeople;
use App\Models\Departament;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\{AdminCreateAddressRequest, AdminUpdateAddressRequest};
use App\Queries\SettingFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class AddressController extends Controller
{
  /**
   * Instantiate a new controller instance.
   * 
   * @return void
   */
  public function __construct()
  {
    $this->middleware(['auth', 'role:admin']);
  }

  /**
   * Display a listing of the resource.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Queries\SettingFilter   $filters
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request, SettingFilter $filters)
  {

    if (Auth::user()->society) {
      // $orders = Propal::where('fk_soc', Auth::user()->society->rowid)->count();

       // dd(Auth::user()->society);
    } else {
        $orders = 0;
    }

    $address = SocietyPeople::query()
        ->where('fk_soc', Auth::user()->society->rowid)
        ->orderBy('lastname', 'ASC')
        ->paginate();

                    

    
    $departaments = Departament::whereIn('fk_region', ['23201', '23202', '23203', '23204', '23205', '23206', '23207', '23208','23209' ])->get();


    return view('admin.address.index',compact('address', 'departaments'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $address = new SocietyPeople;

    $departaments = Departament::whereIn('fk_region', ['23201', '23202', '23203', '23204', '23205', '23206', '23207', '23208','23209' ])->orderBy('nom')->get();



    return view("admin.address.create",compact('address', 'departaments'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\Settings\AdminCreateSettingRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(AdminCreateAddressRequest $request)
  {
    $request->createAddress();

    return redirect()->route('settings.index')->with('message', 'Configuración Agregada con éxito.');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Setting  $setting
   * @return \Illuminate\Http\Response
   */
  public function show(Setting $setting)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Setting  $setting
   * @return \Illuminate\Http\Response
   */
  public function edit(SocietyPeople $address)
  {

    $departaments = Departament::whereIn('fk_region', ['23201', '23202', '23203', '23204', '23205', '23206', '23207', '23208','23209' ])->orderBy('nom')->get();

    return view("admin.address.edit",compact('address', 'departaments'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\Settings\AdminUpdateAddressRequest  $request
   * @param  \App\Models\Setting  $setting
   * @return \Illuminate\Http\Response
   */
  public function update(AdminUpdateAddressRequest $request, SocietyPeople $address)
  {
    $request->updateSetting($address);

    return redirect()->route('address.index')->with("message", "Direccion Editada con éxito.");
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Setting  $setting
   * @return \Illuminate\Http\Response
   */
  public function destroy(Setting $setting)
  {
    $setting->delete();

    return redirect()->route('settings.index')->with('message', 'Configuración Eliminada con éxito.');
  }

  /**
   * Display a listing trashed of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function trash()
  {
    $settings = Setting::onlyTrashed()->paginate();

    return view('admin.address.trash')->with("settings", $settings);
  }

  /**
   * Restore the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function restore(int $id)
  {
    $setting = Setting::onlyTrashed()->where('id', $id)->first();

    $setting->restore();

    return redirect()->back()->with('message', 'Configuración Restaurada con éxito.');
  }

  /**
   * Delete the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function delete(int $id)
  {
    $setting = Setting::onlyTrashed()->where('id', $id)->first();

    $setting->forceDelete();

    return redirect()->back()->with('message', 'Configuración Destruída con éxito.');
  }
}
