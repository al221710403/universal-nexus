<?php

namespace App\Traits;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait FileManipulationTrait
{
    // Extensiones admitidas
    private $img_ext = ['jpg', 'png', 'jpge', 'gif', 'JPG', 'PNG', 'JPGE', 'GIF'];
    private $video_ext = ['mp4', 'avi', 'mpge', 'MP4', 'AVI', 'MPGE'];
    private $document_ext = ['txt', 'doc', 'docx', 'pdf', 'TXT', 'DOC', 'DOCX', 'PDF'];

    private $path = "default_files";



    /**
     * Elimina un archivo.
     *
     * @param string $path       La ruta del archivo a eliminar.
     * @param bool   $useStorage Indica si se debe utilizar el sistema de almacenamiento de Laravel (predeterminado: true).
     *
     * @return bool True si el archivo se eliminó correctamente, de lo contrario false.
     */
    public function deleteFile($path)
    {
        try {
            // Verifica si el archivo existe antes de intentar eliminarlo
            if (Storage::exists($path)) {
                Storage::delete($path);
                return true; // Retorna true si el archivo se eliminó correctamente
            } else {
                return false; // Retorna false si el archivo no existe
            }
        } catch (\Exception $e) {
            // Maneja cualquier error que pueda ocurrir durante el proceso de eliminación
            Log::error('Error al eliminar el archivo: ' . $e->getMessage());
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
    public function uploadFile($path_file = null)
    {
        dd($path_file);
        // Establecer el directorio de destino
        $path_file = $path_file ?? $this->path;

        // Verificar si se proporciona un archivo válido
        if (!$path_file || !is_file($path_file)) {
            return false;
        }

        // Obtener el nombre y la extensión del archivo
        $ext = $path_file->getClientOriginalExtension();

        // Validar si la extensión es válida
        if (!$this->isValid($ext)) {
            return false;
        }

        // Subir el archivo y crear una nueva entrada en la base de datos
        // $newFile = Storage::putFileAs($directory, $file, $name);



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


    /**
     * Descripción: Verifica si la extensión es valida
     * @access private
     * @return array | array_merge
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-02-15 20:55:58
     */
    private function isValid($extension)
    {
        $all_ext = $all_ext = $this->allExtension();
        return in_array($extension, $all_ext);
    }

}
