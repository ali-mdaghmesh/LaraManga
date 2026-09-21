<?php

namespace App\Services;

use App\Models\Manga;

class LocalMangaService{

    function createManga(array $data){

        $cover = $data['cover'] ?? null; 
        unset($data['cover']); 

        $manga = Manga::create($data); 

        if ($cover) {
            $manga->addMedia($cover)->toMediaCollection('cover'); 
        }
        return $manga; 
    }

    function editManga(array $data, Manga $manga){

         $cover = $data['cover'] ?? null; 
        unset($data['cover']); 

        $manga->update($data); 

         if ($cover) {
            $manga->addMedia($cover)->toMediaCollection('cover'); 
        }
        return $manga; 
    }

    function deleteManga(Manga $manga){
        $manga->delete();
        return true;
    }

    function getAllMangas(){
       return Manga::where('source', 'local')->latest()->paginate(20);
    }



}