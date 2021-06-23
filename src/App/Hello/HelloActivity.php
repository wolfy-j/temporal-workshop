<?php


namespace Workshop\App\Hello;

use Psr\Log\LoggerInterface;
use Temporal\Common\Uuid;
use Temporal\Exception\Failure\ApplicationFailure;
use Workshop\Util\Logger;

class HelloActivity implements DemoActivityInterface
{
    private LoggerInterface $logger;

    public function __construct()
    {
        $this->logger = new Logger();
    }

    public function reserveCar(string $name): string
    {
        $this->log('reserve car for "%s"', $name);
        throw new ApplicationFailure('booking failed', 'BookingFailure', true);

        return Uuid::v4();
    }

    public function bookFlight(string $name): string
    {
        // uncommenting this line will trigger the saga compensation
        // throw new ApplicationFailure('booking failed', 'BookingFailure', true);

        $this->log('book flight for "%s"', $name);

        return Uuid::v4();
    }

    public function bookHotel(string $name): string
    {
        $this->log('book hotel for "%s"', $name);

        return Uuid::v4();
    }

    public function cancelFlight(string $reservationID, string $name): string
    {
       // throw new \Error("npo flights");

        $this->log('cancel flight reservation "%s" for "%s"', $reservationID, $name);

        return Uuid::v4();
    }

    public function cancelHotel(string $reservationID, string $name): string
    {
        $this->log('cancel hotel reservation "%s" for "%s"', $reservationID, $name);

        return Uuid::v4();
    }

    public function cancelCar(string $reservationID, string $name): string
    {
        $this->log('cancel car reservation "%s" for "%s"', $reservationID, $name);

        return Uuid::v4();
    }

    /**
     * @param string $message
     * @param mixed ...$arg
     */
    private function log(string $message, ...$arg)
    {
        // by default all error logs are forwarded to the application server log and docker log
        $this->logger->debug(sprintf($message, ...$arg));
    }
}