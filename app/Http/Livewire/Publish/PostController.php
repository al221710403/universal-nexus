<?php

namespace App\Http\Livewire\Publish;

use Carbon\Carbon;
use Spatie\Tags\Tag;
use Livewire\Component;
use App\Traits\PostTrait;
use Illuminate\Support\Str;
use App\Models\Publish\Post;
use Livewire\WithPagination;
use App\Models\Publish\Image;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Traits\FileManipulationTrait;
use Illuminate\Support\Facades\Storage;

class PostController extends Component
{
    use WithFileUploads;
    use WithPagination;
    use PostTrait;
    use FileManipulationTrait;

    // modals
    public $published_modal = false,
           $settings = false;

    // Variables utilizados en los tags
    public $tags, //contiene las etiquetas que estan asociadas al post
            $all_tags, //contiene una lista de todos los tags existentes
            $old_images;

    // Variables para las palabras clave
    public $keywords ,$new_keyword;

    // variables generales
    public $labelAction;

    // Varibles del post
    public $post_id,
           $post,
           $title,
           $body,
           $featured_image,
        //    $featured_image_caption,
           $published,
           $publish_date,
           $post_public = true;

    // directorio principal de lamacenamiento de archivos
    public $main_folder;

    // Variables para el archivo de recuperación
    public $pathAutoSave,
           $fileAutoSave,
           $recovery_file = false,
           $dataJson;

    protected $listeners =  [
        'deletePost' => 'deletePost',
        'autoSaveBlog' => 'autoSaveBlog'
    ];

    public function updated($propertyName)
    {
        // Verificar si la variable modificada es $settings
        if ($propertyName === 'settings') {
            if ($this->settings == false) {
                $this->new_keyword = "";
            }
        }

        // Verificar si la variable modificada es $recovery_file
        if ($propertyName === 'recovery_file') {
            if ($this->recovery_file == false) {
                // Elimina el archivo de AutoSave
                $this->deleteAutoSaveFile();
            }
        }
    }


    public function mount($id = 0)
    {
        // Obtiene o crea el post
        $this->setPostId($id);

        // Setear las variables de carpetas
        $this->main_folder = 'publish/post/';
        $this->pathAutoSave = $this->main_folder . 'autosave/';


        // Verifica si existe un archivo de recuperación
        $this->fileAutoSave = 'file_autosave_'.$this->post_id.'.json';
        $this->postRecovery($this->pathAutoSave . $this->fileAutoSave);

        // Obtiene la información del post
        $this->getPost();

    }

    public function render()
    {
        $similares = $this->getSimilarPosts();
        return view('livewire.publish.post.create', compact('similares'));
    }


    // SECCIÓN: FUNCIONES DEL POST
    /**
     * Establece el ID del post.
     *
     * Si se proporciona un ID válido, lo asigna directamente.
     * Si no se proporciona un ID válido (0), busca o crea un nuevo post sin título ni cuerpo.
     *
     * @param int $id El ID del post. Si es 0, se buscará o creará un nuevo post.
     * @return void
     */
    public function setPostId($id)
    {
        if ($id == 0) {
            $new_post = $this->findOrCreateNewPost();
            $this->post_id = $new_post->id;
        } else {
            $this->post_id = $id;
        }
    }

    /**
     * Busca un post sin título ni cuerpo y lo devuelve.
     * Si no encuentra ninguno, crea un nuevo post.
     *
     * @return \App\Models\Publish\Post El post encontrado o creado.
     */
    private function findOrCreateNewPost()
    {
        $new_post = Post::whereNull('title')->whereNull('body')->first();

        return $new_post ?? Post::create([
            "author_id" => Auth::user()->id,
            "slug" => "new-post-" . Str::uuid()
        ]);
    }

