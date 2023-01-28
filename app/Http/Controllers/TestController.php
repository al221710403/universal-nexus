<?php

namespace App\Http\Controllers;

use App\Models\Publish\Tag;
use Illuminate\Http\Request;


class TestController extends Controller
{
    public function test()
    {
        // $value = env('DB_DATABASE');

        config(['app.bd_name' => 'prueba']);
        $valueDB = config('app.bd_name');

        $tag = Tag::create([
            'name' => 'prueba_tag'
        ]);
        // $value = config('DB.DATABASE');
        // config(['app.timezone' => 'America/Chicago']);
        dd($tag, $valueDB);
        $padre = dirname(__DIR__);
        $padre = dirname($padre);
        $padre = dirname($padre);
        $name = $padre . '\.env';

        $fp = fopen($name, 'r') or die("error al intentar crear archivo");
        // $file = fopen($padre . '\file.txt', 'a+') or die("error al intentar crear archivo");
        $datos = fread($fp, filesize($name));
        fclose($fp);

        return view('test', compact('datos'));
        // dd($datos);
        // $sizeFile = fpassthru($fp);

        // dd($sizeFile); //964



        // $datos = fread($fp, filesize($sizeFile));
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
