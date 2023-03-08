<?php

namespace App;

use Illuminate\Support\Facades\App;
use ReflectionClass;
use Illuminate\Support\Facades\Log;

class CommandBus
{
    public function handle($command)
    {
        // resolve handler
        $reflection = new ReflectionClass($command);
        $handlerName = str_replace("Command", "Handler", $reflection->getShortName());
        $handlerName = str_replace($reflection->getShortName(), $handlerName, $reflection->getName());
        $handler = App::make($handlerName);

        Log::info("[CommandBus] " .  $reflection->getShortName());

        // invoke handler
        $handler($command);
    }
}
