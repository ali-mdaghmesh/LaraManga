<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocalManga\StoreMangaRequest;
use App\Http\Requests\LocalManga\UpdateMangaRequest;
use App\Http\Resources\MangaResource;
use App\Models\Manga;
use App\Services\LocalMangaService;
use Illuminate\Http\Request;

class LocalMangaController extends Controller
{
    private $localMangaService; 

    public function __construct(LocalMangaService $localMangaService)
    {
        $this->localMangaService = $localMangaService; 
    }

    function store(StoreMangaRequest $storeMangaRequest)
    {
        $validatedData = $storeMangaRequest->validated(); 
        $manga = $this->localMangaService->createManga($validatedData); 
        return $this->createdResponse(
            new MangaResource($manga),
            'The manga created successfully.'
        );
    }

    function update(UpdateMangaRequest $updateMangaRequest, Manga $localManga)
    {
        $validatedData = $updateMangaRequest->validated(); 
        $manga = $this->localMangaService->editManga($validatedData, $localManga); 
        return $this->successResponse(
            new MangaResource($manga),
            'The manga updated successfully.'
        );
    }

    function destroy(Manga $localManga)
    {
        $this->localMangaService->deleteManga($localManga); 
        return $this->deletedResponse('The manga deleted successfully.'); 
    }

    function index()
    {
        $mangas = $this->localMangaService->getAllMangas();
        return $this->paginatedResponse($mangas, MangaResource::class,"The manga List:");
    }

    function show(Manga $localManga){
    
        $localManga->load(['chapters' => fn ($query) => $query->orderBy('chapter_number')]);
        return $this->successResponse(new MangaResource($localManga)); 
    }
}
