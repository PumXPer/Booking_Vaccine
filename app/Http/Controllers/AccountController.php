<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Database\QueryException;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccountController extends Controller
{
    function detail()
    {
        $user = auth()->user();
        $books = Books::all()
                    ->where('email', $user->email)->first();

        return view('account.detail',[
            'user' => $user,
            'books' => $books,
        ]);
    }

    public function updateForm() {
        return view('account.update-form')->with('user',auth()->user());
    }

    public function update(Request $request)
    {
        try{
            $user = auth()->user();
            $user->fill($request->getParsedBody());
            $user->save();


            return redirect()->route('account-detail')
            ->with('status', "{$user->name} was update.");
        } catch(QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'error' => $excp->errorInfo[2],
            ]);
        }
    }

}
