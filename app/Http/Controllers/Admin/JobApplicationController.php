<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Http\Resources\JobApplicationResource;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index()
    {
        $applications = JobApplication::orderBy('created_at', 'desc')->get();
        return JobApplicationResource::collection($applications);
    }

    public function review(JobApplication $jobApplication)
    {
        $jobApplication->update(['is_reviewed' => true]);
        return new JobApplicationResource($jobApplication);
    }

    public function destroy(JobApplication $jobApplication)
    {
        $jobApplication->delete();
        return response()->json(['message' => 'Application deleted']);
    }
}
