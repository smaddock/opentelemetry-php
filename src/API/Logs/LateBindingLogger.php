<?php

declare(strict_types=1);

namespace OpenTelemetry\API\Logs;

use Closure;
use OpenTelemetry\Context\ContextInterface;

class LateBindingLogger implements LoggerInterface
{
    private ?LoggerInterface $logger = null;

    /** @param Closure(): LoggerInterface $factory */
    public function __construct(
        private readonly Closure $factory,
    ) {
    }

    public function emit(LogRecord $logRecord): void
    {
        ($this->logger ??= ($this->factory)())->emit($logRecord);
    }

    public function isEnabled(?ContextInterface $context = null, ?int $severityNumber = null, ?string $eventName = null): bool
    {
        return true;
    }
}
