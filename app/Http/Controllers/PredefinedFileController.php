<?php

namespace App\Http\Controllers;

use App\Traits\FileTrait;
use Illuminate\Http\Request;
use App\Models\PredefinedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PredefinedFileController extends Controller
{
    use FileTrait;
    private $img_ext = ['jpg', 'png', 'jpge', 'gif', 'JPG', 'PNG', 'JPGE', 'GIF'];
    private $video_ext = ['mp4', 'avi', 'mpge', 'MP4', 'AVI', 'MPGE'];
    private $document_ext = ['doc', 'docx', 'pdf', 'DOC', 'DOCX', 'PDF'];

    private $path = "default_files";


    private function getType($ext)
    {
        if (in_array($ext, $this->img_ext)) {
            return "image";
        }

        if (in_array($ext, $this->video_ext)) {
            return "video";
        }

        if (in_array($ext, $this->document_ext)) {
            return "document";
        }
    }

    private function allExtension()
    {
        return array_merge(
            $this->img_ext,
            $this->video_ext,
            $this->document_ext
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $files = PredefinedFile::orderBy('created_at', 'desc')->get();
        return view('predefined.create', compact('files'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // // $this->deleteFile(4);
        // $this->deleteAllFiles('App\Models\ToDo\Task', 27);
        dd($this->uploadFiles($request['files'], 'todo/task/files', 'App\Models\ToDo\Task', 27));
        // // dd($request);

        $all_ext = implode(',', $this->allExtension());
        $rules = [
            'files.*' => 'required|mimes:' . $all_ext,
            'modulo' => 'required|not_in:Elegir',
            'use' => 'required|not_in:Elegir'
        ];

        $messages = [
            'mimes' > 'El tipo de archivo no es valido',
            'required' => 'El campo es requerido.',
            'not_in' => 'Seleccione una opción valida.',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();

        foreach ($request['files'] as $file) {
            $uploadFiel = new PredefinedFile();
            $name = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $type = $this->getType($ext);
            $newFile = Storage::putFileAs($this->path, $file, $name);
            if ($newFile) {
                $uploadFiel::create([
                    'url_file' => $newFile,
                    'name' => $name,
                    'type' => $type,
                    'module' => $request['modulo'],
                    'use' => $request['use']
                ]);
            } else {
                return back()->with('error', 'Ups! Hubo un error al subir el archivo');
            }
        }
        return back()->with('success', 'El archvo se subio exitosamente!!');
    }

    private function uploadFile($file)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
