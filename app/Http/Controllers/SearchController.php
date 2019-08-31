<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB as DB;
use App\Models\Locations as Locations;
use App\Models\Bookings as Bookings;
use App\Models\Properties as Properties;



class SearchController extends BaseController
{
    
	public $varViews = [];
	
	public function index(Request $request)
	{

  		 $data = [];		
	     $this->varViews['error'] = false;
	     $this->varViews['post'] = false;
		 if ($request->isMethod('post')) {
	
    	    $this->varViews['post'] = true;
				
			$data = $request->input();
			if(!isset($data['page']))
				$data['page'] = 1;
			else
				$data['page'] = $data['page']*1;
			
		
			if(!$data['destination'])
			{
				$this->varViews['error'] = true;
				$this->varViews['errorText'] = 'No data: destination';
			}			
			else if(!$data['date_from'])
			{
				$this->varViews['error'] = true;
				$this->varViews['errorText'] = 'No data: Check in';
				
			}			
			else if(!$data['date_to'])
			{
				$this->varViews['error'] = true;
				$this->varViews['errorText'] = 'No data: Check out';
				
			}			
			else if(strtotime($data['date_to'])-strtotime($data['date_from'])<0) {
				$this->varViews['error'] = true;
				$this->varViews['errorText'] = 'Date as check out must be grater than check in';
			}	
			
			

			if(!$this->varViews['error']){
		
				$q = DB::connection()->getPdo()->quote('%'.$data['destination'].'%');
 
			    $product = Properties::leftJoin('locations', '_fk_location', 'locations.__pk')
							->selectRaw('*, (SELECT count(*) FROM bookings WHERE _fk_property = properties.__pk AND start_date >= "'
              											.date('Y-m-d', strtotime($data['date_to'])) 
              											.'" and end_date <= "'
              											.date('Y-m-d', strtotime($data['date_to']))
														.'") as number_bookings')
			    			->whereRaw('(property_name LIKE ' . $q . ' or location_name LIKE ' . $q . ')' );
							
				if(isset($data['available']) && $data['available']=='on')
				{
					$product = $product->whereRaw('(SELECT count(*) FROM bookings WHERE _fk_property = properties.__pk AND start_date >= "'
              											.date('Y-m-d', strtotime($data['date_to'])) 
              											.'" and end_date <= "'
              											.date('Y-m-d', strtotime($data['date_to']))
														.'") = 0');			
					
				}
				if(isset($data['beach']) && $data['beach']=='on')
				{
					$product = $product->where('near_beach', '=', '1');			
					
				}
				if(isset($data['pet']) && $data['pet']=='on')
				{
					$product = $product->where('accepts_pets', '=', '0');			
					
				}

				if(isset($data['sleeps']) && $data['sleeps']=='on')
				{
					$product = $product->where('sleeps', '>', $data['sleeps']);			
					
				}
				if(isset($data['beds']) && $data['beds']=='on')
				{
					$product = $product->where('sleeps', '>', $data['beds']);			
					
				}
				
				//die($product->toSql());
				$product = $product->paginate(5, ['*'],'page',$data['page']);
				
				$this->varViews['result'] = $product;
		
								
			}			
			
			
			

		 }	
			
		$this->varViews['data'] = $data;
		return view('search', $this->varViews);
		
		
				
				
	}
	
	
}