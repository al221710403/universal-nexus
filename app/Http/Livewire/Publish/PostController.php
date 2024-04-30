<?php

namespace App\Http\Livewire\Publish;

use Carbon\Carbon;
use Spatie\Tags\Tag;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Publish\Post;
use Livewire\WithPagination;
use App\Models\Publish\Image;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Traits\PostTrait;

class PostController extends Component
{
    use WithFileUploads;
    use WithPagination;
    use PostTrait;

    // modals
    public $settings = false, $published_modal = false, $recovery_file = false, $labelAction = "New Post";

    // Variables utilizados en los tags
    public $tags, $old_tags, $all_tags, $old_images;

    // Varibles del post
    public $post,
        $post_id,
        $title,
        $body,
        $featured_image,
        $featured_image_caption,
        $published,
        $publish_date,
        $post_public = true;

    public $pathAutoSave = 'publish/post/autosave/',
        $fileAutoSave,
        $dataJson;

    protected $listeners =  [
        'deletePost' => 'deletePost',
        'autoSaveBlog' => 'autoSaveBlog'
    ];

    public function mount($id = 0)
    {
        // Busca el post si es que existe, si no existe crea uno nuevo
        if ($id == 0) {
            $new_post = Post::whereNull('title')
                ->whereNull('body')->first();
            if (!$new_post) {
                $new_post = Post::create([
                    "author_id" => Auth::user()->id
                ]);
                $new_post->slug = "new-post-" . $new_post->id;
                $new_post->save();
            }
            $this->post_id = $new_post->id;
        } else {
            $this->post_id = $id;
        }

        $this->fileAutoSave = 'file_autosave_'.$this->post_id.'.json';

        // Si existe un archivo de recuperación
        if (file_exists('storage/' . $this->pathAutoSave . $this->fileAutoSave)) {
            $this->dataJson = json_decode(Storage::get($this->pathAutoSave . $this->fileAutoSave), true);
            $this->recovery_file = true;
        }

        $this->getPost();

        $this->all_tags = Tag::all('name')->pluck('name')->toArray();

    }

