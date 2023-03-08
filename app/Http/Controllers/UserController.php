<?php

namespace App\Http\Controllers;

use App\CommandBus;
use App\Commands\CreateUserCommand;
use App\Commands\DeleteUserCommand;
use App\Commands\EditUserCommand;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\LoginRequest;
use App\Queries\UserByIdQuery;
use App\Queries\UserListQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(
        private CommandBus $commandBus
    )
    {
    }

    public function register(RegisterUserRequest $request)
    {
        $command = new CreateUserCommand($request->email, $request->password, $request->first_name, $request->last_name);
        $this->commandBus->handle($command);

        return response()->json([
            'message' => 'success',
        ], 201);
    }

    public function updateProfile(EditUserRequest $request)
    {
        return $this->updateUser($request, auth()->user()->id);
    }

    public function login(LoginRequest $request)
    {

        if (Auth::attempt($request->validated())) {
            Auth::user()->tokens()->delete();
            return response()->json([
                'token' => Auth::user()->createToken('authToken')->plainTextToken
            ]);
        }

        return response(null, 401);
    }

    public function update(EditUserRequest $request, int $userId)
    {
        return $this->updateUser($request, $userId);
    }

    public function users(Request $request)
    {
        $limit = $request->has('limit') ? $request->get('limit') : 10;
        $offset = $request->has('offset') ? $request->get('offset') : 0;

        $query = new UserListQuery($limit, $offset);
        return response($query->getData(), 200);
    }

    public function delete(int $userId)
    {
        $command = new DeleteUserCommand($userId);
        $this->commandBus->handle($command);

        return response()->json([
            'message' => 'success',
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
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