    /**
     * Obtiene y asigna los datos de un post especificado por su ID.
     *
     * Llena las variables de la clase con los datos del post. Además, establece
     * el mensaje de acción según si el post es nuevo o existente, llena las
     * variables utilizadas en los tags y decodifica el campo JSON existente
     * como un array asociativo.
     *
     * @throws \Exception Si el post con el ID especificado no existe.
     * @return void
     */
    public function getPost()
    {
        // Verificar si el post existe
        $this->post = Post::find($this->post_id);

        if ($this->post) {
            // Llenar las variables del post
            $this->fillPostVariables();

            // Verificar si el post es nuevo o existente
            $this->setLabelAction();

            // Llenar las variables utilizadas en los tags
            $this->fillTagVariables();

        } else {
            // Manejar caso donde el post no existe
            throw new \Exception("El post con ID $this->post_id no existe.");
        }
    }

    /**
     * Llena las variables de la clase con los datos del post.
     *
     * Este método llena las variables de la clase con los datos obtenidos del post,
     * incluyendo el título, el cuerpo, el estado de publicación, la fecha de
     * publicación, el subtítulo de la imagen destacada y la indicación de si el
     * post es público. Se utiliza en conjunto con el método getPost.
     *
     * @return void
     */
    private function fillPostVariables()
    {
        $this->title = $this->post->title;
        $this->body = $this->post->body;
        $this->published = $this->post->published;
        $this->publish_date = optional($this->post->publish_date)->format('Y-m-d\TH:i');
        // $this->featured_image_caption = $this->post->featured_image_caption;
        $this->post_public = $this->post->public == 1;

        $data_json = json_decode($this->post->metadata, true);
        $this->keywords = $data_json["keywords"] ?? [];
    }

    /**
     * Establece el mensaje de acción del post.
     *
     * Este método determina si el post es nuevo o existente y establece el mensaje
     * de acción en consecuencia. Se utiliza en conjunto con el método getPost.
     *
     * @return void
     */
    private function setLabelAction()
    {
        $this->labelAction = $this->published ? "Editar Artículo" : "New Artículo";
    }

    /**
     * Llena las variables utilizadas en los tags del post.
     *
     * Este método llena las variables utilizadas en los tags del post, incluyendo
     * los tags existentes y todos los tags disponibles. Se utiliza en conjunto
     * con el método getPost.
     *
     * @return void
     */
    private function fillTagVariables()
    {
        $this->tags = $this->post->tags->pluck('name')->toArray();
        $this->all_tags = Tag::pluck('name')->toArray();
        $this->old_images = $this->post->images->pluck('image_url')->toArray();
    }

    /**
     * Obtiene las publicaciones similares al post actual.
     *
     * Este método busca y devuelve las publicaciones similares al post actual,
     * basándose en las etiquetas del post. Si el post no tiene etiquetas, se
     * devuelven las publicaciones más recientes que no sean el propio post.
     *
     * @return \Illuminate\Database\Eloquent\Collection Las publicaciones similares al post actual.
     */
    private function getSimilarPosts()
    {
        $tagsIds = $this->post->tags->pluck('id');

        $query = Post::where('id', '!=', $this->post->id)
                    ->published()
                    ->latest('id');

        if ($tagsIds->isNotEmpty()) {
            return $query->tagsSearch($tagsIds->toArray())->take(3)->get();
        }

        return $query->take(3)->get();
    }

    /**
     * title: Guarda la configuración
     * Descripción: Guarda la configuración
     * @access public
     * @return message
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-01-26 00:19:27
     */
    public function saveSetting()
    {
        // Manda a llamar a la función que agrega y elimina los tags
        $this->addTags();

        // Manejar la imagen destacada
        $this->handleFeaturedImage();

        // Actualizar otras configuraciones del post
        // $this->post->featured_image_caption = $this->featured_image_caption;
        $this->post->publish_date = $this->publish_date;
        $this->post->public = $this->post_public;

        $old_metadata = json_decode($this->post->metadata, true);
        $old_metadata['keywords'] = $this->keywords;
        $this->post->metadata = json_encode($old_metadata, true);

        // Guardar el post
        $this->post->save();

        // Restablecer valores
        $this->featured_image = '';
        $this->new_keyword = "";
        $this->settings = false;

        // Emitir un evento
        $this->emit('noty-primary', 'Configuración guardada');
    }

