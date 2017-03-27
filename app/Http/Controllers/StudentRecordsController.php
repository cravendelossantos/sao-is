<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Http\Requests;
use App\Student;
use DB;
use Input;
use Yajra\Datatables\Facades\Datatables;
use Validator;


class StudentRecordsController extends Controller
{
	public function importExport()
	{
		return view('student_records');
	}
	public function downloadExcel($type)
	{
		$data = Student::get()->toArray();

		if (empty($data))
		{
			 $errors  = ['Data is empty'];
           	return redirect('/student-records')->with('errors', $errors); 
		}
		else
		{
		return Excel::create('student_records', function($excel) use ($data) {
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
					$insert[] = ['student_no' => $value->student_no, 
									'first_name' => $value->first_name,
									'last_name' =>$value->last_name,
									'course' => $value->course,
									'year_level' =>$value->year_level,
									'student_contact_no' =>$value->contact_no,
									'date_created' =>$value->date_created
									];
				}
				if(!empty($insert)){
					DB::table('students')->insert($insert);
							$messages = "File successfully imported!";
			/*		dd('Import Successful!');	*/
					return redirect('/student-records')->with('success', $messages); 
				}

			}
		}
		return back();
		 } 


		catch (\Illuminate\Database\QueryException $e){
                //dd("Please Check your file");
		 		//dd($e);
            $errors  = ['Please check the import file data','Import file data must match with student records table columns'];
           	return redirect('/student-records')->with('errors', $errors); 
           
                }


          catch (PDOException $e) {

            $errors  = ['Please check the import file data','Import file data must match with student records table columns'];
           	return redirect('/student-records')->with('errors', $errors); 
            	//dd($e);

            }    
           }       
           else {
           	  $errors  = ['Please check your file','Only files with the following extensions are allowed: .csv .xls .xlsx'];
           	return redirect('/student-records')->with('errors', $errors); 
           

           } 
	}

	public function getStudentRecordsTable()
	{	
		$students = Student::all();

		return Datatables::of($students)
		->addColumn('action', function ($students) {
                return '<a href="#edit-'.$students->student_no.'" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';})
		->make(true);
	}

}
