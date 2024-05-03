<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;
use Validator;
use App\Http\Resources\EnrollmentResource;
class EnrollmentController extends Controller
{

    public function index() : JsonResponse {
        $enrollments = Enrollment::select('enrollments.*', 'firstName', 'lastName', 'address', 'DOB', 'courseName', 'departmentId')
        ->join('students', 'enrollments.studentId', '=', 'students.id')
        ->join('courses', 'enrollments.courseId', '=', 'courses.id')
        ->orderBy('enrollments.id', 'asc')
        ->get();

        $response = [
            'success' => true,
            'data' => EnrollmentResource::collection($enrollments),
            'message' => 'Enrollment retrieved successfully.',
        ];
        return response()->json($response, 200);
    }

    public function store(Request $request) : JsonResponse {
        $input = $request->all();
        $validator = Validator::make($input, [
            'studentId' => 'required',
            'courseId' =>'required',
            'enrollment_date' => 'required',
        ]);

        
        if($validator->fails()) {
            $response = [
                'success' => false,
                'message' => 'Validation Error.'
            ];
    
            $response['data'] = $errorMessages;
            return response()->json($response, 400);
        }

        $enrollment = Enrollment::create($input);

        $response = [
            'success' => true,
            'data' => new EnrollmentResource($enrollment),
            'message' => 'Enrollment created successfully.',
        ];

        return response()->json($response, 200);
    }


    public function show($id) : JsonResponse {
        $enrollment = Enrollment::find($id);
        if(is_null($enrollment)) {
            return $this -> sendError('Enrollment not found.');
        }

        $response = [
            'success' => true,
            'data' => new EnrollmentResource($enrollment),
            'message' => 'Enrollment retrieved successfully.',
        ];

        return response()->json($response, 200);
    }

    public function update(Request $request, Enrollment $enrollment) : JsonResponse {
        $input = $request->all();
        $validator = Validator::make($input, [
            'studentId' => 'required',
            'courseId' =>'required',
            'enrollment_date' => 'required',
        ]);

        if($validator->fails()) {
            $response = [
                'success' => false,
                'message' => 'Validation Error.'
            ];
    
            $response['data'] = $errorMessages;
            return response()->json($response, 400);
        }

        $enrollment->studentId = $input['studentId'];
        $enrollment->courseId = $input['courseId'];
        $enrollment->enrollment_date = $input['enrollment_date'];
        $enrollment->save();

        $response = [
            'success' => true,
            'data' => new EnrollmentResource($enrollment),
            'message' => 'Enrollment updated successfully.',
        ];

        return response()->json($response, 200);
    }

    public function destroy(Enrollment $enrollment) {
        $enrollment -> delete();
        $response = [
            'success' => true,
            'data' => [],
            'message' => 'Enrollment deleted successfully.',
        ];

        return response()->json($response, 200);
    }

    // public function getEnrollment() {
    //     // $en = DB::table('enrollments')->get();
    //     // return response() -> json($en);

    //     $enrollments = Enrollment::select('enrollments.*', 'firstName', 'lastName', 'address', 'DOB', 'courseName', 'departmentId')
    //         ->join('students', 'enrollments.studentId', '=', 'students.id')
    //         ->join('courses', 'enrollments.courseId', '=', 'courses.id')
    //         ->orderBy('enrollments.id', 'asc')
    //         ->get();
    
    //     return response()->json($enrollments);

    // }


    // public function addEnrollment(Request $request) {
   
    //     $data = $request->validate([
    //         'studentId' => 'required',
    //         'courseId' =>'required',
    //         'enrollment_date' => 'required',
    //     ]);
    //     $newEnrollment = Enrollment::create($data);

    //     return response()->json($data);
      
    // }

    // public function updateEnrollment(Request $request, $id) {
    //     $data = $request->validate([
    //         'studentId' => 'required',
    //         'courseId' =>'required',
    //         'enrollment_date' => 'required',
    //     ]);
    
    //     $updateEnrollment = Enrollment::where('id', $id)->update($data);
    
    //     return response()->json($updateEnrollment);
    // }

    // public function deleteEnrollment ($id) {

    //     $enrollment = Enrollment::find($id);

    //     if($enrollment) {
    //         $enrollment->delete();
    //         return response()->json(['status' => 404, 'message' => 'Student deleted successfully'],200);
    //     } else {
    //         return response()->json(['status' => 404, 'message' => 'No such data found'],200);
    //     }
    // }
}
