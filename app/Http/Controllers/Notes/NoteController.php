<?php

namespace App\Http\Controllers\Notes;

use App\FileUpload;
use App\Models\Note;
use App\Http\Controllers\Controller;
use App\Http\Resources\NoteResource;
use App\Models\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NoteController extends Controller
{

    public function index(Request $request): JsonResponse
    {
        $notes = Note::with('subject')->latest()->simplePaginate((int) $request->get('limit', 6));
        return response()->json($notes)->withCallback($request->callback);
    }

    public function show(Note $note)
    {
        return NoteResource::make($note);
    }

    public function store(Request $request)
    {
        sleep(1);
        //Validate
        request()->validate([
            'subject' => 'required',
            'title' => 'required',
            'description' => 'required',
            'image' => 'required'
        ]);

        $subject = Subject::findOrFail(request('subject'));
        if ($request->image) {

            $name = time() . '.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];
            \Image::make($request->image)->save(public_path('img/profile/') . $name);
            $request->merge(['image' => $name]);
        }
        $note = Note::create([
            'subject_id' => request('subject'),
            'title' => request('title'),
            'slug' => \Str::slug(request('title')),
            'description' => request('description'),
            'image' => $name
        ]);

        return response()->json([
            'massage' => 'Your Note Was Created',
            'note' => $note,
        ]);
    }

    public function update(Note $note, Request $request)
    {
        sleep(1);
        //Validate
        request()->validate([
            'subject' => 'required',
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);

        $subject = Subject::findOrFail(request('subject'));

        if ($request->image) {

            $name = time() . '.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ';')))[1])[1];
            \Image::make($request->image)->save(public_path('img/profile/') . $name);
            $request->merge(['image' => $name]);
        }

        $note->update([
            'subject_id' => request('subject'),
            'title' => request('title'),
            'description' => request('description'),
            'image' => $name
        ]);

        return response()->json([
            'massage' => 'Your Note Was Updated',
            'note' => $note,
        ]);
    }

    public function destroy(Note $note)
    {
        $note->delete();

        return response()->json([
            'massage' => 'Your Note Was Deleted',
        ], 200);
    }
}
