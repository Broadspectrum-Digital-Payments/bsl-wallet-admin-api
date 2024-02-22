<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Response\MessageResponse;
use App\Actions\CreateAdminAction;
use App\Actions\UpdateAdminAction;
use App\Http\Resources\Admin\AdminResource;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Http\Resources\Admin\AdminUserResource;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::paginate(15);

        return MessageResponse::paginated(
            AdminResource::collection($admins),
            success: true
        );
    }

    public function create(CreateAdminRequest $request, CreateAdminAction $action)
    {
        return $action->handle($request);
    }

    public function show(User $admin)
    {
        return new MessageResponse(AdminUserResource::loginData($admin), success: true);
    }

    public function update(UpdateAdminRequest $request, UpdateAdminAction $action)
    {
        return $action->handle($request->payload());
    }

    public function destroy(User $admin)
    {
        $admin = $admin->delete();

        return new MessageResponse([], success: $admin ?? false);
    }
}
