<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;
class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        $announcements = Announcement::all();
        return view('admin.Announcement')->with('announcements',$announcements);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info($request);
        
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'display' => 'required',

            
        ],
        [
            
        ]);

        if($validator->passes()){

            $announcement = new Announcement;
            $announcement->title = $request->title;
            $announcement->description = $request->description;
            $announcement->display = $request->display;
            $announcement->save();
            Log::info("sod");


            return response()->json($announcement);
        }
        return response()->json(['error'=>$validator->errors()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Announcement $announcement)
    {
        Log::info($request);

        

        $validator = Validator::make($request->all(), [
            'edit_title' => 'required',
            'edit_description' => 'required',
            'edit_display' => 'required',
           
        ],
        [
            // 'product_price.min' => 'must be not negative or zero',
            // 'product_stock.min' => 'must be not negative or zero',
        ]);

        if($validator->passes()){
            
            $announcement = Announcement::find($request->id);
            Log::info($announcement);
            $announcement->title = $request->edit_title;
            $announcement->description = $request->edit_description;
            $announcement->display = $request->edit_display;
            $announcement->save();
           
        }
       

        return response()->json(['error'=>$validator->errors()]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Announcement $announcement)
    {
        $announcement = Announcement::find($id);
        $announcement->delete();
    }

     

    public function getAnnouncementInfo($id){

        Log::info($id);
        $announcement = Announcement::find($id);

        return response()->json($announcement);
    }
}
