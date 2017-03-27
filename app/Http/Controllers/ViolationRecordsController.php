<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Http\Requests;
use App\Violation;
use DB;
use Input;
use Yajra\Datatables\Facades\Datatables;
use Validator;
use Form;


class ViolationRecordsController extends Controller
{
	public function importExport()
	{
		return view('violation_list');
	}
	public function downloadExcel($type)
	{
		$data = Violation::get()->toArray();
		if (empty($data))
		{
			 $errors  = ['Data is empty'];
           	return redirect('/violation-list')->with('errors', $errors); 
		}
		else
{
		return Excel::create('violation_list', function($excel) use ($data) {
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
					$insert[] = ['name' => $value->name,
								 'description' => $value->description,
								 'offense_level' => $value->offense_level,
								 'first_offense_sanction' => $value->first_offense_sanction,
								 'second_offense_sanction' => $value->second_offense_sanction,
								 'third_offense_sanction' => $value->third_offense_sanction,
									];
				}
				if(!empty($insert)){
					DB::table('violations')->insert($insert);
					$messages = "File successfully imported!";
			/*		dd('Import Successful!');	*/
					return redirect('/violation-list')->with('success', $messages); 
				}

			}
		}
		return back();
		 } 


		 catch (\Illuminate\Database\QueryException $e){
                //dd("Please Check your file");
		 		//dd($e);
            $errors  = ['Please check the import file data','Import file data must match with violaton records table columns'];
           	return redirect('/violation-list')->with('errors', $errors); 
           
                }


          catch (PDOException $e) {

            $errors  = ['Please check the import file data','Import file data must match with violaton records table columns'];
           	return redirect('/violation-list')->with('errors', $errors); 
            	//dd($e);

            }    
           }       
           else {
           	  $errors  = ['Please check your file','Only files with the following extensions are allowed: .csv .xls .xlsx'];
           	return redirect('/violation-list')->with('errors', $errors); 
           

           } 
	}

	public function truncateViolationRecords()
	{	
		$data = Violation::all();

		if ($data->count() == 0){
			   $errors  = ['Table is empty'];

		return response()->json(['success'=> false, 'errors' => $errors]);
		}

		else {
			Violation::truncate();
			return response()->json(array('success' => true ));
		
		}
	}


	public function getViolationRecordsTable()
	{
		return Datatables::eloquent(Violation::query())->make(true);
	}

}