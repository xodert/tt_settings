<?php

namespace App\Actions\Settings;

use App\Data\SettingDTO;
use App\Services\DefaultSettingService;
use App\Services\SettingService;
use App\Services\UserSettingService;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Throwable;

class CreateDefaultUserSettingsAction
{
    public function __construct(
        protected DefaultSettingService $defaultSettingService,
        protected SettingService        $settingService,
        protected UserSettingService    $userSettingService,
    ) {}

    use AsAction;

    /**
     * @param int $userId
     * @return void
     * @throws Throwable
     */
    public function asJob(int $userId): void
    {
        $this->handle($userId);
    }

    /**
     * @param int $userId
     * @return void
     * @throws Throwable
     */
    public function handle(int $userId): void
    {
        $defaultSettings = $this->defaultSettingService->get(
            ['key', 'value', 'label', 'editable']
        );

        try {
            DB::beginTransaction();

            $settings = $defaultSettings->map(function (SettingDTO $setting) use ($userId) {
                $setting = $setting->jsonSerialize();

                $id = $this->settingService->create($setting)->id;

                return [
                    'setting_id' => $id,
                    'user_id' => $userId,
                ];
            });

            $this->userSettingService->insert($settings->toArray());

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();
            report($exception);
            throw $exception;
        }
    }
}
