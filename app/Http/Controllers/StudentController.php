<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;
use Validator;
use App\Http\Resources\StudentResource;
class StudentController extends Controller
{

    public function index() {
        $students = Student::all();

        $response = [
            'success' => true,
            'data' => StudentResource::collection($students),
            'message' => 'Students retrieved successfully.',
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request): JsonResponse {
        $input = $request->all();
        $validator = Validator::make($input, [
            'firstName' => 'required',
            'lastName' =>'required',
            'DOB' => 'required',
            'address' => 'required'
        ]);


        if($validator->fails()) {
            $response = [
                'success' => false,
                'message' => 'Validation Error.'
            ];
    
            $response['data'] = $errorMessages;
            return response()->json($response, 400);
        }

        $student = Student::create($input);

        $response = [
            'success' => true,
            'data' => new StudentResource($student),
            'message' => 'Student created successfully.',
        ];

        return response()->json($response, 200);

    }

    public function show($id) {
        $student = Student::find($id);
        if(is_null($student)) {
            return $this -> sendError('Student not found.');
        }

        $response = [
            'success' => true,
            'data' => new StudentResource($student),
            'message' => 'Student retrieved successfully.',
        ];

        return response()->json($response, 200);
    }

    public function update(Request $request, Student $student) {
        $input = $request->all();
        $validator = Validator::make($input, [
            'firstName' => 'required',
            'lastName' =>'required',
            'DOB' => 'required',
            'address' => 'required'
        ]);

        if($validator->fails()) {
            $response = [
                'success' => false,
                'message' => 'Validation Error.'
            ];
    
            $response['data'] = $errorMessages;
            return response()->json($response, 400);
        }

        $student->firstName = $input['firstName'];
        $student->lastName = $input['lastName'];
        $student->DOB = $input['DOB'];
        $student->address = $input['address'];
        $student->save();

        $response = [
            'success' => true,
            'data' => new StudentResource($student),
            'message' => 'Student updated successfully.',
        ];

        return response()->json($response, 200);
    }

    
    public function destroy(Student $student) {
        $student -> delete();
        $response = [
            'success' => true,
            'data' => [],
            'message' => 'Student deleted successfully.',
        ];

        return response()->json($response, 200);
    }

    // public function getStudent() {
    //     $stud = DB::table('students')
    //     ->orderBy('id', 'asc')
    //     ->get();
    //     return response() -> json($stud);
    // }


    // public function addStudent(Request $request) {
   
    //     $data = $request->validate([
    //         'firstName' => 'required',
    //         'lastName' =>'required',
    //         'DOB' => 'required',
    //         'address' => 'required'
    //     ]);
    //     $newStudent = Student::create($data);

    //     return response()->json($newStudent);
      
    // }

    // public function updateStudent(Request $request, $id) {
    //     $data = $request->validate([
    //         'firstName' => 'required',
    //         'lastName' =>'required',
    //         'DOB' => 'required',
    //         'address' => 'required'
    //     ]);
    
    //     $updateStudent = student::where('id', $id)->update($data);
    
    //     return response()->json($updateStudent);
    // }

    public function deleteStudent ($id) {

        $student = Student::find($id);

        if($student) {
            $student->delete();
            return response()->json(['status' => 404, 'message' => 'Student deleted successfully'],200);
        } else {
            return response()->json(['status' => 404, 'message' => 'No such data found'],200);
        }
    }
}
