<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;
use Validator;
use App\Http\Resources\DepartmentResource;
class DepartmentController extends Controller
{
    //

    public function index(): JsonResponse {
        $departments = Department::all();
        $response = [
            'success' => true,
            'data' => DepartmentResource::collection($departments),
            'message' => 'Departments retrieved successfully.',
        ];

        return response()->json($response, 200);
        
        // return $this->sendResponse(DepartmentResources::collection($departments), 'Departments retrieved successfully.');
    }


    public function store(Request $request) : JsonResponse {
        $input = $request->all();
        $validator = Validator::make($input,[
            'departmentName' => 'required'
        ]);

        if($validator->fails()){
            $response = [
                'success' => false,
                'message' => 'Validation Error.'
            ];
    
            $response['data'] = $errorMessages;
            return response()->json($response, 400);
        }

        $department = Department::create($input);


        $response = [
            'success' => true,
            'data' => new DepartmentResource($department),
            'message' => 'Department created successfully.',
        ];

        return response()->json($response, 200);

        // return sendResponse(new DepartmentResource($department), 'Department created successfully.');
    }

    public function show($id) : JsonResponse {
        $department = Department::find($id);
        if(is_null($department)) {
            $response = [
                'success' => false,
                'message' => 'Validation Error.'
            ];
    
            $response['data'] = $errorMessages;
            return response()->json($response, 400);
        }

        $response = [
            'success' => true,
            'data' => new DepartmentResource($department),
            'message' => 'Department retrieved successfully.',
        ];

        return response()->json($response, 200);

        // return $this -> sendResponse(new DepartmentResource($department), 'Department retrieved successfully.');
    }


    public function update(Request $request, Department $department) :JsonResponse {
        $input = $request->all();
        $validator = Validator::make($input, [
            'departmentName' => 'required'
        ]);

        if($validator->fails()) {
            $response = [
                'success' => false,
                'message' => 'Validation Error.'
            ];
    
            $response['data'] = $errorMessages;
            return response()->json($response, 400);
        }

        $department->departmentName = $input['departmentName'];
        $department->save();

        $response = [
            'success' => true,
            'data' => new DepartmentResource($department),
            'message' => 'Department updated successfully.',
        ];

        return response()->json($response, 200);
        // return $this->sendResponse(new DepartmentResource($department), 'Department updated successfully');
    }


    public function destroy(Department $department) {
        $department -> delete();
        $response = [
            'success' => true,
            'data' => [],
            'message' => 'Department deleted successfully.',
        ];

        return response()->json($response, 200);
        // return $this->sendResponse([], 'Department deleted successfully');
    }

    

    // public function getData () {
    //     $dep = DB::table('departments')
    //     ->orderBy('id', 'asc')
    //     ->get();
    //     return response() -> json($dep);
    // }

    // public function createDepartment() {
    //     return view('departments.create');
    // }

    // public function storeDepartment(Request $request) {
    //     $data = $request->validate([
    //         'departmentName'=>'required'
    //     ]);

    //     $newDepartment = Department::create($data);

    //     return response()->json($newDepartment);
    // }


    // public function updateDepartment(Request $request, $id) {
    //     $data = $request->validate([
    //         'departmentName' => 'required'
    //     ]);
    
    //     $updateDepartment = Department::where('id', $id)->update($data);
    
    //     return response()->json($updateDepartment);
    // }

    // public function deleteDepartment ($id) {
    //     // dd($id);
    //     // $deleteDepartment = Department::where('id', $id)->delete();

    //     // return response()->json($deleteDepartment);
    //     $department = Department::find($id);

    //     if($department) {
    //         $department->delete();
    //         return response()->json(['status' => 404, 'message' => 'Department deleted successfully'],200);
    //     } else {
    //         return response()->json(['status' => 404, 'message' => 'No such data found'],200);
    //     }
    // }
}
