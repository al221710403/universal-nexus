<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class Boxicon extends Component
{
    public $search, $category, $type;

    public $selectIcon, $rotate, $animationIcon, $flip;

    public $nameComponent;

    protected $listeners = [
        'sendIconComponent'
    ];

    public function mount()
    {
        $this->category = "Elegir";
        $this->type = "ALL";
    }

    public function render()
    {
        // dd($this->nameComponent);
        $getFile = json_decode(Storage::get('boxicons.json'), true);
        $boxicons = $getFile['icons'];
        $boxicons = array_values(Arr::sort($boxicons, function ($value) {
            return $value['name'];
        }));
        // dd($boxicons);
        $categories = $getFile['categories'];
        $getFile = "";
        $matchesSearch = Arr::pluck($boxicons, 'name');

        if (strlen($this->search) > 0) {
            $termToSearch = $this->search;
            $matches = array_filter($matchesSearch, function ($var) use ($termToSearch) {
                return stristr($var, $termToSearch);
            });

            $boxicons = $this->filterArray($boxicons, $matches);
        }

        if ($this->category != 'Elegir') {
            $boxicons = $this->filterCategory($boxicons, $this->category);
        }

        if ($this->type != 'ALL') {
            $boxicons = $this->filterType($boxicons, $this->type);
        }

        return view('livewire.boxicon', compact('boxicons', 'categories'));
    }

    public function resetUI()
    {
        $this->search = "";
        $this->category = "Elegir";
        $this->type = "ALL";
    }

    public function filterArray($arrayFilter, $arrayData)
    {
        $newArray = [];

        foreach ($arrayFilter as $filter) {
            foreach ($arrayData as $search) {
                if ($filter['name'] == $search) {
                    array_push($newArray, $filter);
                }
            }
        }
        return $newArray;
    }

    public function filterCategory($arrayFilter, $category)
    {
        $newArray = [];

        foreach ($arrayFilter as $filter) {
            if ($filter['category_id'] == $category) {
                array_push($newArray, $filter);
            }
        }
        return $newArray;
    }

    public function filterType($arrayFilter, $type)
    {
        $newArray = [];

        foreach ($arrayFilter as $filter) {
            if ($filter['type_of_icon'] == $type) {
                array_push($newArray, $filter);
            }
        }
        return $newArray;
    }

    public function getIcon($icon)
    {
        $this->rotate = "";
        $this->animationIcon = "";
        $this->flip = "";

        $this->selectIcon = $icon;
        $this->emit('updateIconContainer');
    }

    public function changeAnimation($animation)
    {
        $this->animationIcon = $animation;
        $this->emit('updateIconContainer');
    }

    public function changeRotate()
    {
        $rotateValue = [
            'bx-rotate-90',
            'bx-rotate-180',
            'bx-rotate-270'
        ];

        if ($this->rotate) {
            switch ($this->rotate) {
                case 'bx-rotate-90':
                    $this->rotate = $rotateValue[1];
                    break;
                case 'bx-rotate-180':
                    $this->rotate = $rotateValue[2];
                    break;
                case 'bx-rotate-270':
                    $this->rotate = "";
                    break;
                default:
                    $this->rotate = "";
                    break;
            }
        } else {
            $this->rotate = $rotateValue[0];
        }

        $this->emit('updateIconContainer');
    }

    public function changeFlip()
    {
        $flipValue = [
            'bx-flip-vertical',
            'bx-flip-horizontal'
        ];

        if ($this->flip) {
            switch ($this->flip) {
                case 'bx-flip-vertical':
                    $this->flip = $flipValue[1];
                    break;
                case 'bx-flip-horizontal':
                    $this->flip = "";
                    break;
                default:
                    $this->flip = "";
                    break;
            }
        } else {
            $this->flip = $flipValue[0];
        }
        $this->emit('updateIconContainer');
    }

    public function closeViewIcon()
    {
        $this->selectIcon = "";
        $this->rotate = "";
        $this->animationIcon = "";
        $this->flip = "";
    }


    public function sendIconComponent($icon)
    {
        $this->emitTo($this->nameComponent, 'receiveIconToBoxicon', $icon);
        $this->emit('noty-primary', 'Icono guardado');
    }
}
