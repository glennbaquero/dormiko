<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class FetchController extends Controller
{
    protected $user = null;

    protected $request = null;
    protected $class = '';

    protected $sort = 'id';
    protected $order = 'asc';

    protected $search = '';

    protected $total = 10;


    /**
     * Set the object to be used by the controller
     *
     * @var $class Class name of the object
     */
    abstract protected function setObjectClass();

    /**
     * Custom filtering of query
     * 
     * @param Illuminate\Support\Facades\DB $query
     * @return Illuminate\Support\Facades\DB $query
     */
    abstract protected function filterQuery($query);  

    /**
     * Build an array w/ all the needed fields
     *
     * @return array
     */
    abstract protected function formatData($items);  


    /**
     * Set all needed variables
     */
    protected function init($request)
    {
        /* Get default variable */
        $this->user = \Auth::user();
        $this->request = $request;


        /* Set object class */
        $this->setObjectClass();   
    }

    /**
     * Fetch the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fetch(Request $request)
    {
        /* Initialize needed vars */
        $this->init($request);


        /* Set default parameters */
        $this->setParameters($request);


        /* Set storage vars */
        $items = [];
        $pagination = [];

        /* Perform needed queries */
        $collections = $this->fetchQuery($request);


        /* Check if pagination is disabled  */
        if($request->has('nopagination') || $request->has('forselect') || $request->has('nojson')) {

            $items = $this->formatData($collections);

        } else {

            $items = $this->formatData($collections->items());
            $pagination = $this->getPagination(json_decode($collections->toJson()));
        }


        return response()->json([
            'items' => $items,
            'pagination' => $pagination
        ]);
    }

    /**
     * Create query
     * 
     * @return Illuminate\Pagination\Paginator
     */
    private function fetchQuery()
    {
        /* Fetch active or archived objects */
        $query = $this->request->has('archive') ? $this->class::onlyTrashed() : $this->class;


        /* Run filters */
        $query = $this->filterQuery($query);

        /* Run sorting */
        $query = $query->orderBy($this->sort, $this->order);


        /* when table is not to be paginated */
        if($this->request->has('nopagination') || $this->request->has('forselect')) {
            return $query->get();
        }

        return $query->paginate($this->total);
    }

    /**
     * Set general parameters
     */
    protected function setParameters()
    {
        /* Set column to sort  */
        if($this->request->has('sort'))
            $this->sort = $this->request->sort;

        /* Set column order  */
        if($this->request->has('order'))
            $this->order = $this->request->order;        

        /* Set total no. of item per page  */
        if($this->request->has('total'))
            $this->total = $this->request->total;

        /* Set search string  */
        if($this->request->has('search'))
            $this->search = $this->request->search;     
    }

    /**
     * Rename pagination keys
     * 
     * @param json
     * @return array
     */
    private function getPagination($json)
    {
        return array(
            'prevpage' => $json->prev_page_url,
            'nextpage' => $json->next_page_url,
            'current' => $json->current_page,
            'last' => $json->last_page,
            'next' => $json->path,
            'total' => $json->total,
            'from' => $json->from,
            'to' => $json->to,
            'per_page' => $json->per_page
        );
    }    
}
