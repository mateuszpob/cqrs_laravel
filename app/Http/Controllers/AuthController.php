<?php

namespace App\Http\Controllers;

use App\CommandBus;
use App\Commands\CreateUserCommand;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;



class AuthController extends Controller
{
    public function __construct(
        private CommandBus $commandBus
    )
    {
    }


    #[OA\Post(tags: ["auth"], summary: "Register", description: "Register new user", path: '/api/register')]
    #[OA\RequestBody(required: true, description: "Pass user data", content: new OA\JsonContent(required: ["email", "password"], properties: [
        new OA\Property(property: "first_name", type: "string", example: "John"),
        new OA\Property(property: "last_name", type: "string", example: "Doe"),
        new OA\Property(property: "email", type: "string", example: "user1@mail.com"),
        new OA\Property(property: "password", type: "string", example: "PassWord12345")
    ]))]
    #[OA\Response(response: 201, description: 'Success', content: new OA\JsonContent(type: 'array', items: new OA\Items(properties: [
        new OA\Property(property: "message", type: "string", example: "Success"),
    ])))]
    #[OA\Response(response: 422, description: 'Wrong email', content: new OA\JsonContent(properties: [
        new OA\Property(property: "email", type: "string", example: "The email field is required"),
        new OA\Property(property: "password", type: "string", example: "The password field is required")
    ]))]
    public function register(RegisterUserRequest $request)
    {
        $command = new CreateUserCommand($request->email, $request->password, $request->first_name, $request->last_name);
        $this->commandBus->handle($command);

        return response()->json([
            'message' => 'success',
        ], 201);
    }



    #[OA\Post(tags: ["auth"], summary: "Login user", description: "Login by email and password and get token", path: '/api/login')]
    #[OA\RequestBody(required: true, description: "Pass user data", content: new OA\JsonContent(required: ["email", "password"], properties: [
        new OA\Property(property: "email", type: "string", example: "user1@mail.com"),
        new OA\Property(property: "password", type: "string", example: "PassWord12345")
    ]))]
    #[OA\Response(response: 200, description: 'Success', content: new OA\JsonContent(type: 'array', items: new OA\Items(properties: [
        new OA\Property(property: "token", type: "string", example: "16|vfXI2soVAlaYJGxyM8dFJ5Olp0ojBgL6GRiDs9yv"),
    ])))]
    #[OA\Response(response: 422, description: 'Wrong credentials response', content: new OA\JsonContent(properties: [
        new OA\Property(property: "message", type: "string", example: "Sorry, wrong email address or password"),
    ]))]
    public function login(LoginRequest $request)
    {

        if (Auth::attempt($request->validated())) {
            Auth::user()->tokens()->delete();
            return response()->json([
                'token' => Auth::user()->createToken('authToken')->plainTextToken
            ]);
        }

        return response(["message" => "Sorry, wrong email address or password"], 422);
    }



    #[OA\Post(tags: ["auth"], summary: "Logout", description: "Logout user", path: '/api/logout')]
    #[OA\Response(response: 200, description: 'Success')]
    #[OA\Response(response: 401, description: 'Unauthenticated', content: new OA\JsonContent(properties: [
        new OA\Property(property: "message", type: "string", example: "Unauthenticated"),
    ]))]
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'success',
        ]);
    }
}
