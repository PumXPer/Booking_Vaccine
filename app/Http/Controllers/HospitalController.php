<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\QueryException;
use App\Models\Hospital;
use App\Models\Vaccine;

class HospitalController extends SearchableController
{
    private $title = 'Hospital';

    public function getQuery()
    {
        return Hospital::orderBy('code');
    }

    function prepareSearch($search)
    {
        $search = parent::prepareSearch($search);
        $search = array_merge([
            'minPrice' => null,
            'maxPrice' => null,
            ], $search);
        return $search;
    }

    function filterByPrice($query, $minPrice, $maxPrice)
    {
        if($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        if($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }
        return $query;
    }

    function filterBySearch($query, $search)
    {
        $query = parent::filterBySearch($query, $search);
        $query = $this->filterByPrice($query,
            $search['minPrice'], $search['maxPrice']);

        return $query;
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
        $query = $this->search($search)->withCount('vaccines');
        session()->put('bookmark.hospital-detail', $request->getUri());

        return view('hospital.list',[
            'title' => "{$this->title} : List",
            'search' => $search,
            'hospitals' => $query->paginate(5),
        ]);
    }

    public function detail(
        Request $request,
        VaccineController $vaccineController,$hospitalCode
    )
    {

        $hospital = $this->find($hospitalCode);
        $search = $vaccineController->prepareSearch($request->getQueryParams());
        $query = $vaccineController->filterBySearch($hospital->vaccines(), $search);

            return view('hospital.detail', [
            'title' => " {$hospital->name} : Detail",
            'hospital' => $hospital,
            'search' => $search,
            'vaccines' => $query->paginate(5),
        ]);
    }

    public function createForm()
    {
        $this->authorize('create', Hospital::class);

        return view('hospital.create-form',[
            'title' => "{$this->title} : Create",
        ]);
    }

    public function create(Request $request)
    {
        $this->authorize('create', Hospital::class);
        try{
        $hospital = Hospital::create($request->getParsedBody());

        return redirect()->route('hospital-list')
        ->with('status', "{$hospital->name} was created.");
        } catch(QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'error' => $excp->errorInfo[2],
            ]);
        }
    }

    public function updateForm($hospitalCode)
    {
        $this->authorize('update', Hospital::class);
        $hospital = $this->find($hospitalCode);

        return view('hospital.update-form', [
            'title' => "{$this->title} : Update",
            'hospital' => $hospital,
        ]);
    }

    public function update(Request $request, $hospitalCode)
    {
        $this->authorize('update', Hospital::class);
        try{
        $hospital = $this->find($hospitalCode);
        $hospital->fill($request->getParsedBody());
        $hospital->save();

        return redirect()->route('hospital-detail' , [
            'hospitalCode' => $hospital['code'],
            ])->with('status', "{$hospital->name} was update.");
        ;
        } catch(QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'error' => $excp->errorInfo[2],
            ]);
        }
    }

    public function delete($hospitalCode)
    {
        $this->authorize('delete', Hospital::class);
        try{
        $hospital = $this->find($hospitalCode);
        $hospital->delete();

        return redirect(session()->get('bookmark.hospital-detail', route('hospital-list')))
        ->with('status', "{$hospital->name} was deleted.");
        } catch(QueryException $excp) {
            return redirect()->back()->withErrors([
                'error' => $excp->errorInfo[2],
            ]);
        }
    }

    public function manageVaccine(
        Request $request,
        VaccineController $vaccineController,$hospitalCode
    )
    {
        $this->authorize('update', Hospital::class);
        $hospital = $this->find($hospitalCode);
        $search = $vaccineController->prepareSearch($request->getQueryParams());
        $query = $vaccineController->filterBySearch($hospital->vaccines(), $search);
        session()->put('bookmark.vaccine-detail', $request->getUri());

            return view('hospital.manage-vaccine', [
            'title' => " {$hospital->name} : Manage",
            'hospital' => $hospital,
            'search' => $search,
            'vaccines' => $query->paginate(5),
        ]);
    }

    public function addVaccineForm(
        Request $request,
        VaccineController $vaccineController,$hospitalCode
    )
    {
        $this->authorize('update', Hospital::class);
        $hospital = $this->find($hospitalCode);
        $query = Vaccine::orderBy('code')
                    ->whereDoesntHave('hospitals', function($innerQuery) use ($hospital) {
                    return $innerQuery->where('code', $hospital->code);
            });
        $search = $vaccineController->prepareSearch($request->getQueryParams());
        $query = $vaccineController->filterBySearch($query, $search);
        return view('hospital.add-vaccine-form', [
            'title' => "{$this->title} {$hospital->code} : Add Vaccine",
            'search' => $search,
            'hospital' => $hospital,
            'vaccines' => $query->paginate(5),
        ]);
    }

    public function addVaccine(
        Request $request,
        VaccineController $vaccineController,$hospitalCode
    )
    {
        $this->authorize('update', Hospital::class);
        try {
        $hospital = $this->find($hospitalCode);
        $data = $request->getParsedBody();
        $vaccine = $vaccineController->find($data['vaccine']);
        $hospital->vaccines()->attach($vaccine);

        return redirect()->route('hospital-add-vaccine-form' , [
            'vaccineCode' => $vaccine['code'],
            'hospitalCode' => $hospital['code'],
            ])->with('status', " {$vaccine->name} was added to {$hospital->name}.");
        ;
        } catch(QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'error' => $excp->errorInfo[2],
            ]);
        }
    }

    public function removeVaccine($hospitalCode, $vaccineCode)
    {
        $this->authorize('update', Hospital::class);
        try{
        $hospital = $this->find($hospitalCode);
        $vaccine = $hospital->vaccines()
            ->where('code', $vaccineCode)
            ->firstOrFail();

        $hospital->vaccines()->detach($vaccine);

        return redirect()->route('hospital-manage-vaccine' , [
            'vaccineCode' => $vaccine['code'],
            'hospitalCode' => $hospital['code'],
            ])->with('status', " {$vaccine->name} was removed from {$hospital->name}.");
        ;
        } catch(QueryException $excp) {
            return redirect()->back()->withErrors([
                'error' => $excp->errorInfo[2],
            ]);
        }
    }
}
