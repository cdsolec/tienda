<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\{AdminCreateSettingRequest, AdminUpdateSettingRequest};
use App\Queries\SettingFilter;
use Illuminate\Http\Request;

class SettingController extends Controller
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
    $settings = Setting::query()
                        ->filterBy($filters, $request->only(['search', 'from', 'to']))
                        ->orderBy('name', 'ASC')
                        ->paginate();

    $settings->appends($filters->valid());

    return view('admin.settings.index')->with('settings', $settings);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $setting = new Setting;

    return view("admin.settings.create")->with("setting", $setting);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\Settings\AdminCreateSettingRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(AdminCreateSettingRequest $request)
  {
    $request->createSetting();

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
  public function edit(Setting $setting)
  {
    return view("admin.settings.edit")->with("setting", $setting);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \App\Http\Requests\Settings\AdminUpdateSettingRequest  $request
   * @param  \App\Models\Setting  $setting
   * @return \Illuminate\Http\Response
   */
  public function update(AdminUpdateSettingRequest $request, Setting $setting)
  {
    $request->updateSetting($setting);

    return redirect()->route('settings.index')->with("message", "Configuración Editada con éxito.");
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

    return view('admin.settings.trash')->with("settings", $settings);
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
