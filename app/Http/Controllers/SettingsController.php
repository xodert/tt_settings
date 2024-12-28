<?php

namespace App\Http\Controllers;

use App\Events\SettingEditToggled;
use App\Http\Requests\SettingUpdateRequest;
use App\Services\SettingService;
use App\Services\UserService;
use App\Services\UserSettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct(
        protected SettingService     $settingService,
        protected UserSettingService $userSettingService,
        protected UserService        $userService
    ) {}

    public function index(Request $request)
    {
        $user = $request->user();

        $settingsIds = $this->userSettingService->getAllIdsByUserId($user->id);

        $settings = $this->settingService->findMany($settingsIds);

        return inertia('Profile/Settings/Index', [
            'settings' => $settings,
            'confirmation_types' => $this->userService->getAvailableConfirmationTypes($user->id)
        ]);
    }

    /**
     * @param SettingUpdateRequest $request
     * @param int                  $id
     * @return JsonResponse
     */
    public function update(SettingUpdateRequest $request, int $id)
    {
        $user = $request->user();

        $setting = $this->settingService->firstById($id);

        if (empty($setting)) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Setting is not found'
            ], 404);
        }

        $userSetting = $this->userSettingService->firstByKey('setting_id', $id);

        if (empty($userSetting) | $userSetting->user_id !== $user->id) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Not allowed.'
            ], 403);
        }

        $this->settingService->update($id, [
            'editable' => false,
            'value' => ['value' => $request->input('value')],
        ]);

        SettingEditToggled::dispatch($id);

        return response()->json([
            'success' => true,
            'data' => true
        ]);
    }
}
