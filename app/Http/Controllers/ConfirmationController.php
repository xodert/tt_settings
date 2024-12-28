<?php

namespace App\Http\Controllers;

use App\Actions\Confirmation\ChangeConfirmationStatusAction;
use App\Actions\Confirmation\ConfirmationResolveAction;
use App\Enums\Confirmation\ConfirmationStatusEnum;
use App\Http\Requests\CheckCodeRequest;
use App\Http\Requests\SendCodeRequest;
use App\Services\ConfirmationService;
use App\Services\ConfirmationTypeService;
use App\Services\SourceService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Throwable;

class ConfirmationController extends Controller
{
    public function __construct(
        protected ConfirmationService     $confirmationService,
        protected ConfirmationTypeService $confirmationTypeService,
        protected SourceService           $sourceService,
        protected UserService             $userService,
    ) {}

    /**
     * @param SendCodeRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function sendCode(SendCodeRequest $request)
    {
        $userId = $request->user()->id;

        $confirmationType = $request->input('confirmation_type');

        $this->checkIfAllowed($userId, $confirmationType);

        $code = sprintf('%04d', fake()->numberBetween(0, 9999));

        $confirmationTypeId = $this->confirmationTypeService->firstByKey('alias',
            $confirmationType)->id;

        $sourceId = $this->sourceService->firstByKey('alias', $request->input('source'))->id;

        $this->confirmationService->create([
            'confirmation_type_id' => $confirmationTypeId,
            'source_id' => $sourceId,
            'user_id' => $userId,
            'code' => $code,
            'action' => $request->input('action'),
            'action_data' => $request->input('action_data'),
            'expires_at' => now()->addMinutes(2),
        ]);

        return response()->json([
            'success' => true,
            'data' => true
        ]);
    }

    /**
     * @throws Throwable
     */
    private function checkIfAllowed(int $userId, string $confirmationTypeAlias): void
    {
        $allowed = $this->userService->getAvailableConfirmationTypes($userId)
            ->pluck('alias')
            ->filter(fn($item) => $item === $confirmationTypeAlias);

        throw_if(empty($allowed), new BadRequestException('Данный способ подтверждения не привязан к вашему аккаунту'));
    }

    /**
     * @param CheckCodeRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function checkCode(CheckCodeRequest $request)
    {
        $userId = $request->user()->id;

        $source = $request->input('source');
        $confirmationType = $request->input('confirmation_type');

        $confirmationTypeId = $this->confirmationTypeService->firstByKey('alias',
            $confirmationType)->id;

        $this->checkIfAllowed($userId, $confirmationType);

        $sourceId = $this->sourceService->firstByKey('alias', $request->input('source'))->id;

        $confirmation = $this->confirmationService->checkCode(...[
            'userId' => $userId,
            'confirmationId' => $confirmationTypeId,
            'sourceId' => $sourceId,
            'code' => $request->input('code'),
            'action' => $request->input('action'),
        ]);

        if (empty($confirmation)) {
            return response()->json([
                'success' => false,
                'message' => 'Неправильный код'
            ], 400);
        }

        if ($confirmation->expires_at < now()->subMinutes(ConfirmationStatusEnum::EXPIRED_TIME)) {
            ChangeConfirmationStatusAction::dispatch($confirmation->id, ConfirmationStatusEnum::EXPIRED);

            return response()->json([
                'success' => false,
                'message' => 'Время действия подтверждения вышло'
            ], 400);
        }

        ChangeConfirmationStatusAction::dispatchSync($confirmation->id, ConfirmationStatusEnum::RESOLVING);

        ConfirmationResolveAction::dispatch($confirmation->id);

        return response()->json([
            'success' => true,
            'data' => true
        ]);
    }
}
