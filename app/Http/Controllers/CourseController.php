<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;
use Validator;
use App\Http\Resources\CourseResource;
class CourseController extends Controller
{



    public function index(): JsonResponse {
        $courses = Course::select('courses.*', 'departments.departmentName')
        ->join('departments', 'courses.departmentId', '=', 'departments.id')
        ->orderBy('courses.id', 'asc')
        ->get();

        $response = [
            'success' => true,
            'data' => CourseResource::collection($courses),
            'message' => 'Course retrieved successfully.',
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request): JsonResponse {
        $input = $request->all();
        $validator = Validator::make($input, [
            'courseName' => 'required',
            'departmentId' => 'required'
        ]);


        if($validator->fails()) {
            $response = [
                'success' => false,
                'message' => 'Validation Error.'
            ];
    
            $response['data'] = $errorMessages;
            return response()->json($response, 400);
        }

        $course = Course::create($input);

        $response = [
            'success' => true,
            'data' => new CourseResource($course),
            'message' => 'Course created successfully.',
        ];

        return response()->json($response, 200);

    }

    public function show($id): JsonResponse {
        $course = Course::find($id);
        if(is_null($course)) {
            return $this -> sendError('Course not found.');
        }

        $response = [
            'success' => true,
            'data' => new CourseResource($course),
            'message' => 'Course retrieved successfully.',
        ];

        return response()->json($response, 200);
    }

    public function update(Request $request, Course $course) {
        $input = $request->all();
        $validator = Validator::make($input, [
            'courseName' => 'required',
            'departmentId' => 'required'
        ]);

        if($validator->fails()) {
            $response = [
                'success' => false,
                'message' => 'Validation Error.'
            ];
    
            $response['data'] = $errorMessages;
            return response()->json($response, 400);
        }

        $course->courseName = $input['courseName'];
        $course->departmentId = $input['departmentId'];
        $course->save();

        $response = [
            'success' => true,
            'data' => new CourseResource($course),
            'message' => 'Course updated successfully.',
        ];

        return response()->json($response, 200);
    }

    public function destroy(Course $course) {
        $course -> delete();
        $response = [
            'success' => true,
            'data' => [],
            'message' => 'Course deleted successfully.',
        ];

        return response()->json($response, 200);
    }

    // public function getCourses() {
    //     $courses = Course::select('courses.*', 'departments.departmentName')
    //         ->join('departments', 'courses.departmentId', '=', 'departments.id')
    //         ->orderBy('courses.id', 'asc')
    //         ->get();
    
    //     return response()->json($courses);
    // }

    // public function addCourse(Request $request) {
    //     $data = $request->validate([
    //         'courseName' => 'required',
    //         'departmentId' => 'required'
    //     ]);

    //     $newCourse = Course::create($data);

    //     return response()->json($newCourse);
    // }

    // public function updateCourse(Request $request, $id) {
    //     $data = $request->validate([
    //         'courseName' => 'required',
    //         'departmentId' => 'required'
    //     ]);
    
    //     $updateCourse = Course::where('id', $id)->update($data);
    
    //     return response()->json($updateCourse);
    // }

    // public function deleteCourse ($id) {
    //     $course = Course::find($id);

    //     if($course) {
    //         $course->delete();
    //         return response()->json(['status' => 404, 'message' => 'Course deleted successfully'],200);
    //     } else {
    //         return response()->json(['status' => 404, 'message' => 'No such data found'],200);
    //     }
    // }
}