    /**
     * Maneja la actualización de la imagen destacada del post.
     *
     * Este método verifica si se proporciona una nueva imagen destacada.
     * Si se proporciona, elimina la imagen anterior (si existe) y almacena
     * la nueva imagen destacada en el almacenamiento especificado.
     *
     * @return void
     */
    private function handleFeaturedImage()
    {
        // Verificar si se proporciona una nueva imagen destacada
        if ($this->featured_image) {
            // Eliminar la imagen anterior si existe
            Storage::delete($this->post->featured_image);

            // Almacenar la nueva imagen destacada
            $url = Storage::put($this->main_folder, $this->featured_image);
            $this->post->featured_image = $url;
        }
    }

    /**
     * title: Elimina el post
     * Descripción: Elimina el post y los registros e imagenes relacionadas al mismo
     * @access public
     * @return redirect route(publish.posts.index)
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-01-26 00:23:49
     */
    public function deletePost()
    {
        if ($this->deletePostTrait($this->post_id)) {
            return redirect()->route('publish.posts.index');
        } else {
            $this->emit('noty-danger', 'Ups!! Hubo un error al eliminar la publicación');
        }
    }

    /**
     * title: Guarda el post
     * Descripción: Guarda la información relacionada al post, actualiza el slug
     * y guarda o elimina las imagenes incrustadas y utilixada en el post
     * @access public
     * @return message
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-01-26 00:16:19
     */
    public function save($notify = true)
    {
        // Inicia una transacción para garantizar que todas las operaciones se completen correctamente
        DB::beginTransaction();

        try {
            // Actualiza el slug si el título ha cambiado
            $this->updateSlugIfTitleChanged();

            // Actualiza el contenido del post
            $this->updatePostContent();

            // Extrae e inserta imágenes
            $this->handlePostImages();

            // Obtiene la información actualizada del post
            $this->getPost();

            // Elimina el archivo de AutoSave
            $this->deleteAutoSaveFile();

            // Confirma la transacción si todas las operaciones se completaron correctamente
            DB::commit();

            // Emite un evento para indicar que los cambios se han guardado
            if($notify){
                $this->emit('noty-primary', 'Cambios guardados');
            }
        } catch (\Exception $e) {
            // Revierte la transacción si ocurre algún error durante el proceso
            DB::rollback();

            $this->emit('noty-warning', 'Ahi un error');
            // Registra el error
            Log::error('Error al guardar los cambios: ' . $e->getMessage());

            // Puedes lanzar una excepción personalizada o manejar el error de otra manera, según tus necesidades
        }
    }

    /**
     * Actualiza el contenido del post con los valores actuales de los atributos del componente.
     */
    public function updatePostContent()
    {
        // Actualiza el título y el cuerpo del post
        $this->post->title = $this->title;
        $this->post->body = $this->body;
        $this->post->save();

        $this->old_images = $this->post->images->pluck('image_url')->toArray();
    }

    /**
     * title: Pública el post
     * Descripción: Pública el post
     * @access public
     * @param  string $acction
     * @return message
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-01-26 00:21:39
     */
    public function publishedPost($action)
    {
        // Guarda el post
        $this->save();

        // Verifica si el título y el cuerpo del post no están vacíos
        if (strlen($this->title) > 0 && strlen($this->body) > 0) {
            // Establece el estado del post como publicado
            $this->post->published = true;

            // Si se especifica una acción, establece la fecha de publicación actual
            if ($action) {
                $this->post->publish_date = Carbon::now();
            }

            // Guarda los cambios en el post
            $this->post->save();

            // Oculta el modal de publicación
            $this->published_modal = false;

            // Emite un mensaje de éxito
            $this->emit('noty-primary', 'Artículo publicado');

            // Redirige al índice de posts
            return redirect()->route('publish.posts.index');
        } else {
            // Si el título o el cuerpo están vacíos, muestra un mensaje de error
            $this->published_modal = false;
            $this->emit('noty-danger', 'No se puede publicar un artículo vacío');
        }
    }


    //==================================================
    // FUNCIONES UTILIZADAS PARA EL TAG

