<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\GroupRepository;
use App\Repositories\TeamRepository;
use App\Http\Resources\TeamResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TeamController extends Controller 
{
    /**
     * The GroupRepository implementation
     *
     * @var App\Repositories\GroupRepository
     */
    protected $groups;

    /**
     * The TeamRepository implementation
     *
     * @var App\Repositories\TeamRepository
     */
    protected $teams;

    /**
     * Create team controller
     *
     * @param GroupRepository $groups
     * @param TeamRepository $teams
     */
    public function __construct(GroupRepository $groups, TeamRepository $teams)
    {
        $this->groups = $groups;
        $this->teams = $teams;
    }

    public function index(Request $request, int $groupId)
    {

    }

    /**
     * Create team in the group
     *
     * @param Request $request
     * @param integer $groupId
     * @return void
     */
    public function store(Request $request, int $groupId)
    {
        $this->validate($request, [
            'name' => ['required']
        ]);

        $user = $request->user();
        $group = $this->groups->findById($groupId);

        if ($group === null) {
            throw new NotFoundHttpException(sprintf('Group %s is not found', $groupId));
        } 

        $team = $this->teams->create($group, $user, $request->input('name'));

        if ($team) {
            return new TeamResource($team);
        }

        throw new BadRequestHttpException('Unable to create team');
    }

    public function show(int $groupId, int $teamId)
    {

    }

    public function update(int $groupId, int $teamId)
    {

    }

    public function destroy(int $groupId, int $teamId)
    {

    }
    
}