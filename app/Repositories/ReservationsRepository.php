<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Torann\LaravelRepository\Repositories\AbstractRepository;

class ReservationsRepository extends AbstractRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    protected $model = \App\Models\Event::class;

    /**
     * Fetch all events with relationships
     * 
     * @return \Illuminate\Support\Collection
     */
    public function allWithRelationships() : Collection
    {
        return Event::with(['user', 'group'])->where('user_id', Auth::id())->get();
    }

    /**
     * Fetch all events for current year
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getReservationsByThisYear() : Collection
    {
        // Current year
        $startYear = date('Y-m-d H:i:s', strtotime('January 1st'));
        $endYear = date('Y-m-d H:i:s',strtotime('last day of this month'));;

        return Event::with('group')
                    ->whereBetween('start_date', [$startYear, $endYear])
                    ->whereBetween('end_date', [$startYear, $endYear])
                    ->get();
    }

    /**
     * Check group if already booked
     * 
     * @param int $roomId Group Id
     * @param string $startDate Start date
     * @param string $endDate End date
     * @return bool
     */
    public function checkIfAlreadyBooked(int $roomId, string $startDate, string $endDate) : bool
    {
        // Parse dates
        $startDate = date('Y-m-d H:i:s', strtotime($startDate));
        $endDate = date('Y-m-d H:i:s', strtotime($endDate));

        return Event::where('room_id', $roomId)
                    ->whereBetween('start_date', [$startDate, $endDate])
                    ->whereBetween('end_date', [$startDate, $endDate])
                    ->exists();
    }
}