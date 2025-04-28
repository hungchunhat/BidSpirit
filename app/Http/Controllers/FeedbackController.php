<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(){
        $validate = request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'content' => 'required'
        ]);
        Feedback::create($validate);
        return 'done';
    }
    public function destroy(){
        request()->validate([
            'id' => 'required|integer|exists:feedbacks,id'
        ]);
        Feedback::destroy(request('id'));
        return 'done';
    }
}
