<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Services\EventService;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\ReservationCalendarResource;

class EventController extends Controller
{
    /**
     * Reservation service
     *
     * @var \App\Service\EventService
     */
    protected $eventService;

    /**
     * Constructor
     *
     * @param \App\Service\EventService $eventService
     */
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * Get all reservation
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch all events
        $events = $this->eventService->all();

        return response()->success(
            __('messages.reservations_fetched'),
            ReservationResource::collection($events)
        );
    }
    
    /**
     * Get rate of all events in current year
     * 
     * @return \Illuminate\Http\Response
     */
    public function rate()
    {
        // Fetch all events for current year
        $events = $this->eventService->getReservationsByThisYear();

        return response()->success(
            __('messages.reservations_fetched'),
            $events
        );
    }

    /**
     * Store new reservation
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            // create new reservation
            $createdReservation = $this->eventService->create($request->input());

            return response()->success(
                __('messages.reservation_created'),
                $createdReservation,
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
