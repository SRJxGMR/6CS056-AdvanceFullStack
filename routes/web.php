<?php

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

Route::get('/', function () {
    return view('welcome');
});


// List Students[cite: 18]
Route::get('/students', function () {
    return view('students.list', [
        'students' => Student::all(),
    ]);
})->name('students.index');

// Create Student Form[cite: 15]
Route::get('/students/create', function () {
    return view('students.create');
});

// Store Student[cite: 19]
Route::post('/students', function (Request $request) {
    $validated = $request->validate([
        'name'          => 'required|string|max:255',
        'email'         => 'required|email|max:255|unique:students,email',
        'phone'         => 'required|string|max:20',
        'address'       => 'nullable|string|max:500',
        'date_of_birth' => 'nullable|date',
    ]);

    $student = Student::create($validated);

    return redirect()->route('students.index')
        ->with('success', "Student {$student->name} created successfully!");
});

// View Student Details[cite: 22]
Route::get('/students/{id}', function ($id) {
    return view('students.detail', [
        'student' => Student::findOrFail($id),
    ]);
});

// Edit Student Form[cite: 24]
Route::get('/students/{id}/edit', function ($id) {
    return view('students.edit', [
        'student' => Student::findOrFail($id),
    ]);
});

// Update Student[cite: 24]
Route::put('/students/{id}', function (Request $request, $id) {
    $student = Student::findOrFail($id);

    $validated = $request->validate([
        'name'          => 'required|string|max:255',
        'email'         => ['required', 'email', 'max:255', Rule::unique('students')->ignore($student->id)],
        'phone'         => 'required|string|max:20',
        'address'       => 'nullable|string',
        'date_of_birth' => 'nullable|date',
    ]);

    $student->update($validated);

    return redirect('/students/' . $student->id)
        ->with('success', 'Student updated successfully!');
});

// Delete Student[cite: 28]
Route::delete('/students/{id}', function ($id) {
    $student = Student::findOrFail($id);
    $student->delete();

    return redirect('/students')
        ->with('success', 'Student deleted successfully!');
});

/*
|--------------------------------------------------------------------------
| Course Routes
|--------------------------------------------------------------------------
*/

// List Courses[cite: 4]
Route::get('/courses', function () {
    return view('course.list', [
        'courses' => Course::all(),
    ]);
})->name('courses.index');

// Create Course Form[cite: 4]
Route::get('/courses/create', function () {
    return view('course.create');
});

// Store Course[cite: 4]
Route::post('/courses', function (Request $request) {
    $validated = $request->validate([
        'name'        => 'required|string|max:255',
        'description' => 'nullable|string',
        'duration'    => 'required|integer|min:1',
        'fee'         => 'required|numeric|min:0',
        'difficulty'  => 'required|in:Easy,Medium,Hard',
    ]);

    $validated['is_active'] = $request->has('is_active');

    $course = Course::create($validated);

    return redirect()->route('courses.index')
        ->with('success', "Course {$course->name} created successfully!");
});

// View Course Details[cite: 4]
Route::get('/courses/{id}', function ($id) {
    return view('course.detail', [
        'course' => Course::findOrFail($id),
    ]);
});

// Edit Course Form[cite: 4]
Route::get('/courses/{id}/edit', function ($id) {
    return view('course.edit', [
        'course' => Course::findOrFail($id),
    ]);
});

// Update Course[cite: 4]
Route::put('/courses/{id}', function (Request $request, $id) {
    $course = Course::findOrFail($id);

    $validated = $request->validate([
        'name'        => 'required|string|max:255',
        'description' => 'nullable|string',
        'duration'    => 'required|integer|min:1',
        'fee'         => 'required|numeric|min:0',
        'difficulty'  => 'required|in:Easy,Medium,Hard',
    ]);

    $validated['is_active'] = $request->has('is_active');

    $course->update($validated);

    return redirect('/courses/' . $course->id)
        ->with('success', 'Course updated successfully!');
});

// Delete Course[cite: 4]
Route::delete('/courses/{id}', function ($id) {
    $course = Course::findOrFail($id);
    $course->delete();

    return redirect('/courses')
        ->with('success', 'Course deleted successfully!');
});