    public function render()
    {
        $tags = $this->post->tags;

        if ($tags->count() > 0) {
            $similares = Post::where('id', '!=', $this->post->id)
                ->tagsSearch($tags->pluck('id')->toArray())
                ->published()
                ->latest('id')
                ->take(3)
                ->get();
        } else {
            $similares = Post::where('id', '!=', $this->post->id)
                ->live()
                ->latest('id')
                ->take(3)
                ->get();
        }

        return view('livewire.publish.post.create', compact('similares'));
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
    public function save()
    {
        // Se actualiza el contenido del post
        $this->post->update([
            "title" => $this->title,
            "body" => $this->body
        ]);

        // Se actualiza el slug
        if (strlen($this->title) > 0) {
            $this->post->slug = $this->createSlug();
            $this->post->save();
        }

        // Se manda a llamar a la función de extraer las imagenes del post y despúes
        // se almacenan en la base de datos
        $images = $this->extractImage($this->body);
        $this->addImage($images);

        // Obtiene la información actualizada del post
        $this->getPost();

        //Se elimina el archivo de AutoSave
        $this->deleteFile('storage/' .$this->pathAutoSave.$this->fileAutoSave);

        $this->emit('noty-primary', 'Cambios guardados');
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
        // Manda a llamar a la función que aggrea y elimina los tags
        $this->addTags();

        $path = 'publish/post/';
        if ($this->featured_image) {
            if ($this->post->featured_image != null) {
                if ($this->post->featured_image != 'noimg.png') {
                    if (file_exists('storage/' .  $this->post->featured_image)) {
                        unlink('storage/' . $this->post->featured_image); //si el archivo ya existe se borra
                    }
                }
            }
            $url = Storage::put($path, $this->featured_image);
            $this->post->featured_image = $url;
        }

        $this->post->featured_image_caption = $this->featured_image_caption;
        $this->post->publish_date = $this->publish_date;
        $this->post->public = $this->post_public;

        $this->post->save();
        $this->featured_image = '';
        $this->settings = false;

        // $this->getPost();

        $this->emit('noty-primary', 'Configiración guardada');
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
        $this->save();
        if (strlen($this->title) > 0 && strlen($this->body) > 0) {
            $this->post->published = true;
            $this->post->publish_date = $action ? Carbon::now()->timestamp : $this->publish_date;
            $this->post->save();
            $this->published_modal = false;
            $this->emit('noty-primary', 'Artículo publicado');
            return redirect()->route('publish.posts.index');
        } else {
            $this->published_modal = false;
            $this->emit('noty-danger', 'No se puede publicar un artículo vacío');
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
     * title: Obtiene instancia del post
     * Descripción: Obtene el registro del post y llenas las variables locales del post y de los tags
     * @access public
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-01-25 23:52:26
     */
    public function getPost()
    {
        // Obtine y llenas las variables del post
        $this->post = Post::find($this->post_id);
        $this->title = $this->post->title;
        $this->body = $this->post->body;
        $this->published = $this->post->published;
        $this->publish_date = $this->post->publish_date->format('Y-m-d\TH:i');
        $this->featured_image_caption = $this->post->featured_image_caption;
        $this->post_public = $this->post->public == 1 ? true : false;

        // Verifica si el post es nuevo o si ya existe, para llenar el mensague
        $this->labelAction = $this->published ? "Editar Artículo" : "New Artículo";

        // Llena las variables utilizadas en los tags
        $this->old_tags = $this->post->tags->pluck('name')->toArray();
        $this->all_tags = Tag::all('name')->pluck('name')->toArray();
        $this->old_images = $this->post->images->pluck('image_url')->toArray();
    }

    //==================================================
    // Funciones de tags utilizadas en el post

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



    //==================================================

    //==================================================
    // Funciones de images utilizadas en el post


    /**
     * title: Extrae las imagenes
     * Descripción: Extrae las imagenes incrustadas en el post con regex
     * @access public
     * @param  string $data
     * @return array $matches
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-01-26 00:04:56
     */
    public function extractImage($data)
    {
        $re_extract_image = '/src=["\']([^ ^"^\']*)["\']/ims';
        preg_match_all($re_extract_image, $data, $matches);
        return $matches[1];
    }

    /**
     * title: Agrega las imagenes del post
     * Descripción: Agrega las imagenes que se insertan en el post a la base de datos
     * @access public
     * @param  array $imagenes
     * @return message
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-01-25 23:57:26
     */
    public function addImage($images)
    {
        $path = 'publish/post/image/';
        $newImages = [];

        // Crea un nuevo array agregando el path completo a las imagenes
        foreach ($images as $image) {
            $image_url = $path . pathinfo($image, PATHINFO_BASENAME);
            array_push($newImages, $image_url);
        }

        // Crea los registros de imagenes y los vinvula al post
        foreach ($newImages as $image) {
            $clave = array_search($image, $this->old_images);
            if ($clave === false) {
                $this->post->images()->create([
                    'image_url' => $image
                ]);
            }
        }

        // Llama a la funcion que elimina las imagenes innecesarias
        $deleteImage = array_diff($this->old_images, $newImages);
        $this->deleteImage($deleteImage);
    }

    /**
     * title: Elimina las imagenes
     * Descripción: Elimina las imagenes que se incrustan dentro del post
     * @access public
     * @param  array $images
     * @return message
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-01-26 00:03:25
     */
    public function deleteImage($images)
    {
        foreach ($images as $delete) {
            $file = Image::where('image_url', $delete)->first();
            if ($file) {
                DB::beginTransaction();
                try {
                    if (file_exists('storage/' .  $delete)) {
                        unlink('storage/' . $delete); //si el archivo ya existe se borra
                    }
                    $file->delete();
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    $this->emit('noty-danger', 'Ups!! Hubo un error al eliminar la imagen física');
                    return $e->getMessage();
                }
            }
        }
    }

    //==================================================

    /**
     * title: Crea el slug
     * Descripción: Crea el slug utilizado en el post en base al titulo del mismo
     * @access public
     * @return string $slug
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-01-26 00:13:16
     */
    public function createSlug()
    {
        $slug = Str::slug($this->post->title);
        $slugExist = Post::where('slug', $slug)->where('id', '!=', $this->post->id)->first();

        if ($slugExist) {
            $max = Post::where('title', $this->post->title)->count();
            $max = $max == 0 ? 1 : $max + 1;
            return $slug . '-' . $max;
        } else {
            return $slug;
        }
    }


    //==================================================

    //==================================================

    /**
     * title: Auto Save
     * Descripción: Genera un archivo de recuperación de contenido
     * @access public
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2024-04-30 00:13:16
     */
    public function autoSaveBlog(){
        $this->deleteFile('storage/' . $this->pathAutoSave.$this->fileAutoSave);

        $dataJson = [
            'craeted_at' => Carbon::now()->format('d/m/Y H:i:s'),
            'blog_title' => $this->title,
            'blog_content' => $this->body
        ];

        Storage::put($this->pathAutoSave.$this->fileAutoSave, json_encode($dataJson));
        // $this->emit('noty-primary', 'Cambios guardados');
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
            $this->title = $this->dataJson['blog_title'];
            $this->body = $this->dataJson['blog_content'];

            // Se actualiza el contenido del post
            $this->post->update([
                "title" => $this->title,
                "body" => $this->body
            ]);

            // Se actualiza el slug
            if (strlen($this->title) > 0) {
                $this->post->slug = $this->createSlug();
                $this->post->save();
            }

            // Se manda a llamar a la función de extraer las imagenes del post y despúes
            // se almacenan en la base de datos
            $images = $this->extractImage($this->body);
            $this->addImage($images);

            //Se elimina el archivo de AutoSave
            $this->deleteFile('storage/' .$this->pathAutoSave.$this->fileAutoSave);

            return redirect()->route('publish.posts.edit', $this->post_id);
        }
        $this->deleteFile('storage/' . $this->pathAutoSave.$this->fileAutoSave);
    }

    /**
     * title: Elimina archivos
     * Descripción: Recibe la ruta de un archivo y lo elimina
     * @access public
     * @param string $file
     * @return message
     * @author Cristian Milton Fidel Pascual <al221710403@gmail.com>
     * @date 2023-01-26 00:03:25
     */
    public function deleteFile($file){
        if (file_exists($file)) {
            unlink($file); //si el archivo ya existe se borra
        }
    }
}
