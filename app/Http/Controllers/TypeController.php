<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Vaccine;
use Illuminate\Database\QueryException;
use Psr\Http\Message\ServerRequestInterface as Request;


class TypeController extends SearchableController
{
    private $title = 'Type';

    public function getQuery()
    {
        return Type::orderBy('code');
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

    public function list(Request $request)
    {
        $search = $this->prepareSearch($request->getQueryParams());
        $query = $this->search($search)->withCount('vaccines');
        session()->put('bookmark.type-detail', $request->getUri());

        return view('type.list',[
            'title' => "{$this->title} : List",
            'search' => $search,
            'types' => $query->paginate(5),
        ]);
    }

    public function detail(
        Request $request,
        VaccineController $vaccineController,$typeCode
    )
    {
        $type = $this->find($typeCode);
        $search = $vaccineController->prepareSearch($request->getQueryParams());
        $query = $vaccineController->filterBySearch($type->vaccines(), $search);
        session()->put('bookmark.vaccine-detail', $request->getUri());

            return view('type.detail', [
            'title' => "{$type->name} : Detail",
            'type' => $type,
            'search' => $search,
            'vaccines' => $query->paginate(5),
        ]);
    }

    public function createForm()
    {
        $this->authorize('create', Type::class);

        return view('type.create-form',[
            'title' => "{$this->title} : Create",
        ]);
    }

    public function create(Request $request)
    {
        $this->authorize('create', Type::class);
        try{
        $type = Type::create($request->getParsedBody());

        return redirect()->route('type-list')
            ->with('status', "{$type->name} was created.");
        } catch(QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'error' => $excp->errorInfo[2],
            ]);
        }
    }

    public function updateForm($typeCode)
    {
        $this->authorize('update', Type::class);
        $type = $this->find($typeCode);

        return view('type.update-form', [
            'title' => "{$this->title} : Update",
            'type' => $type,
        ]);
    }

    public function update(Request $request, $typeCode)
    {
        $this->authorize('update', Type::class);
        try{
        $type = $this->find($typeCode);
        $type->fill($request->getParsedBody());
        $type->save();

        return redirect()->route('type-detail' , [
            'typeCode' => $type['code'],
            ])->with('status', "{$type->name} was update.");
        ;
        } catch(QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'error' => $excp->errorInfo[2],
            ]);
        }
    }

    public function delete($typeCode)
    {
        $type = $this->find($typeCode);
        try{
        $this->authorize('delete', $type);
        $type->delete();

        return redirect(session()->get('bookmark.type-detail', route('type-list')))
        ->with('status', "{$type->name} was deleted.");
        } catch(QueryException $excp) {
            return redirect()->back()->withErrors([
                'error' => $excp->errorInfo[2],
            ]);
        }
    }

    public function manageVaccine(
        Request $request,
        VaccineController $vaccineController,$typeCode
    )
    {
        $this->authorize('update', Type::class);
        $type = $this->find($typeCode);
        $search = $vaccineController->prepareSearch($request->getQueryParams());
        $query = $vaccineController->filterBySearch($type->vaccines(), $search);
        session()->put('bookmark.vaccine-detail', $request->getUri());

            return view('type.manage-vaccine', [
            'title' => " {$type->name} : Manage",
            'type' => $type,
            'search' => $search,
            'vaccines' => $query->paginate(5),
        ]);
    }

    function addVaccineForm(
        Request $request,
        VaccineController $vaccineController,$typeCode
    )
    {
        $this->authorize('update', Type::class);
        $type = $this->find($typeCode);
        $query = Vaccine::orderBy('code')
                    ->whereDoesntHave('type', function($innerQuery) use ($type) {
                    return $innerQuery->where('code', $type->code);
            });
        $search = $vaccineController->prepareSearch($request->getQueryParams());
        $query = $vaccineController->filterBySearch($query, $search);

        return view('type.add-vaccine-form', [
            'title' => " {$type->name} : Add Vaccine",
            'search' => $search,
            'type' => $type,
            'vaccines' => $query->paginate(5),
        ]);
    }

    function addVaccine(
        Request $request,
        VaccineController $vaccineController,$typeCode
    )
    {
        $this->authorize('update', Type::class);
        try{
        $type = $this->find($typeCode);
        $data = $request->getParsedBody();
        $vaccine = $vaccineController->find($data['vaccine']);
        $type->vaccines()->save($vaccine);

        return redirect()->route('type-add-vaccine-form' , [
            'vaccineCode' => $vaccine['code'],
            'typeCode' => $type['code'],
            ])->with('status', " {$vaccine->name} was added to {$type->name}.");
        ;
        } catch(QueryException $excp) {
            return redirect()->back()->withInput()->withErrors([
                'error' => $excp->errorInfo[2],
            ]);
        }
    }
}
