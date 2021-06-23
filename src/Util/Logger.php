<?php

/**
 * This file is part of Temporal package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Workshop\Util;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Temporal\Workflow;

/**
 * Sample logger for writing into stderr.
 */
class Logger implements LoggerInterface
{
    use LoggerTrait;

    public function log($level, $message, array $context = [])
    {
        try {
            if (Workflow::isReplaying()) {
                return;
            }
        } catch (\Throwable $e) {
            // outside of workflow
        }

        file_put_contents('php://stderr', sprintf('[%s] %s', $level, $message));
    }

    public static function create(): self
    {
        return new self();
    }
}