    /**
     * title: Agrega los tags
     * Descripción: Agrega los tags y los relaciona al post
     * @access public
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-01-25 23:54:01
     */
    public function addTags()
    {
        // Busca y crea el tag en caso de que no exista y lo agrega al post
        $this->post->syncTags($this->tags);
    }


    // SECCIÓN: ARCHIVO DE RECUPERACIÓN

    /**
     * Obtiene el archivo de recuperación del post.
     *
     * Esta función verifica si existe un archivo de recuperación del post. Si
     * el archivo existe, se lee su contenido y guarda en la variable $dataJson
     * y muestra el modal de recuperación.
     * Si se produce algún error al leer el archivo,se captura la excepción y
     * se maneja, registrando el error en los logs.
     *
     * @param string $filePath La ruta del archivo JSON de recuperación.
     * @return void
     */
    private function postRecovery($filePath){
        if (Storage::exists($filePath)) {
            try {
                // Leer el contenido del archivo JSON
                $this->dataJson = json_decode(Storage::get($filePath), true);
                $this->recovery_file = true;
            } catch (\Exception $e) {
                // Manejar errores de lectura del archivo
                // Por ejemplo, loguear el error o tomar alguna acción alternativa
                Log::error('Error al leer el archivo de recuperación: ' . $e->getMessage());
            }
        }
    }

    // FUNCIONES DE PALABRAS ClAVE
    /**
     * Agrega una nueva palabra clave al array 'keywords' dentro del campo 'metadata'.
     *
     * @return void
     */
    public function addKeyword()
    {
        // Agregar la palabra clave al array 'keywords' dentro del campo 'metadata'
        $this->keywords[] = $this->new_keyword;
        // Limpiar el campo de nueva palabra clave
        $this->new_keyword = "";
    }

    /**
     * Elimina una palabra clave del array 'keywords' dentro del campo 'metadata'.
     *
     * @param string $word La palabra clave que se va a eliminar.
     * @return void
     */
    public function removeKeyword($word)
    {
        // Eliminar la palabra clave del array 'keywords'
        $this->keywords = array_diff($this->keywords, [$word]);
    }


    // FUNCIONES AutoSave
    /**
     * title: Auto Save
     * Descripción: Genera un archivo de recuperación de contenido
     * @access public
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2024-04-30 00:13:16
     */
    public function autoSaveBlog(){
        try {
            // Eliminar el archivo de guardado automático existente
            $this->deleteAutoSaveFile();

            // Crear un nuevo archivo de guardado automático
            $dataJson = [
                'created_at' => Carbon::now()->format('d/m/Y H:i:s'),
                'blog_title' => $this->title,
                'blog_content' => $this->body
            ];
            Storage::put($this->pathAutoSave . $this->fileAutoSave, json_encode($dataJson));

            // El archivo de guardado automático se ha creado exitosamente
        } catch (\Exception $e) {
            // Ocurrió un error durante la escritura del archivo
            Log::error('Error al guardar el archivo de guardado automático: ' . $e->getMessage());
            // Puedes lanzar una excepción personalizada o manejar el error de otra manera, según tus necesidades
        }
    }

    /**
     * title: Auto Save Delete or Save
     * Descripción: Deside si el archivo de recuperación se guarada o se elimina
     * @access public
     * @param string $action
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2024-04-30 00:13:16
     */
    public function autoSaveDeleteOrSave($action = 'save'){
        if ($action == 'save') {
            $this->savePostFromAutoSave();
        }
        $this->deleteAutoSaveFile();
    }


    /**
     * Guarda el contenido del post desde el auto guardado.
     *
     * @return void
     */
    protected function savePostFromAutoSave()
    {
        $this->title = $this->dataJson['blog_title'];
        $this->body = $this->dataJson['blog_content'];

        // Actualiza el slug si el título ha cambiado
        $this->updateSlugIfTitleChanged();

        // Se actualiza el contenido del post
        $this->updatePostContent();

        // Extrae e inserta imágenes
        $this->handlePostImages();

        return redirect()->route('publish.posts.edit', $this->post_id);
    }


