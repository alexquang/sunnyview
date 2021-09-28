<?php

namespace Tests\Unit\Models;

use App\Models\AuthRole;
use App\Models\AuthUser;
use App\Models\Project;
use Tests\TestCase;

class AuthUserTest extends TestCase
{
    public function test_assigned_roles_can_be_listed_via_relation()
    {
        $user = $this->makeUser();

        $user->roles()->attach($role = AuthRole::factory()->create());

        $this->assertEquals($user->roles->count(), 1);

        $this->assertEquals($user->roles->first()->name, $role->name);
    }

    public function test_assigned_projects_can_be_listed_via_relation()
    {
        $user = AuthUser::factory()->create();

        $user->projects()->attach($project = Project::factory()->create());

        $this->assertEquals($user->projects->count(), 1);

        $this->assertEquals($user->projects->first()->name, $project->name);
    }

    public function test_assigned_permissions_can_be_listed_via_relation()
    {
        // TODO
        $this->assertTrue(true);
    }
}
