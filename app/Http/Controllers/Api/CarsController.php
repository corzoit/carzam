<?php

namespace App\Http\Controllers\Api;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;

use Cache;
use App\Car;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CarsController extends Controller
{
    public function search(){

        $input = Request::input();
        $k = isset($input['k']) ? $input['k']:''; //default keyword to empty, will return no results
        $cache_key = str_replace(' ', '-', trim($k));

        $output =  []; //results, empty by default
        $response =  ['meta' => ['count' => count($output), 'k' => $cache_key],
                        'output' => $output]; //response structure
        
        $c_output = Cache::get($cache_key);

        if($k != '' && is_null($c_output)) //search results if a keyword was passed and if results are not in cache
        {
            
            $keywords_arr = explode(' ', trim($k)); //separate each word
            $keywords_arr = array_map('trim', $keywords_arr);       
            
            $filtered_cars = null;
            foreach ($keywords_arr as $key => $keyword) {
                if(strlen($keyword) > 0){
                    if(is_null($filtered_cars)){
                        $filtered_cars = Car::where(function($query) use ($keyword) {
                            $query->where('make', 'LIKE', $keyword.'%')
                                  ->orWhere('model', 'LIKE', $keyword.'%')
                                  ->orWhere('badge', 'LIKE', $keyword.'%')
                                  ->orWhere('variant', 'LIKE', $keyword.'%')
                                  ->orWhere('color', 'LIKE', $keyword.'%');
                        });
                    }
                    else{
                        $filtered_cars->where(function($query) use ($keyword) {
                            $query->where('make', 'LIKE', $keyword.'%')
                                  ->orWhere('model', 'LIKE', $keyword.'%')
                                  ->orWhere('badge', 'LIKE', $keyword.'%')
                                  ->orWhere('variant', 'LIKE', $keyword.'%')
                                  ->orWhere('color', 'LIKE', $keyword.'%');
                        });
                    }
                }
            }

            if(!is_null($filtered_cars)){
                $output = $filtered_cars->get();
            }

            //to improve results I am applying a weighted sort      
            if(count($output)){ //apply if results were found
                $w_output = [];
                foreach ($output as $key1 => $car) {
                    $weight = 0;

                    //giving a higher rank/weight if a exact match is found (case insensitive)
                    foreach ($keywords_arr as $key2 => $keyword) {
                        if(strcasecmp($car->make, $keyword) === 0){
                            $weight++;
                        }
                        if(strcasecmp($car->model, $keyword) === 0){
                            $weight++;
                        }
                        if(strcasecmp($car->badge, $keyword) === 0){
                            $weight++;
                        }
                        if(strcasecmp($car->variant, $keyword) === 0){
                            $weight++;
                        }
                        if(strcasecmp($car->color, $keyword) === 0){
                            $weight++;
                        }
                    }
                    
                    array_push($w_output, 
                        array_merge($car->toArray(), ['weight' => $weight]));
                }

                uasort($w_output, function($a, $b) {
                    return($a['weight'] < $b['weight']);
                });

                //just making array more suitable for json output
                $output = array_values($w_output);
            }

            Cache::put($cache_key, $output, 5); //cache for 5 mins
        }
        else if($k != '') //fetch from cache if a keyword was passed
        {
            $output = Cache::get($cache_key); //fetch from cache
        }

        $response['meta']['count'] = count($output);
        $response['output'] = $output;

        return $response;
    }
}