    // FUNCIONES DE IMAGENES
    /**
     * title: Agrega las imagenes del post
     * Descripción: Agrega las imagenes que se insertan en el post a la base de datos
     * @access protected
     * @param  array $imagenes
     * @return message
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-01-25 23:57:26
     */
    protected function addImage($images)
    {
        DB::beginTransaction();

        try {
            $images = $this->getUrlImage($images);
            // dd($images,$this->old_images);

            foreach ($images as $image) {

                $existingImage = $this->post->images()->where('image_url', $image)->exists();

                if (!$existingImage) {
                    $this->post->images()->create([
                        'image_url' => $image
                    ]);
                }
            }

            $diffResult = array_diff($this->old_images, $images);
            if (!empty($diffResult)) {
                $this->deleteImage($diffResult);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->emit('noty-danger', 'Error al agregar imágenes: ' . $e->getMessage());
        }
    }

    /**
     * Get URLs for the given images by prepending a folder path.
     *
     * This method takes an array of image paths, extracts the basename of each image,
     * and prepends a specified folder path to create new URLs.
     *
     * @param array $images An array of image paths.
     * @return array An array of new image URLs with the folder path prepended.
     */
    protected function getUrlImage(array $images): array
    {
        $folder = $this->main_folder . 'image/';

        return array_map(function($image) use ($folder) {
            return $folder . pathinfo($image, PATHINFO_BASENAME);
        }, $images);
    }


    // FUNCIONES ADICIONALES

    /**
     * Crea un slug único basado en el título proporcionado.
     *
     * @param string $title El título del post para generar el slug.
     *
     * @return string El slug único generado basado en el título.
     */
    protected function createSlug($title)
    {
        $slug = Str::slug($title); // Genera el slug a partir del título proporcionado
        $originalSlug = $slug; // Almacena el slug original generado
        $counter = 1; // Inicializa un contador para manejar duplicados

        // Verifica si el slug ya existe en la base de datos
        while (Post::where('slug', $slug)->exists()) {
            // Si el slug ya existe, agrega un contador al final para hacerlo único
            $slug = $originalSlug . '-' . $counter;
            $counter++; // Incrementa el contador
        }

        return $slug; // Retorna el slug único generado
    }

    /**
     * Actualiza el slug del post si el título ha cambiado.
     */
    protected function updateSlugIfTitleChanged()
    {
        // Verifica si el título ha cambiado desde la última vez que se guardó
        if ($this->post->title !== $this->title) {
            // Actualiza el slug del post con el nuevo título
            $this->post->slug = $this->createSlug($this->title);
            $this->post->save();
        }
    }

    /**
     * Maneja las imágenes del post, extrayendo e insertando imágenes según sea necesario.
     */
    protected function handlePostImages()
    {
        // Extrae las imágenes del cuerpo del post
        $images = $this->extractImageTrait($this->body);
        $this->addImage($images);
    }

    /**
     * Elimina las imágenes del post.
     *
     * @param array $images Lista de URLs de imágenes a eliminar.
     * @return void
     * @throws \Exception Si ocurre un error durante el proceso.
     */
    public function deleteImage($images)
    {
        DB::beginTransaction();

        try {
            foreach ($images as $image) {
                $imageModel = Image::where('image_url', $image)->first();

                if ($imageModel) {
                    $imageModel->delete();
                }

                $this->deleteFile($image);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->emit('noty-danger', 'Error al eliminar imágenes: ' . $e->getMessage());
            throw $e;
        }
    }


    /**
     * Elimina el archivo de AutoSave después de guardar los cambios exitosamente.
     */
    protected function deleteAutoSaveFile()
    {
        // Elimina el archivo de AutoSave del almacenamiento
        $this->deleteFile($this->pathAutoSave . $this->fileAutoSave);
    }

    // En tu componente Livewire
    public function preview()
    {
        // Guarda el post
        $this->save(false);

        // Emite el evento para abrir la nueva pestaña
        $this->emit('previewPost', route('publish.posts.preview', $this->post_id));
    }
}
