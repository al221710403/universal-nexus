<?php

namespace App\Traits;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

trait FileTrait
{

    // Extensiones admitidas
    private $img_ext = ['jpg', 'png', 'jpge', 'gif', 'JPG', 'PNG', 'JPGE', 'GIF'];
    private $video_ext = ['mp4', 'avi', 'mpge', 'MP4', 'AVI', 'MPGE'];
    private $document_ext = ['txt', 'doc', 'docx', 'pdf', 'TXT', 'DOC', 'DOCX', 'PDF'];

    private $path = "default_files";


    /**
     * title: Sube archivos
     * Descripción: Sube varios archivos a la vez
     * @access public
     * @param  $files|archivos $path|directorio $model|Modelo relacionado $id|ID de la instancia
     * @return true|false
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-15 22:25:06
     */
    public function uploadFiles($files, $path = null, $model, $id)
    {
        $directory = '';
        if ($path === null) {
            $directory = $this->path;
        }
        $directory = $path;

        // Valida si existe archivos en la variable $files
        if ($files) {
            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();

                // Valida si la extension es valida
                if ($this->isValid($ext)) {
                    $uploadFiel = new File();
                    $type = $this->getType($ext);
                    $newFile = Storage::putFileAs($directory, $file, $name);

                    if ($newFile) {
                        $uploadFiel::create([
                            'url_file' => $newFile,
                            'name' => $name,
                            'type' => $type,
                            'fileable_id' => $id,
                            'fileable_type' => $model
                        ]);
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * title: Sube un archivo
     * Descripción: Sube un archivo
     * @access public
     * @param  $file|archivo $path|directorio $model|Modelo relacionado $id|ID de la instancia
     * @return true|false
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-15 22:25:06
     */
    public function uploadFile($file, $path = null, $model, $id)
    {
        $directory = '';
        if ($path === null) {
            $directory = $this->path;
        }
        $directory = $path;

        // Valida si existe archvo en la variable $file
        if ($file) {
            // Valida si es un archivo
            if (is_file($file)) {
                $name = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();

                // Valida si la extension es valida
                if ($this->isValid($ext)) {
                    $uploadFiel = new File();
                    $type = $this->getType($ext);
                    $newFile = Storage::putFileAs($directory, $file, $name);

                    if ($newFile) {
                        $uploadFiel::create([
                            'url_file' => $newFile,
                            'name' => $name,
                            'type' => $type,
                            'fileable_id' => $id,
                            'fileable_type' => $model
                        ]);
                    }
                }
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    /**
     * title: Descarga archivo
     * Descripción: Descarga un unico archivo
     * @access public
     * @param  $path|la ruta del archivi $name|nombre del archivo
     * @return El archivo descargado
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-17 12:45:55
     */
    public function downloadFile($file)
    {
        return Storage::download($file['url_file'], $file['name']);
    }

    public function deleteFile($id)
    {
        $file = File::find($id);
        if ($file) {
            if (file_exists('storage/' .  $file->url_file)) {
                unlink('storage/' . $file->url_file); //si el archivo ya existe se borra
            }

            $file->delete();
        }
        return false;
    }

    public function deleteAllFiles($model, $id_model)
    {
        $files = File::where('fileable_type', $model)->where('fileable_id', $id_model)->get();

        if ($files->count() > 0) {
            foreach ($files as $file) {
                if (file_exists('storage/' .  $file->url_file)) {
                    unlink('storage/' . $file->url_file); //si el archivo ya existe se borra
                }
                $file->delete();
            }
        }
        return false;
    }

    /**
     * title: Obtiene el tipo de archivo
     * Descripción: Retorna el tipo de archivo en base a la extensión
     * @access private
     * @param  $extension Extensión del archivo
     * @return string tipo de archivo
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-15 20:57:40
     */
    private function getType($extension)
    {
        if (in_array($extension, $this->img_ext)) {
            return "image";
        }

        if (in_array($extension, $this->video_ext)) {
            return "video";
        }

        if (in_array($extension, $this->document_ext)) {
            return "document";
        }
    }


    /**
     * title: All extension
     * Descripción: Retorna un array con todas las extensiones admitidas
     * @access private
     * @return array | array_merge
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-15 20:55:58
     */
    private function allExtension()
    {
        return array_merge(
            $this->img_ext,
            $this->video_ext,
            $this->document_ext
        );
    }


    private function isValid($extension)
    {
        $all_ext = $all_ext = $this->allExtension();

        return in_array($extension, $all_ext);
    }
}
