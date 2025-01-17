<?php

namespace App\Repositories;

use App\Exceptions\DataNotFoundException;
use App\Models\Client\ClientReader;
use App\Models\Eloquent\Client as ClientEloquent;

final class Client
{
    /**
     * @throws DataNotFoundException
     */
    public function show(string $uid): ClientReader
    {
        $client = ClientEloquent::where("uid", $uid)?->first();
        if ($client === null) {
            throw new DataNotFoundException("");
        }

        return $this->convert($client);
    }

    public function store(string $uid): ClientReader
    {
        $client = ClientEloquent::where("uid", $uid)?->first();
        if ($client === null) {
            $client = new ClientEloquent();
            $client->uid = $uid;
            $client->save();
        }

        return $this->convert($client);
    }

    public function delete(string $uid): void
    {
        $client = ClientEloquent::where("uid", $uid)?->first();
        if ($client === null) {
            throw new DataNotFoundException("");
        }

        $client->delete();
    }

    private function convert(ClientEloquent $eloquent): ClientReader
    {
        return new ClientReader($eloquent->id, $eloquent->uid);
    }
}
