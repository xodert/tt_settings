<?php

namespace App\Actions\Settings;

use App\Data\ConfirmationDTO;
use App\Events\SettingEditToggled;
use App\Services\SettingService;
use App\Services\UserService;
use App\Services\UserSettingService;
use InvalidArgumentException;
use Lorisleiva\Actions\Concerns\AsAction;
use Throwable;

class ToggleSettingEditAction
{
    public function __construct(
        protected SettingService     $settingService,
        protected UserSettingService $userSettingService,
        protected UserService        $userService
    ) {}

    use AsAction;

    /**
     * @throws Throwable
     */
    public function handle(ConfirmationDTO $data): void
    {
        $settings = collect($this->userSettingService->getAllByKey('user_id',
            $data->user_id)->jsonSerialize())->pluck('setting_id');

        $setting = $this->settingService->firstByKeyOfAnyIds($settings->toArray(), 'key', $data->action_data['key']);

        throw_if(empty($setting), new InvalidArgumentException());

        $this->settingService->update($setting->id, [
            'editable' => !$setting->editable,
        ]);

        SettingEditToggled::dispatch($setting->id);
    }
}