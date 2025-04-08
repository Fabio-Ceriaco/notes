<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;


class MainController extends Controller
{
    //================================================================

    public function index()
    {
        // load users notes
        $id = session('user.id');
        $notes = User::find($id)->notes()->get()->toArray();

        // show home view
        return view('home', ['notes' => $notes]);
    }

    //================================================================
    public function newNote()
    {

        echo 'New note';
    }

    //================================================================
    public function editNote($id)
    {
        $id = Operations::decryptId($id);

        echo $id;
    }
    //================================================================
    public function deleteNote($id)
    {
        $id = Operations::decryptId($id);

        echo $id;
    }

    //================================================================

}
