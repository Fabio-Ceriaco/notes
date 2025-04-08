<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;
use LDAP\Result;

class MainController extends Controller
{
    //================================================================

    public function index()
    {
        // load users notes
        $id = session('user.id');
        $notes = User::find($id)->notes()->whereNull('deleted_at')->get()->toArray();

        // show home view
        return view('home', ['notes' => $notes]);
    }

    //================================================================
    public function newNote()
    {

        // show new note view
        return view('new_note');
    }

    //================================================================
    public function newNoteSubmit(Request $request)
    {

        // validate resquest

        $request->validate(
            // rules
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000',
            ],
            // messages
            [
                'text_title.required' => 'Title is required.',
                'text_title.min' => 'Note title must have at least :min characters.',
                'text_title.max' => 'Note title must have at least :max characters.',
                'text_note.required' => 'Note is required.',
                'text_note.min' => 'Your note must have at least :min characters.',
                'text_note.max' => 'Your note must have at least :max characters.',
            ],
        );

        // get user id
        $userId = session('user.id');

        // create new note
        $newNote = new Note();
        $newNote->user_id = $userId;
        $newNote->title = $request->input('text_title');
        $newNote->text = $request->input('text_note');
        $newNote->save();

        // redirect Index
        return redirect()->route('index');
    }

    //================================================================
    public function editNote($id)
    {
        $id = Operations::decryptId($id);

        // load note
        $note = Note::find($id);

        // show edit note view

        return view('edit_note', ['note' => $note]);
    }

    //================================================================
    public function  editNotesubmit(Request $request)
    {

        // validate resquest

        $request->validate(
            // rules
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000',
            ],
            // messages
            [
                'text_title.required' => 'Title is required.',
                'text_title.min' => 'Note title must have at least :min characters.',
                'text_title.max' => 'Note title must have at least :max characters.',
                'text_note.required' => 'Note is required.',
                'text_note.min' => 'Your note must have at least :min characters.',
                'text_note.max' => 'Your note must have at least :max characters.',
            ],
        );

        // check if note_id exists
        if ($request->input('note_id') == null) {
            return redirect()->route('index');
        }
        // decrypt note_id

        $noteId = Operations::decryptId($request->input('note_id'));

        // load note
        $note = Note::find($noteId);
        // update note
        $note->title = $request->input('text_title');
        $note->text = $request->input('text_note');
        $note->save();
        // redirect to index

        return redirect()->route('index');
    }
    //================================================================

    public function deleteNote($id)
    {
        // decrypt note_id
        $id = Operations::decryptId($id);

        // load note
        $note = Note::find($id);

        // show delete note confirmation
        return view('delete_note', ['note' => $note]);
    }

    //================================================================
    public function deleteNoteConfirm($id)
    {

        // decrypt note_id
        $id = Operations::decryptId($id);

        // load note
        $note = Note::find($id);

        // hard delete
        // $note->delete();

        // soft delete
        // $note->deleted_at = now();
        // $note->save();

        // soft delete (property SoftDeletes in model)
        $note->delete();

        // hard delete (property SoftDeletes in model)
        // $note->forceDelete();

        // redirect home

        return redirect()->route('index');
    }
}
