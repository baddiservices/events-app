<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomResource;
use Exception;
use Illuminate\Http\Request;
use App\Services\RoomService;
use InvalidArgumentException;

class GroupController extends Controller
{
    /**
     * Group service
     *
     * @var \App\Service\RoomService
     */
    protected $groupService;

    /**
     * Constructor
     *
     * @param \App\Service\RoomService $groupService
     */
    public function __construct(RoomService $groupService)
    {
        $this->groupService = $groupService;
    }

    /**
     * Get all groups
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch all groups
        $groups = $this->groupService->all();

        return response()->success(
            __('messages.groups_fetched'),
            RoomResource::collection($groups)
        );
    }

    /**
     * Store new group
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            // create new group
            $createdRoom = $this->groupService->create($request->input());

            return response()->success(
                __('messages.group_created'),
                $createdRoom,
                201
            );
        }catch(InvalidArgumentException $ex){
            return response()->error(
                __('auth.signup_fields'),
                [$ex->getMessage()],
                $ex->getCode()
            );
        }catch(Exception $ex){
            return response()->error(
                __('messages.error'),
                [$ex->getMessage()],
                500
            );
        }
    }
}
