<?php

namespace App\Http\Controllers;

use App\CommandBus;
use App\Commands\CreateUserCommand;
use App\Commands\DeleteUserCommand;
use App\Commands\EditUserCommand;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\EditProfileRequest;
use App\Models\User;
use App\Queries\UserByIdQuery;
use App\Queries\UserListQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

// use OpenApi\Attributes\OA\Get;

class UserController extends Controller
{
    public function __construct(
        private CommandBus $commandBus
    )
    {
    }


    #[OA\Post(tags: ["user"], summary: "Update profile", description: "Update your own profile", path: '/api/update-profile')]
    #[OA\Parameter(in: "header", name: "Accept", example: "application/json", required: true)]
    #[OA\RequestBody(required: true, description: "Pass user data", content: new OA\JsonContent(required: ["email"], properties: [
        new OA\Property(property: "first_name", type: "string", example: "John"),
        new OA\Property(property: "last_name", type: "string", example: "Doe"),
        new OA\Property(property: "email", type: "string", example: "user1@mail.com"),
        new OA\Property(property: "password", type: "string", example: "PassWord12345"),
        new OA\Property(property: "avatar", type: "file"),
    ]))]
    #[OA\Response(response: 200, description: 'Success')]
    #[OA\Response(response: 401, description: 'Unauthenticated', content: new OA\JsonContent(properties: [
        new OA\Property(property: "message", type: "string", example: "Unauthenticated"),
    ]))]
    public function updateProfile(EditProfileRequest $request)
    {
        return $this->updateUser($request, auth()->user()->id);
    }


    #[OA\Post(tags: ["user"], summary: "Update user", description: "Update user data", path: '/api/user/{id}')]
    #[OA\Parameter(in: "path", name: "id")]
    #[OA\RequestBody(required: true, description: "Pass user data", content: new OA\JsonContent(required: ["email"], properties: [
        new OA\Property(property: "first_name", type: "string", example: "John"),
        new OA\Property(property: "last_name", type: "string", example: "Doe"),
        new OA\Property(property: "email", type: "string", example: "user1@mail.com"),
        new OA\Property(property: "password", type: "string", example: "PassWord12345")
    ]))]
    #[OA\Response(response: 200, description: 'Success')]
    #[OA\Response(response: 401, description: 'Unauthenticated', content: new OA\JsonContent(properties: [
        new OA\Property(property: "message", type: "string", example: "Unauthenticated"),
    ]))]
    #[OA\Response(response: 404, description: 'User not found', content: new OA\JsonContent(properties: [
        new OA\Property(property: "message", type: "string", example: "Not found"),
    ]))]
    public function update(EditUserRequest $request, int $userId)
    {
        return $this->updateUser($request, $userId);
    }


    #[OA\Get(tags: ["user"], summary: "Get all users", description: "Get all users with offset and limit", path: '/api/users')]
    #[OA\Parameter(in: "query", name: "limit")]
    #[OA\Parameter(in: "query", name: "offset")]
    #[OA\Response(response: 200, description: 'Success', content: new OA\JsonContent(type: 'array', items: new OA\Items(properties: [
        new OA\Property(property: "first_name", type: "string", example: "John"),
        new OA\Property(property: "last_name", type: "string", example: "Doe"),
        new OA\Property(property: "email", type: "string", example: "user1@mail.com"),
    ])))]
    #[OA\Response(response: 401, description: 'Unauthenticated', content: new OA\JsonContent(properties: [
        new OA\Property(property: "message", type: "string", example: "Unauthenticated"),
    ]))]
    public function users(Request $request)
    {
        $limit = $request->has('limit') ? $request->get('limit') : 10;
        $offset = $request->has('offset') ? $request->get('offset') : 0;

        $query = new UserListQuery($limit, $offset);
        return response($query->getData(), 200);
    }


    #[OA\Delete(tags: ["user"], summary: "Delete user", description: "Delete user by id", path: '/api/user/{id}')]
    #[OA\Parameter(in: "path", name: "id")]
    #[OA\Response(response: 200, description: 'Success')]
    #[OA\Response(response: 401, description: 'Unauthenticated', content: new OA\JsonContent(properties: [
        new OA\Property(property: "message", type: "string", example: "Unauthenticated"),
    ]))]
    #[OA\Response(response: 404, description: 'User not found', content: new OA\JsonContent(properties: [
        new OA\Property(property: "message", type: "string", example: "Not found"),
    ]))]
    public function delete(int $userId)
    {
        $command = new DeleteUserCommand($userId);
        $this->commandBus->handle($command);

        return response()->json([
            'message' => 'success',
        ]);
    }

    private function updateUser(Request $request, int $userId)
    {
        $command = new EditUserCommand($userId, $request->email, $request->first_name, $request->last_name, $request->password, $request->avatar);
        $this->commandBus->handle($command);

        return response()->json([
            'message' => 'success',
        ]);
    }
}
