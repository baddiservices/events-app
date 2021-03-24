<?php

namespace App\Repositories;

use App\Models\Group;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Torann\LaravelRepository\Repositories\AbstractRepository;

class RoomsRepository extends AbstractRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    protected $model = \App\Models\Group::class;

    /**
     * Fetch all groups with user relationship
     * 
     * @return \Illuminate\Support\Collection
     */
    public function allWithUser() : Collection
    {
        return Group::with('user')->where('user_id', Auth::id())->get();
    }
}