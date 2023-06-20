<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:video-list|video-create|video-edit|video-delete', ['only' => ['index']]);
         $this->middleware('permission:video-create', ['only' => ['create','store']]);
         $this->middleware('permission:video-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:video-delete', ['only' => ['destroy']]);
         $this->middleware('auth')->except(['show']); // Excluir 'show' del middleware de autenticación


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::latest()->paginate(5);
        return view('videos.index',compact('videos'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('videos.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'detail' => 'required',
        'file' => 'required|file',
    ]);

    $file = $request->file('file');
    $format = $file->getClientOriginalExtension();
    $size = $file->getSize();
    $upload_by = auth()->user()->id; // Cambia esto según tu lógica para obtener el ID del usuario que realiza la carga

    $video = new Video();
    $video->name = $request->input('name');
    $video->detail = $request->input('detail');
    $video->format = $format;
    $video->size = $size;
    $video->upload_by = $upload_by;

    // Guarda el archivo en la carpeta de almacenamiento y obtén su ruta
    $filePath = $file->store('public/vid');

    $array = explode('public',$filePath);


    $video->file_path = 'storage'.$array[1];
    $video->save();

    return redirect()->route('videos.index')->with('success', 'Video created successfully.');
}

    
    /**
     * Display the specified resource.
     *
     * @param  \App\Video  $Video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        $usuario = User::find($video->upload_by);
        //@dd($usuario);

        return view('videos.show',compact('video','usuario'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        return view('videos.edit',compact('video'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
         request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
    
        $video->update($request->all());
    
        return redirect()->route('videos.index')
                        ->with('success','Video updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        $video->delete();
    
        return redirect()->route('videos.index')
                        ->with('success','Video deleted successfully');
    }
}