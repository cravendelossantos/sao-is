<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Excel;
use App\Activity;
use App\Student;
use DB;
use Input;
use Yajra\Datatables\Facades\Datatables;
use Validator;



class ActivityRecordsController extends Controller
{
	public function importExport()
	{
		return view('activity_records');
	}
	public function downloadExcel($type)
	{
		$data = Activity::get()->toArray();
		if (empty($data))
		{
			$errors  = ['Data is empty'];
			return redirect('/activity-records')->with('errors', $errors); 
		}
		else
		{
			return Excel::create('activity_records', function($excel) use ($data) {
				$excel->sheet('mySheet', function($sheet) use ($data)
				{
					$sheet->fromArray($data);
				});
			})->download($type);
		}
	}
	public function importExcel(Request $request)
	{ 	

		$mimes = array('application/vnd.ms-excel', 
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 
			'text/csv');
		$import_file = $request->file('import_file');
		if(in_array($_FILES['import_file']['type'],$mimes)){
			
			try {
				
				if($request->hasFile('import_file')){
					$path = $request->file('import_file')->getRealPath();

					$data = Excel::load($path, function($reader) {
					})->get();
					if(!empty($data) && $data->count()){
						foreach ($data as $key => $value) {
							$insert[] = ['organization' => $value->organization,
							'activity' => $value->activity,
							'date' => $value->date,
							'status' => $value->status,
							'created_at' => $value->created_at,
							'updated_at' => $value->updated_ats,
							];
						}
						if(!empty($insert)){
							DB::table('activities')->insert($insert);
							$messages = "File successfully imported!";
							/*		dd('Import Successful!');	*/
							return redirect('/activity-records')->with('success', $messages); 
						}

					}
				}
				return back();
			} 


			catch (\Illuminate\Database\QueryException $e){
                //dd("Please Check your file");
		 		//dd($e);
				$errors  = ['Please check the import file data','Import file data must match with activities table columns'];
				return redirect('/activity-records')->with('errors', $errors); 
				
			}


			catch (PDOException $e) {

				$errors  = ['Please check the import file data','Import file data must match with activities table columns'];
				return redirect('/activity-records')->with('errors', $errors); 
            	//dd($e);

			}    
		}       
		else {
			$errors  = ['Please check your file','Only files with the following extensions are allowed: .csv .xls .xlsx'];
			return redirect('/violation-records')->with('errors', $errors); 
			

		} 
	}

}
