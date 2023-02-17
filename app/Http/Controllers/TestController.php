<?php

namespace App\Http\Controllers;

use App\Models\Publish\Tag;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class TestController extends Controller
{
    public function test()
    {


        $json_boxicons = Storage::get('boxicons.json');
        $boxicons = json_decode(Storage::get('boxicons.json'), true);


        // dd($boxicons);
        // dd($json_boxicons);


        // $value = env('DB_DATABASE');

        // config(['app.bd_name' => 'prueba']);
        // $valueDB = config('app.bd_name');

        // $tag = Tag::create([
        //     'name' => 'prueba_tag'
        // ]);
        // // $value = config('DB.DATABASE');
        // // config(['app.timezone' => 'America/Chicago']);
        // dd($tag, $valueDB);
        // $padre = dirname(__DIR__);
        // $padre = dirname($padre);
        // $padre = dirname($padre);
        // $name = $padre . '\.env';

        // $fp = fopen($name, 'r') or die("error al intentar crear archivo");
        // // $file = fopen($padre . '\file.txt', 'a+') or die("error al intentar crear archivo");
        // $datos = fread($fp, filesize($name));
        // fclose($fp);

        return view('test2');
        // return view('test-boxicons', compact('json_boxicons', 'boxicons'));
        // dd($datos);
        // $sizeFile = fpassthru($fp);

        // dd($sizeFile); //964



        // $datos = fread($fp, filesize($sizeFile));
    }

    public function editJson()
    {
        $boxicons = json_decode(Storage::get('boxicons.json'), true);

        $newJson = [];
        $newIcons = [];

        foreach ($boxicons['icons'] as $icon) {
            $newElements = $this->generateIcon($icon['type_of_icon'], $icon['name']);
            $icon = Arr::add($icon, 'icon_text', $newElements['icon_text']);
            $icon = Arr::add($icon, 'icon_element', $newElements['icon_element']);
            array_push($newIcons, $icon);
        }

        $newJson = Arr::add($newJson, 'icons', $newIcons);
        $newJson = Arr::add($newJson, 'categories', $boxicons['categories']);

        Storage::put('boxicons.json', json_encode($newJson));

        // dd($boxicons);
        // dd($json_boxicons);
    }

    public function generateIcon($type, $icon)
    {
        $result = [];
        $typeIcons = [
            'bx' => 'REGULAR',
            'bxs' => 'SOLID',
            'bxl' => 'LOGO'
        ];
        $clave = array_search($type, $typeIcons);

        $iconText = 'bx ' . $clave . '-' . $icon;
        $iconElement = "<i class='bx " . $clave . '-' . $icon . "'></i>";
        $result = Arr::add($result, 'icon_text', $iconText);
        $result = Arr::add($result, 'icon_element', $iconElement);
        return $result;
    }


    public function store(Request $request)
    {
        $padre = dirname(__DIR__);
        $padre = dirname($padre);
        $padre = dirname($padre);
        $name = $padre . '\.env';
        $content = $request['env'];

        $fp = fopen($name, 'w') or die("error al intentar crear archivo");

        fwrite($fp, $content);
        fclose($fp);

        $fp = fopen($name, 'r') or die("error al intentar crear archivo");
        // $file = fopen($padre . '\file.txt', 'a+') or die("error al intentar crear archivo");
        $datos = fread($fp, filesize($name));
        fclose($fp);


        dd($datos);
    }
}
