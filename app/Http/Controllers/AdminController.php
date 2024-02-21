<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Response\MessageResponse;
use App\Actions\CreateAdminAction;
use App\Http\Resources\Admin\AdminResource;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Resources\Admin\AdminUserResource;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::all();

        return AdminResource::collection($admins);
    }

    public function create(CreateAdminRequest $request, CreateAdminAction $action)
    {
        return $action->handle($request);
    }

    public function show(User $admin)
    {
        return new MessageResponse(AdminUserResource::loginData($admin), success: true);
    }

    public function destroy(User $admin)
    {
        $admin = $admin->delete();

        return new MessageResponse([], success: $admin ?? false);
    }
}
