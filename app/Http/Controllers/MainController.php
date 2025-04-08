<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

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
        $id = $this->decryptId($id);

        echo $id;
    }
    //================================================================
    public function deleteNote($id)
    {
        $id = $this->decryptId($id);

        echo $id;
    }

    //================================================================
    private function decryptId($id)
    {

        // check if id is encrypted
        try {
            // decrypt id
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->route('index');
        }

        return $id;
    }
}
