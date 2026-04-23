<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(GetUserRequest $request){
        $users = User::search($request->search)->latest()->paginate($request->limit ?? 10);

        return ApiResponse::success(
            new PaginatedResource($users, UserResource::class),
            'Users List'
        );
    }
    public function store(StoreUserRequest $request){
        $user = User::create($request->validated());

        return ApiResponse::success(
            new UserResource($user),
            'User created successfully',
            Response::HTTP_CREATED,
        );
    }

    public function show(string $id){
        $user = User::find($id);

        if (!$user) {
            return ApiResponse::error(
                'User not found',
                Response::HTTP_NOT_FOUND,
            );
        }

        return ApiResponse::success(
            new UserResource($user),
            'User Details'
        );
    }

    public function update(UpdateUserRequest $request, string $id){
        $user = User::find($id);

        if (!$user) {
            return ApiResponse::error(
                'User not found',
                Response::HTTP_NOT_FOUND,
            );
        }

        $user->update($request->validated());

        return ApiResponse::success(
            new UserResource($user),
            'User updated successfully'
        );
    }

    public function destroy(string $id){
        $user = User::find($id);

        if (!$user) {
            return ApiResponse::error(
                'User not found',
                Response::HTTP_NOT_FOUND,
            );
        }

        $user->delete();

        return ApiResponse::success(
            null,
            'User deleted successfully'
        );
    }
}
