<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;


class SearchableController extends Controller
{
    function getQuery()
    {
        return null;
    }

    function filterByTerm($query, $term)
    {

        if(!empty($term)) {
            foreach(preg_split('/\s+/', trim($term)) as $word) {
                $query->where(function($innerQuery) use ($word) {
                    return $innerQuery
                        ->where('code', 'LIKE', "%{$word}%")
                        ->orWhere('name', 'LIKE', "%{$word}%");
                });
            }
        }
        return $query;
    }

    function prepareSearch($search)
    {
        $search['term'] = (empty($search['term']))? null : $search['term'];

        return $search;
    }

    function filterBySearch($query, $search)
    {

        return $this->filterByTerm($query, $search['term']);
    }

    function search($search)
    {
        $query = $this->getQuery();
        return $this->filterBySearch($query, $search);
    }

    function find($code)
    {
        return $this->getQuery()->where('code', $code)->firstOrFail();
    }



}
