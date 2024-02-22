<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Handlers\Safenet;
use Illuminate\Http\Request;
use App\Response\MessageResponse;
use App\Actions\CreateAdminAction;
use App\Actions\UpdateAdminAction;
use App\Http\Resources\Admin\AdminResource;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Http\Resources\Admin\AdminUserResource;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        return Safenet::run(function () use ($request) {
            $perPage = $request?->perPage ?? 10;

            $admins = User::paginate($perPage);

            return MessageResponse::paginated(
                AdminResource::collection($admins),
                success: true
            );
        });
    }

    public function create(CreateAdminRequest $request, CreateAdminAction $action)
    {
        return Safenet::run(fn () => $action->handle($request));
    }

    public function show(User $admin)
    {
        return Safenet::run(fn () => new MessageResponse(AdminUserResource::loginData($admin), success: true));
    }

    public function update(UpdateAdminRequest $request, UpdateAdminAction $action)
    {
        return Safenet::run(fn () => $action->handle($request->payload()));
    }

    public function destroy(User $admin)
    {
        return Safenet::run(function () use ($admin) {
            $admin = $admin->delete();

            return MessageResponse::success(success: $admin ?? false);
        });
    }
}
