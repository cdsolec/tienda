<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Queries\CommentFilter;

class CommentController extends Controller
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
	 * @param  \App\Queries\CategoryFilter   $filters
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request, CommentFilter $filters)
	{
		$comments = Comment::query()
			->filterBy($filters, $request->only(['search', 'from', 'to']))
			->orderBy('id', 'DESC')
			->paginate();

		$comments->appends($filters->valid());

		return view('admin.comments.index')->with('comments', $comments);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Comment  $comment
	 * @return \Illuminate\Http\Response
	 */
	public function show(Comment $comment)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Comment  $comment
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Comment $comment)
	{
		return view("admin.comments.edit")->with("comment", $comment);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Comment  $comment
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Comment $comment)
	{
		$request->validate([
			'answer' => ['required', 'string', 'min:3', 'max:4294967200'],
		], [
			'answer.required' => 'Respuesta es requerida',
			'answer.min' => 'La Respuesta debe tener al menos 3 caracteres',
			'answer.max' => 'La Respuesta debe tener maximo 4294967200 caracteres',
		]);

		$comment->fill([
			'answered' => true,
			'answer' => $request->answer
		]);

		$comment->save();

		return redirect()->route('comments.index')->with("message", "Comentario Respondido con éxito.");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Comment  $comment
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Comment $comment)
	{
		$comment->delete();

		return redirect()->route('comments.index')->with('message', 'Comentario Eliminado con éxito.');
	}

	/**
	 * Display a listing trashed of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function trash()
	{
		$comments = Comment::onlyTrashed()->orderBy('id', 'DESC')->paginate();

		return view('admin.comments.trash')->with("comments", $comments);
	}


	/**
	 * Restore the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function restore(int $id)
	{
		$comment = Comment::onlyTrashed()->where('id', $id)->first();

		$comment->restore();

		return redirect()->back()->with('message', 'Comentario Restaurado con éxito.');
	}

	/**
	 * Delete the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function delete(int $id)
	{
		$comment = Comment::onlyTrashed()->where('id', $id)->first();

		$comment->forceDelete();

		return redirect()->back()->with('message', 'Comentario Destruído con éxito.');
	}
}
