<?php

namespace App\Traits;

trait SluggableTrait{

    public function createSlug($slug, $id = 0, $model){
        $slug = \Str::of($slug)->snake();
 
        $model = 'App\Models\\'.$model;

        // check if the model has related slugs
        $relatedSlugs = $this->getRelatedSlugs($slug, $id, $model);

        if(!$relatedSlugs->contains('slug', $slug)){
            return $slug;
        }
        
        // if slug exists
        // modify slug
        $i = 1;
        $contains = true;
        do{
            $newSlug = $slug.'_'.$i;
            if(!$relatedSlugs->contains('slug', $newSlug)){
                $contains = false;
                return $newSlug;
            }
            $i++;
        }while($contains);
    }

    protected function getRelatedSlugs($slug, $id = 0, $model){
        return $model::where('slug', 'like', $slug. '%')
                    // ->withTrashed()
                    ->where('id', '<>', $id)
                    ->get();
    }
}