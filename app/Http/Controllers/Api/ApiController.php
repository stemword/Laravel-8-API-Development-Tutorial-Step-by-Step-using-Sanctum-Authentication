<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class ApiController extends Controller
{
    //Create Student
    public function CreateStudent(Request $request) {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:students",
            "phone_no" => "required",
            "gender" => "required",
            "age" => "required"
        ]);
        // create data
        $student = new Student();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone_no = $request->phone_no;
        $student->gender = $request->gender;
        $student->age = $request->age;

        $student->save();

        // send response
        return response()->json([
            "status" => 1,
            "message" => "Student created sucessfully"
        ]);
    }

    //List Students
    public function listStudents() {
        $students = Student::get();

        return response()->json([
            "status" => 1,
            "message" => "Listing Students",
            "data" => $students
        ], 200);
    }

    // Single student API
    public function getSingleStudent($id) {
        if (Student::where("id", $id)->exists()) {

            $student_detail = Student::where("id", $id)->first();

            return response()->json([
                "status" => 1,
                "message" => "Student found",
                "data" => $student_detail
            ]);
        } else {

            return response()->json([
                "status" => 0,
                "message" => "Student not found"
            ], 404);
        }
    }

    // Update Student
    public function updateStudent(Request $request , $id) {
        if (Student::where("id", $id)->exists()) {

            $student = Student::find($id);
            
            $student->name = !empty($request->name) ? $request->name : $student->name;
            $student->email = !empty($request->email) ? $request->email : $student->email;
            $student->phone_no = !empty($request->phone_no) ? $request->phone_no : $student->phone_no;
            $student->gender = !empty($request->gender) ? $request->gender : $student->gender;
            $student->age = !empty($request->age) ? $request->age : $student->age;

            $student->save();

            return response()->json([
                "status" => 1,
                "message" => "Student updated successfully"
            ]);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Student not found"
            ], 404);
        }
    }

    // Delte Student
    public function deleteStudent($id) {
        if (Student::where("id", $id)->exists()) {

            $student = Student::find($id);

            $student->delete();

            return response()->json([
                "status" => 1,
                "message" => "Student deleted successfully"
            ]);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Student not found"
            ], 404);
        }
    }
}
