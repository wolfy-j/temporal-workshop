<?php

namespace Workshop\App\Hello;

use Temporal\Activity\ActivityInterface;

#[ActivityInterface(prefix: "demo_activity.")]
interface DemoActivityInterfac2e
{
    public function hello(string $name): string;

    public function slow(string $name): string;
}