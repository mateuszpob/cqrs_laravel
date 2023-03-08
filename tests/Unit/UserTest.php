<?php

namespace Tests\Unit;

use App\CommandBus;
use App\Commands\CreateUserCommand;
use App\Commands\DeleteUserCommand;
use App\Commands\EditUserCommand;
use App\Queries\UserByIdQuery;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    private CommandBus $commandBus;

    public function test_create_user(): void
    {
        $userParams = [fake()->email(), fake()->password(), fake()->firstName(), fake()->lastName()];
        $this->createUser($userParams);

        $query = new UserByIdQuery(1);
        $user = $query->getData();

        $this->assertEquals($userParams[0], $user['email']);
        $this->assertEquals($userParams[2], $user['first_name']);
        $this->assertEquals($userParams[3], $user['last_name']);
    }

    public function test_update_user(): void
    {
        $this->createUser([fake()->email(), fake()->password()]);

        $userParams = [fake()->email(), fake()->firstName(), fake()->lastName()];

        $this->commandBus = new CommandBus();
        $command = new EditUserCommand(1, ...$userParams);
        $this->commandBus->handle($command);

        $query = new UserByIdQuery(1);
        $user = $query->getData();

        $this->assertEquals($userParams, [$user['email'], $user['first_name'], $user['last_name']]);
    }

    public function test_delete_user(): void
    {
        $userParams = [fake()->email(), fake()->password(), fake()->firstName(), fake()->lastName()];
        $this->createUser($userParams);

        $query = new UserByIdQuery(1);
        $query->getData();

        $this->commandBus = new CommandBus();
        $command = new DeleteUserCommand(1);
        $this->commandBus->handle($command);

        $query = new UserByIdQuery(1);
        $this->expectException(ModelNotFoundException::class);
        $query->getData();
    }

    private function createUser($params)
    {
        $this->commandBus = new CommandBus();
        $command = new CreateUserCommand(...$params);
        $this->commandBus->handle($command);
    }
}
