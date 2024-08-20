<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Http\Controllers\Controller;
use App\Http\Requests\Banners\{AdminCreateBannerRequest, AdminUpdateBannerRequest};
use App\Queries\BannerFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
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
     * @param  \App\Queries\BannerFilter   $filters
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, BannerFilter $filters)
    {
        $banners = Banner::query()
            ->filterBy($filters, $request->only(['search', 'from', 'to']))
            ->orderBy('id', 'ASC')
            ->paginate();

        $banners->appends($filters->valid());

        return view('admin.banners.index')->with('banners', $banners);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banner = new Banner;

        return view('admin.banners.create')->with('banner', $banner);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Banners\AdminCreateBannerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminCreateBannerRequest $request)
    {
        $request->createBanner();

        return redirect()->route('banners.index')->with('message', 'Banner agregado con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit')->with('banner', $banner);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Banners\AdminUpdateBannerRequest  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateBannerRequest $request, Banner $banner)
    {
        $request->updateBanner($banner);

        return redirect()->route('banners.index')->with('message', 'Banner actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect()->back()->with('message', 'Banner eliminado con éxito.');
    }

    /**
     * Display a listing trashed of the resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function trash(Banner $banners)
    {
        $banners = Banner::onlyTrashed()->orderBy('id', 'ASC')->paginate();

        return view('admin.banners.trash')->with('banners', $banners);
    }

    /**
     * Restore the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(int $id)
    {
        $banner = Banner::onlyTrashed()->where('id', $id)->first();

        $banner->restore();

        return redirect()->back()->with('message', 'Banner restaurado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(int $id)
    {
        $banner = Banner::onlyTrashed()->where('id', $id)->first();
        $image = $banner->image;

        $banner->forceDelete();

        Storage::disk('public')->delete('banners/'.$image);

        return redirect()->back()->with('message', 'Banner destruído con éxito.');
    }
}
