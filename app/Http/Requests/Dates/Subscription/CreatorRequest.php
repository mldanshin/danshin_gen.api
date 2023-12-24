<?php

namespace App\Http\Requests\Dates\Subscription;

use App\Http\Requests\Request;
use App\Models\Dates\Subscription\Creator as CreatorModel;

final class CreatorRequest extends Request
{
    public function getModel(): ?CreatorModel
    {
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);

        if (empty($data['update_id'])) {
            return null;
        } else {
            return new CreatorModel(
                $this->getMessage($data["message"]),
                $this->getChat($data["message"]),
                $this->getUserName($data["message"])
            );
        }
    }

    private function getMessage(array $data): string
    {
        return $data["text"];
    }

    private function getChat(array $data): string
    {
        return $data["chat"]["id"];
    }

    private function getUserName(array $data): ?string
    {
        return $data["chat"]["username"];
    }
}
