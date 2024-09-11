<?php

namespace App\Http\Controllers;

use App\Models\Reel;
use Illuminate\Http\Request;

class ReelController extends Controller
{
    public function upload(Request $request) {
        $request->validate([
            'title' => 'required|string',
            'video' => 'required|file|mimes:mp4,mov,avi|max:40980',
        ]);
        $videoPath = $request->file('video')->store('reels', 'public');
        $reel = new Reel();
        $reel->title = $request->title;
        $reel->filepath = $videoPath;
        $reel->save();
        return response()->json([
            'success'=>true,
            'message'=>'Video Uploaded Successfully',
            'data'=>$reel
        ]);
    }
    
    public function all(Request $request) {
        $reels = Reel::orderBy('id','desc')->paginate(20);
        return $reels;
    }

    public function single($id) {
        $reel = Reel::findOrFail($id);
        return $reel;
    }
}
