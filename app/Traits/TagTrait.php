<?php

namespace App\Traits;


// use ArrayAccess;
// use Illuminate\Support\Arr;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Database\Eloquent\Collection;

use InvalidArgumentException;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait TagTrait
{
    public static function getTagClassName(): string
    {
        return Tag::class;
    }

    protected static function convertToTags($values, $type = null)
    {
        if ($values instanceof Tag) {
            $values = [$values];
        }

        return collect($values)->map(function ($value) use ($type) {
            if ($value instanceof Tag) {
                if (isset($type) && $value->type != $type) {
                    throw new InvalidArgumentException("Type was set to {$type} but tag is of type {$value->type}");
                }

                return $value;
            }

            $className = static::getTagClassName();

            return $className::findFromString($value, $type);
        });
    }


    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), 'taggable', 'taggables');
    }

    // attaching tags
    public function attachTags(array $addTags, string $type = null)
    {
        $className = static::getTagClassName();

        $tags = collect();
        foreach ($addTags as $tag) {
            $tag = $className::firstOrCreate([
                'name' => ucwords(strtolower($tag)),
                'type' => $type
            ]);
            $tags->push($tag);
        }

        $this->tags()->syncWithoutDetaching($tags->pluck('id')->toArray());

        return $this;
    }

    // attaching tag
    public function attachTag(string $tag, string $type = null)
    {
        return $this->attachTags([$tag], $type);
    }


    public function detachTags(array $tags, string $type = null)
    {
        $tags = static::convertToTags($tags, $type);


        collect($tags)
            ->filter()
            ->each(fn (Tag $tag) => $this->tags()->detach($tag));

        return $this;
        dd($this);
    }

    // public function detachTag(string | Tag $tag, string | null $type = null): static
    // {
    //     return $this->detachTags([$tag], $type);
    // }
}
