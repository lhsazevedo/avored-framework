<?php
namespace AvoRed\Framework\Breadcrumb;

use Illuminate\Support\Collection;
use Callable;

class Builder
{

    /**
    * Breadcrumb Label
    *  @var \AvoRed\Framework\Breadcrumb\Breadcrumb
    */
    protected $breadcrumb;


    /**
    * Breadcrumb Label
    *  @var \Illuminate\Support\Collection
    */
    protected $collection;


    /**
    * Breadcrumb Builder Construct
    */
    public function __construct()
    {
        $this->collection = new Collection();
    }

    /**
    * Breadcrumb Make an Object
    *
    * @param string $name
    * @param Callable $callable
    * @return void
    */
    public function make($name, Callable  $callable) {

        $breadcrumb = new Breadcrumb($callable);
        $breadcrumb->route($name);

        $this->collection->put($name, $breadcrumb);
    }

    /**
    * Render BreakCrumb for the Route Name
    *
    * @param string $routeName
    * @return \Illuminate\Http\Response
    */
    public function render($routeName) {

        $breadcrumb = $this->collection->get($routeName);

        if(null === $breadcrumb) {
            return "";
        }
        return view('avored-framework::breadcrumb.index')->with('breadcrumb', $breadcrumb);
    }

    /**
    * Get Breadcrum to set the Parent
    *
    * @param string $key
    * @return \Illuminate\Http\Response
    */
    public function get($key) {
        return $this->collection->get($key);
    }
}
