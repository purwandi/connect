<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;
use App\Repositories\GroupRepository;
use Illuminate\Http\Request;

class GroupController extends Controller 
{
    /**
     * The GroupRepository implementation.
     *
     * @var App\Repositories\GroupRepository
     */
    protected $groups;

    /**
     * Create group controller
     *
     * @param GroupRepository $groups
     */
    public function __construct(GroupRepository $groups)
    {
        $this->groups = $groups;
    }

    /**
     * Create group
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:groups',
        ]);

        $group = $this->groups->create(
            $request->user(), 
            $request->input('name'), 
            $request->input('description')
        );
        
        if ($group) {
            return new GroupResource($group);
        }
        
        return response()->json([], 422);
    }
}