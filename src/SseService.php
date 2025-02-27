<?php declare(strict_types=1);

namespace Murdej\Sse;

class SseService
{
    /**
     * @param mixed|null|callable $shutdownMessage
     * @param bool $sendShutdownMessageOnExit
     * @param bool|null $useJson ``
     */
    public function __construct(
        public mixed $shutdownMessage = null,
        public bool $sendShutdownMessageOnExit = true,
        public ?bool $useJson = null,
        public bool $autoOpen = true,
        public bool $clearOB = true,
    )
    {
    }

    public bool $isOpen = false;

    public function open()
    {
        if ($this->clearOB)
            while(@ob_end_clean());

        if ($this->sendShutdownMessageOnExit && $this->shutdownMessage) {
            register_shutdown_function(
                fn() => $this->close(),
            );
        }

        header('X-Accel-Buffering: no');
        header('Cache-Control: no-cache');
        header('Content-type: text/event-stream');

        $this->isOpen = true;
    }

    public function close()
    {
        if ($this->shutdownMessage) {
            $this->sendMessage($this->shutdownMessage);
        }
    }

    public function sendMessage(mixed $message): void
    {
        if (!$this->isOpen && $this->autoOpen) $this->open();
        if ($message instanceof \Closure)
            $message = $message();

        if ($this->useJson === true || ($this->useJson === null && !is_string($message))) {
            $message = json_encode($message, JSON_THROW_ON_ERROR);
        }

        echo "data: $message\n\n";
        flush();
    }
}