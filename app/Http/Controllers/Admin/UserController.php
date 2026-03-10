<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::with('roles', 'enrollments.package')->paginate(20);
        return response()->json(UserResource::collection($users));
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user->update($request->only('name', 'email'));
        $user->syncRoles($request->validated('role'));
        return response()->json(new UserResource($user));
    }

    public function destroy(User $user): JsonResponse
    {
        $this->authorize('delete', $user);
        $user->delete();
        return response()->json(['message' => 'User deleted.']);
    }
}