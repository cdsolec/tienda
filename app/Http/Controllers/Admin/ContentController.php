<?php

namespace App\Http\Controllers\Admin;

use App\Models\Content;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contents\{AdminCreateContentRequest, AdminUpdateContentRequest};
use App\Queries\ContentFilter;
use Illuminate\Http\Request;

class ContentController extends Controller
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
     * @param  \App\Queries\ContentFilter   $filters
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ContentFilter $filters)
    {
        $contents = Content::query()
            ->filterBy($filters, $request->only(['search', 'from', 'to']))
            ->orderBy('name', 'ASC')
            ->paginate();

        $contents->appends($filters->valid());

        return view('admin.contents.index')->with('contents', $contents);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $content = new Content;

        return view('admin.contents.create')->with('content', $content);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Contents\AdminCreateContentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminCreateContentRequest $request)
    {
        $request->createContent();

        return redirect()->route('contents.index')->with('message', 'Contenido agregado con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show(Content $content)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function edit(Content $content)
    {
        return view('admin.contents.edit')->with('content', $content);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Contents\AdminUpdateContentRequest  $request
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateContentRequest $request, Content $content)
    {
        $request->updateContent($content);

        return redirect()->route('contents.index')->with('message', 'Contenido actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy(Content $content)
    {
        $content->delete();

        return redirect()->back()->with('message', 'Contenido eliminado con éxito.');
    }

    /**
     * Display a listing trashed of the resource.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function trash(Content $contents)
    {
        $contents = Content::onlyTrashed()->orderBy('name', 'ASC')->paginate();

        return view('admin.contents.trash')->with('contents', $contents);
    }

    /**
     * Restore the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(int $id)
    {
        $content = Content::onlyTrashed()->where('id', $id)->first();

        $content->restore();

        return redirect()->back()->with('message', 'Contenido restaurado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(int $id)
    {
        $content = Content::onlyTrashed()->where('id', $id)->first();

        $content->forceDelete();

        return redirect()->back()->with('message', 'Contenido destruído con éxito.');
    }
}
