<?php

namespace Modules\Player\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ResourceTrait;
use App\Http\Controllers\Rest\BaseController;
use Modules\Generality\Services\ResourceService;
use Modules\Player\Http\Requests\StoreSkillsRequest;
use Modules\Player\Http\Requests\UpdateSkillsRequest;
use Modules\Player\Repositories\Interfaces\SkillsRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;

class SkillsController extends BaseController
{
    use ResourceTrait;

    /**
     * @var $skillsRepository
     */
    protected $skillsRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * @var $resourceService
     */
    protected $resourceService;

    public function __construct(
        SkillsRepositoryInterface $skillsRepository,
        ResourceRepositoryInterface $resourceRepository,
        ResourceService $resourceService  
    )
    {
        $this->skillsRepository = $skillsRepository;
        $this->resourceRepository = $resourceRepository;
        $this->resourceService = $resourceService;
    }
    
    /**
    * @OA\Get(
    *       path="/api/v1/players/assessment/skills",
    *       tags={"Player"},
    *       summary="Get list skills  - Lista de skills",
    *       operationId="list-skills",
    *       description="Return data list skills - Retorna el listado de skills",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       ),
    *       @OA\Response(
    *           response="401",
    *           ref="#/components/responses/notAuthenticated"
    *       )
    * )
    */
    /**
     * Display a listing of Skills.
     * @return Response
     */
    public function index()
    {
        $skills = $this->skillsRepository->findAllWithImage();

        return $this->sendResponse($skills, 'List of Skills');
    }

    /**
    * @OA\Post(
    *       path="/api/v1/players/assessment/skills",
    *       tags={"Player"},
    *       summary="Stored Skills - guardar Skills",
    *       operationId="skills-store",
    *       description="Store a new skills - Guarda un nuevo  Skill",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="multipart/form-data",
    *             @OA\Schema(ref="#/components/schemas/StoreSkillsRequest")
    *         )
    *       ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       ),
    *       @OA\Response(
    *           response=422,
    *           ref="#/components/responses/unprocessableEntity"
    *       ),
    *       @OA\Response(
    *           response="401",
    *           ref="#/components/responses/notAuthenticated"
    *       )
    * )
    */
    /**
     * Store a newly created resource in storage.
     * @param StoreSkillsRequest $request
     * @return Response
     */
    public function store(StoreSkillsRequest $request)
    {
        try {
            $skillsCreate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ],
                'code' => $request->code,
                'image_id'  => ''
            ];


            if ($request->image) {
                $dataResource = $this->uploadResource('/players/skills', $request->image);

                $resource = $this->resourceRepository->create($dataResource);

                if ($resource) {
                    $skillsCreate['image_id'] = $resource->id;
                }
            }

            $skills = $this->skillsRepository->create($skillsCreate);

            return $this->sendResponse($skills, 'Skill stored', Response::HTTP_CREATED);
        } 
        catch (Exception $exception) {
            return $this->sendError('Error by creating Skill', $exception->getMessage());
        }
    }

    /**
    * @OA\Get(
    *       path="/api/v1/players/assessment/skills/{code}",
    *       tags={"Player"},
    *       summary="Show skills  - Ver los datos de un Skills",
    *       operationId="show-skills",
    *       description="Return data to skills  - Retorna los datos de un Skills",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       ),
    *       @OA\Response(
    *           response="401",
    *           ref="#/components/responses/notAuthenticated"
    *       )
    * )
    */
    /**
     * Show the specified resource.
     * @param int $code
     * @return Response
     */
    public function show($code)
    {
        try {

            $skills = $this->skillsRepository->findOneBy(["code" => $code]);

            if(!$skills) {
                return $this->sendError("Error", "Skill not found", Response::HTTP_NOT_FOUND);
            }

            return $this->sendResponse($skills, 'Skill information');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving Skill', $exception->getMessage());
        }
    }

    /**
    * @OA\Post(
    *       path="/api/v1/players/assessment/skills/{code}",
    *       tags={"Player"},
    *       summary="Edit Skills  - Editar Skills",
    *       operationId="skills-edit",
    *       description="Edit a skills  - Edita un Skills",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *           mediaType="multipart/form-data",
    *             @OA\Schema(ref="#/components/schemas/UpdateSkillsRequest")
    *         )
    *       ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       ),
    *       @OA\Response(
    *           response=422,
    *           ref="#/components/responses/unprocessableEntity"
    *       ),
    *       @OA\Response(
    *           response="401",
    *           ref="#/components/responses/notAuthenticated"
    *       )
    * )
    */
    /**
     * Update the specified resource in storage.
     * @param UpdateSkillsRequest $request
     * @param int $code
     * @return Response
     */
    public function update(UpdateSkillsRequest $request, $code)
    {
        try {

            $skills = $this->skillsRepository->findOneBy(["code" => $code]);

            if(!$skills) {
                return $this->sendError("Error", "Skill not found", Response::HTTP_NOT_FOUND);
            }

            $skillsUpdate = [
                'es' => [
                    'name' => $request->name_spanish
                ],
                'en' => [
                    'name' => $request->name_english
                ]
            ];

            if ($request->image) {
                $dataResource = $this->uploadResource('/players/skills', $request->image);

                $resource = $this->resourceRepository->create($dataResource);

                if ($resource) {
                    $skillsUpdate['image_id'] = $resource->id;
                }
            }

             $updated = $this->skillsRepository->update($skillsUpdate, ["id" => $skills->id]);

             if ($request->image && $skills->image_id)
             $this->resourceService->deleteResourceData($skills->image_id);

             return $this->sendResponse($updated, 'Skills data updated');

        } catch (Exception $exception) {
            return $this->sendError('Error by updating Skills', $exception->getMessage());
        }
    }

    /**
    * @OA\Delete(
    *       path="/api/v1/players/assessment/skills/{code}",
    *       tags={"Player"},
    *       summary="Delete Skills  - Elimina un Skills",
    *       operationId="skills-delete",
    *       description="Delete a Skills - Elimina un Skills",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/code" ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       ),
    *       @OA\Response(
    *           response=422,
    *           ref="#/components/responses/unprocessableEntity"
    *       ),
    *       @OA\Response(
    *           response="401",
    *           ref="#/components/responses/notAuthenticated"
    *       )
    * )
    */
    /**
     * Remove the specified resource from storage.
     * @param int $code
     * @return Response
     */
    public function destroy($code)
    {
        try {

            $skills = $this->skillsRepository->findOneBy(["code" => $code]);

            if(!$skills) {
                return $this->sendError("Error", "Skill not found", Response::HTTP_NOT_FOUND);
            }

            $return = $this->skillsRepository->delete($skills->id) 
            ? $this->sendResponse(NULL, 'Skill deleted', Response::HTTP_ACCEPTED) 
            : $this->sendError('Skill Not Existing');

            return $return; 
            
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting Skill', $exception->getMessage());
        }
    }

}
