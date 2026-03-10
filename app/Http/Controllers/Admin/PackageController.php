<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePackageRequest;
use App\Http\Resources\PackageResource;
use App\Models\Package;
use Illuminate\Http\JsonResponse;

class PackageController extends Controller
{
    public function index(): JsonResponse
    {
        $packages = Package::with('courses')->paginate(20);
        return response()->json(PackageResource::collection($packages));
    }

    public function update(UpdatePackageRequest $request, Package $package): JsonResponse
    {
        $this->authorize('update', $package);
        $package->update($request->validated());
        return response()->json(new PackageResource($package));
    }
}