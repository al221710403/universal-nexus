<?php

namespace App\Traits;

use Spatie\Tags\Tag;
use App\Models\Publish\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

trait PostTrait {

    private $filesArray = [];

    /**
     * Descripción: Elimina un post y sus elementos relacionados (etiquetas, imágenes, etc.).
     * @param int $id El ID del post que se eliminará.
     * @return void
     * @throws \Exception Si ocurre algún error durante la eliminación.
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2024-04-30 00:04:56
     */
    public function deletePostTrait($id)
    {
        $post = Post::find($id);
        $fileAutoSave = 'publish/post/autosave/'.'file_autosave_'.$post->id.'.json';
        $path = 'publish/post/image/';

        DB::beginTransaction();
        try {
            $tags = $post->tags;
            $images = $post->images;

            // Elimina los tags asociados al post
            if ($tags->count() > 0) {
                $post->detachTags($tags->pluck('name')->toArray());
            }

            // Elimina las imagenes
            if ($images->count() > 0) {
                foreach ($images as $image) {
                    // Guarda las imaganes en la variable filesArray para despues borrar los archivos
                    if (Storage::disk('public')->exists($image->image_url)) {
                        $this->filesArray = $this->addItemToArray($this->filesArray,$image->image_url);
                    }
                    $image->delete();
                }
            }

            // Agrega la imagen de portada al array filesArray
            if ($post->featured_image != 'noimg.png') {
                if (Storage::disk('public')->exists($post->featured_image)) {
                    $this->filesArray = $this->addItemToArray($this->filesArray,$post->featured_image);
                }
            }

            // Extrae las imagenes dentro del post
            $images = $this->extractImageTrait($post->body);

            // Agrega las imagenes del post al array filesArray
            foreach ($images as $image) {
                $image_url = $path . pathinfo($image, PATHINFO_BASENAME);
                $this->filesArray = $this->addItemToArray($this->filesArray,$image_url);
            }

            // Agrega el archivo de autosave al array filesArray
            $this->filesArray = $this->addItemToArray($this->filesArray,$fileAutoSave);

            // Elimina el post
            if ($post->delete()) {
                // Elimina los archivos si el post se elimino correctamente
                foreach ($this->filesArray as $file) {
                    $this->deleteFileTrait($file);
                }
            }
            DB::commit();
            return true;

        } catch (\Exception $e) {
             DB::rollback();
             return false;
            //  return $e->getMessage();
        }

    }


    /**
     * Descripción: Elimina un archivo del sistema de almacenamiento.
     * @param string $file Ruta del archivo a eliminar.
     * @param bool $pathStore (Opcional) Indica si la ruta incluye 'storage/' o no.
     * @return void
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2024-04-30 00:04:56
     */
    public function deleteFileTrait($file,$pathStore = true){
        // Asigna la ruta completa (con o sin 'storage/') según la opción $pathStore
        $fullPath = $pathStore ? 'storage/'.$file : $file;

        // Verifica si el archivo existe antes de intentar eliminarlo
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    /**
     * Descripción: Agrega un nuevo elemento a un array existente.
     * @param array $existingArray El array existente al que se agregará el nuevo elemento.
     * @param mixed $newItem El elemento que se agregará al array.
     * @param bool $checkDuplicates (Opcional) Si se debe verificar la existencia de duplicados.
     * @return array El array actualizado con el nuevo elemento (si no es duplicado).
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2024-04-30 00:04:56
     */
    private function addItemToArray($existingArray,$newItem,$checkDuplicates = true){
        // Verifica si se deben verificar duplicados
        if ($checkDuplicates) {
            // Si el nuevo elemento ya existe en el array, no lo agrega nuevamente
            if (in_array($newItem, $existingArray)) {
                return $existingArray;
            }
        }

        return array_merge($existingArray, [$newItem]);
    }


    /**
     * title: Extrae las imagenes
     * Descripción: Extrae las imagenes incrustadas en el post con regex
     * @access public
     * @param  string $data
     * @return array $matches
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-01-26 00:04:56
     */
    public function extractImageTrait($data)
    {
        $re_extract_image = '/src=["\']([^ ^"^\']*)["\']/ims';
        preg_match_all($re_extract_image, $data, $matches);
        return $matches[1];
    }
}
