<?php

namespace App\Http\Controllers;

use App\Models\Vaccine;
use App\Models\Hospital;
use App\Models\Type;
use Illuminate\Database\QueryException;
use Psr\Http\Message\ServerRequestInterface as Request;

class VaccineController extends SearchableController
{
    private $title = 'Vaccine';

    public function getQuery()
    {
        return Vaccine::orderBy('code');
    }

    public function prepareSearch($search)
    {
        $search = parent::prepareSearch($search);
        $search = array_merge([
            'minPrice' => null,
            'maxPrice' => null,
            ], $search);
        return $search;
    }

    public function filterByPrice($query, $minPrice, $maxPrice)
    {
        if($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        if($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }
        return $query;
    }

    public function filterBySearch($query, $search)
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
                            ->orWhereHas('type',function($query) use ($word){
                                $query->where('name','LIKE',"%{$word}%");
                            });

                });
            }
        }
       return $query;
    }

    public function list(Request $request)
    {
        $search = $this->prepareSearch($request->getQueryParams());
        $query = $this->search($search)->withCount('hospitals');
        session()->put('bookmark.vaccine-detail', $request->getUri());

        return view('vaccine.list',[
            'title' => "{$this->title} : List",
            'search' => $search,
            'vaccines' => $query->paginate(5),
        ]);
    }

    public function detail(
        Request $request,
        HospitalController $hospitalController,$vaccineCode
    )
    {
        $vaccine = $this->find($vaccineCode);
        $search = $hospitalController->prepareSearch($request->getQueryParams());
        $query = $hospitalController->filterBySearch($vaccine->hospitals(), $search);

            return view('vaccine.detail', [
            'title' => "{$vaccine->name} {$this->title} : Detail",
            'vaccine' => $vaccine,
            'search' => $search,
            'hospitals' => $query->paginate(5),
        ]);
    }

    public function createForm()
    {
        $this->authorize('create', Vaccine::class);
        $types = Type::all();

        return view('vaccine.create-form',[
            'title' => "{$this->title} : Create",
            'types' => $types,
        ]);
    }

    public function create(Request $request)
    {
        $this->authorize('create', Vaccine::class);
        try{
        $vaccine = Vaccine::create($request->getParsedBody());

        return redirect()->route('vaccine-list')
            ->with('status', "Vaccine {$vaccine->name} was created.");;
        } catch(QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'error' => $excp->errorInfo[2],
            ]);
        }
    }

    public function updateForm($vaccineCode) {
        $this->authorize('update', Vaccine::class);
        $vaccine = $this->find($vaccineCode);
        $types = Type::all();

        return view('vaccine.update-form', [
            'title' => "{$this->title} : Update",
            'vaccine' => $vaccine,
            'types' => $types,
        ]);
    }

    public function update(Request $request, $vaccineCode)
    {
        $this->authorize('update', Vaccine::class);
        try{
        $vaccine = $this->find($vaccineCode);
        $vaccine->fill($request->getParsedBody());
        $vaccine->save();

        return redirect()->route('vaccine-detail' , [
            'vaccineCode' => $vaccine['code'],
            ])->with('status', "{$vaccine->name} was update.");;
        } catch(QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'error' => $excp->errorInfo[2],
            ]);
        }
    }

    public function delete($vaccineCode) {
        $this->authorize('delete', Vaccine::class);
        try{
        $vaccine = $this->find($vaccineCode);
        $vaccine->delete();

        return redirect(session()->get('bookmark.vaccine-detail', route('vaccine-list')))
            ->with('status', "Vaccine {$vaccine->name} was deleted.");
        } catch(QueryException $excp) {
            return redirect()->back()->withErrors([
                'error' => $excp->errorInfo[2],
            ]);
        }
    }

    public function manageHospital(
        Request $request,
        HospitalController $hospitalController,$vaccineCode
    )
    {
        $this->authorize('update', Vaccine::class);
        $vaccine = $this->find($vaccineCode);
        $search = $hospitalController->prepareSearch($request->getQueryParams());
        $query = $hospitalController->filterBySearch($vaccine->hospitals(), $search);
        session()->put('bookmark.hospital-detail', $request->getUri());

            return view('vaccine.manage-hospital', [
            'title' => " {$vaccine->name} : Manage",
            'vaccine' => $vaccine,
            'search' => $search,
            'hospitals' => $query->paginate(5),
        ]);
    }

    public function addHospitalForm(
        Request $request,
        HospitalController $hospitalController,$vaccineCode
    )
    {
        $this->authorize('update', Vaccine::class);
        $vaccine = $this->find($vaccineCode);
        $query = Hospital::orderBy('code')
                    ->whereDoesntHave('vaccines', function($innerQuery) use ($vaccine) {
                    return $innerQuery->where('code', $vaccine->code);
            });
        $search = $hospitalController->prepareSearch($request->getQueryParams());
        $query = $hospitalController->filterBySearch($query, $search);
        return view('vaccine.add-hospital-form', [
            'title' => "{$this->title} {$vaccine->code} : Add hospital",
            'search' => $search,
            'vaccine' => $vaccine,
            'hospitals' => $query->paginate(5),
        ]);
    }

    public function addHospital(
        Request $request,
        HospitalController $hospitalController,$vaccineCode
    )
    {
        $this->authorize('update', Vaccine::class);
        try{
        $vaccine = $this->find($vaccineCode);
        $data = $request->getParsedBody();
        $hospital = $hospitalController->find($data['hospital']);
        $vaccine->hospitals()->attach($hospital);

        return redirect()->route('vaccine-add-hospital-form' , [
            'hospitalCode' => $hospital['code'],
            'vaccineCode' => $vaccine['code'],
            ])->with('status', " {$hospital->name} was added to {$vaccine->name}.");
        ;
        } catch(QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'error' => $excp->errorInfo[2],
            ]);
        }
    }

    public function removeHospital($vaccineCode, $hospitalCode)
    {
        $this->authorize('update', Vaccine::class);
        try{
        $vaccine = $this->find($vaccineCode);
        $hospital = $vaccine->hospitals()
            ->where('code', $hospitalCode)
            ->firstOrFail();

        $vaccine->hospitals()->detach($hospital);

        return redirect()->route('vaccine-manage-hospital' , [
            'hospitalCode' => $hospital['code'],
            'vaccineCode' => $vaccine['code'],
            ])->with('status', " {$hospital->name} was removed from {$vaccine->name}.");
        ;
        } catch(QueryException $excp) {
            return redirect()->back()->withErrors([
                'error' => $excp->errorInfo[2],
            ]);
        }
    }

}
