<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\Books;
use Illuminate\Support\Facades\Hash;


class UserController extends SearchableController
{
    private $title = 'User';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getQuery()
    {
        return User::orderBy('email');
    }

    public function filterByTerm($query, $term)
    {
        if(!empty($term)) {
            $words = preg_split('/\s+/', $term);

            foreach($words as $word) {
                $query->where(function($innerQuery) use ($word) {
                    return $innerQuery
                            ->where('email','LIKE',"%{$word}%")
                            ->orWhere('name','LIKE',"%{$word}%")
                            ->orWhere('role','LIKE',"%{$word}%");
                });
            }
        }

        return $query;
    }

    public function list(Request $request)
    {
        $this->authorize('read', User::class);
        $search = $this->prepareSearch($request->getQueryParams());
        $query = $this->search($search);
        session()->put('bookmark.user-detail', $request->getUri());

        return view('user.list',[
            'title' => "{$this->title} : List",
            'search' => $search,
            'users' => $query->paginate(5),
        ]);
    }

    public function detail($email)
    {
        $user = User::where('email', $email)->first();
        $books = Books::where('email', $user->email)->first();

        return view('user.detail',[
            'title' => "{$this->title} : View",
            'user' => $user,
            'books' => $books,
        ]);
    }

    public function createForm()
    {

        $roles = ['ADMIN' , 'USER'];

        return view('user.create-form',[
            'title' => "{$this->title} : Create",

            'roles' => $roles,
        ]);
    }

    public function create(Request $request)
    {
        try{

        $data = $request->getParsedBody();
        $user = new User();
        $user->name = $data['name'];
        $user->id_card = $data['id_card'];
        $user->email = $data['email'];
        $user-> role = $data['role'];
        $user->password = Hash::make($data['password']);
        $user->save();

        return redirect()->route('user-list')->with('status',"User {$user->name} was created.");
        } catch(QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'error' => $excp->errorInfo[2],
            ]);
        }
    }

    public function updateForm($email)
    {
        $user = User::where('email', $email)->first();
        $roles = ['ADMIN','USER'];

        return view('user.update-form', [
            'title' => "{$this->title} : Update",
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, $email)
    {
        try{
        $user = User::where('email', $email)->first();
        $user->fill($request->getParsedBody());
        $user->password = Hash::make($user['password']);
        $user->save();

        return redirect()->route('user-detail' , [
            'email' => $user['email'],
            ])->with('status', "User {$user->name} was update.");
        ;
        } catch(QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'error' => $excp->errorInfo[2],
            ]);
        }
    }

    public function delete($email)
    {
        try {
        $user = User::where('email', $email)->first();
        $user->delete();

        return redirect(session()->get('bookmark.user-detail', route('user-list')))
        ->with('status', "User {$user->name} was deleted.");
    ;;
        } catch(QueryException $excp) {
            return redirect()->back()->withErrors([
                'error' => $excp->errorInfo[2],
            ]);
        }
    }
}


