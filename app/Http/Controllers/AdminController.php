<?php


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
            $admins = User::query()->latest()
                ->paginate($perPage = $request->query('perPage', 10));

            return MessageResponse::success(
                [
                    "data" => AdminResource::collection($admins),
                    "meta" => getPaginatedData($admins, $perPage)
                ],
                success: true,
            );
        });
    }

    public function create(CreateAdminRequest $request, CreateAdminAction $action)
    {
        return Safenet::run(fn () => $action->handle($request->payload()));
    }

    public function show(User $externalId)
    {
        return Safenet::run(fn () => MessageResponse::success(AdminUserResource::loginData($externalId)));
    }

    public function update(UpdateAdminRequest $request, UpdateAdminAction $action, User $externalId)
    {
        return Safenet::run(fn () => $action->handle($externalId, $request->payload()));
    }

    public function destroy(User $externalId)
    {
        return Safenet::run(function () use ($externalId) {
            $externalId = $externalId->delete();

            return MessageResponse::success(success: $externalId ?? false);
        });
    }
}
