<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Hospital;
use App\Models\Vaccine;
use App\Models\Books;
use Illuminate\Database\QueryException;
use GuzzleHttp\Promise\Create;

class BooksController extends SearchableController
{
    public function getQuery()
    {
        return Hospital::orderBy('code');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function filterByTerm($query, $term)
    {
        if(!empty($term)) {
            $words = preg_split('/\s+/', $term);

            foreach($words as $word) {
                $query->where(function($innerQuery) use ($word) {
                    return $innerQuery
                            ->where('name','LIKE',"%{$word}%")
                            ->orWhere('code','LIKE',"%{$word}%")
                            ->orWhere('status','LIKE',"%{$word}%");
                });
            }
        }

        return $query;
    }

    public function list(Request $request)
    {
        $search = $this->prepareSearch($request->getQueryParams());
        $query = $this->search($search);
        session()->put('bookmark.hospital-detail', $request->getUri());

        return view('books.list',[
            'title' => "test : List",
            'search' => $search,
            'hospitals' => $query->paginate(5),
        ]);
    }

    function detail()
    {

        $user = auth()->user();
        $books = Books::all()
                    ->where('email', $user->email)->first();
        $hospital = Hospital::all()
                    ->where('name', $books->hospital)->first();

        return view('books.detail',[
            'user' => $user,
            'books' => $books,
            'hospital' => $hospital,
        ]);
    }

    function createForm(
        Request $request,
        VaccineController $vaccineController,$hospitalCode
    )
    {
        $hospital = $this->find($hospitalCode);
        $search = $vaccineController->prepareSearch($request->getQueryParams());
        $query = $vaccineController->filterBySearch($hospital->vaccines(), $search);

            return view('books.create-form', [
            'hospital' => $hospital,
            'search' => $search,
            'vaccines' => $query->paginate(),
        ]);
    }

    function create(Request $request,$hospitalCode)
    {
        try {
        $hospitals = Hospital::all()
                    ->where('code', $hospitalCode)->firstOrFail();
        $hospital = $hospitals->name;
        $user = auth()->user();
        $email = $user->email;
        $data = $request->getParsedBody();
        $vaccinesI = $data['vaccineI'];
        $vaccinesII = $data['vaccineII'];
        $priceVaccineI = Vaccine::all()
                    ->where('name', $vaccinesI)->firstOrFail();
        if ($vaccinesII === "-")
        {
            $priceVaccineII['price'] = 0;
        }
        else
        {
            $priceVaccineII = Vaccine::all()
                ->where('name', $vaccinesII)->firstOrFail();
        }
        $priceI = $priceVaccineI['price'];
        $priceII = $priceVaccineII['price'];
        $total = $priceI + $priceII;

        $books = Books::create([
            'email' => $email,
            'vaccineI' => $vaccinesI,
            'priceI' => $priceI,
            'vaccineII' => $vaccinesII,
            'priceII' => $priceII,
            'total_price' => $total,
            'hospital' => $hospital,
        ]);

        return redirect()->route('books-detail')
        ->with('status', "{$user->name} add Vaccine.");
        } catch(QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'error' => $excp->errorInfo[2],
            ]);
        }
    }

    function updateForm(
        Request $request,
        VaccineController $vaccineController,$hospitalCode
    )
    {
        $user = auth()->user();
        $books = Books::all()
                    ->where('email', $user->email)->first();
        $hospital = $this->find($hospitalCode);
        $search = $vaccineController->prepareSearch($request->getQueryParams());
        $query = $vaccineController->filterBySearch($hospital->vaccines(), $search);

            return view('books.update-form', [
            'hospital' => $hospital,
            'books' => $books,
            'vaccines' => $query->paginate(),
        ]);
    }

    public function update(Request $request)
    {
        try {
        $data = $request->getParsedBody();
        $vaccinesI = $data['vaccineI'];
        $vaccinesII = $data['vaccineII'];
        $priceVaccineI = Vaccine::all()
                    ->where('name', $vaccinesI)->firstOrFail();
        if ($vaccinesII === "-")
        {
            $priceVaccineII['price'] = 0;
        }
        else
        {
            $priceVaccineII = Vaccine::all()
                ->where('name', $vaccinesII)->firstOrFail();
        }
        $priceI = $priceVaccineI['price'];
        $priceII = $priceVaccineII['price'];
        $total = $priceI + $priceII;
        $user = auth()->user();
        $books = Books::all()
                    ->where('email', $user->email)->first();
        $books->fill([
            'vaccineI' => $vaccinesI,
            'priceI' => $priceI,
            'vaccineII' => $vaccinesII,
            'priceII' => $priceII,
            'total_price' => $total,
        ]);
        $books->save();

        return redirect()->route('books-detail')
        ->with('status', "{$user->name} update Vaccine.");
        } catch(QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'error' => $excp->errorInfo[2],
            ]);
        }
    }
}

