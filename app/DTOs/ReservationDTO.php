<?php

namespace App\DTOs;

use Carbon\Carbon;

class ReservationDTO
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $reservationDate,
        public readonly string $reservationTime,
        public readonly int $guests,
        public readonly ?string $tableType = null,
        public readonly ?string $occasion = null,
        public readonly ?string $specialRequests = null,
        public readonly bool $emailUpdates = false,
        public readonly ?int $userId = null
    ) {}

    public function getFullName(): string
    {
        return trim($this->firstName . ' ' . $this->lastName);
    }

    public function getFormattedDate(): string
    {
        return Carbon::parse($this->reservationDate)->format('M d, Y');
    }

    public function getFormattedTime(): string
    {
        return Carbon::parse($this->reservationTime)->format('g:i A');
    }

    public function getDateTime(): Carbon
    {
        return Carbon::parse($this->reservationDate . ' ' . $this->reservationTime);
    }

    public function isValidDateTime(): bool
    {
        $dateTime = $this->getDateTime();
        return $dateTime->isFuture() && $this->isWithinBusinessHours();
    }

    public function isWithinBusinessHours(): bool
    {
        $time = Carbon::parse($this->reservationTime);
        $openingTime = Carbon::parse('06:00');
        $closingTime = Carbon::parse('22:00');

        return $time->between($openingTime, $closingTime);
    }

    public function toArray(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
            'reservation_date' => $this->reservationDate,
            'reservation_time' => $this->reservationTime,
            'guests' => $this->guests,
            'table_type' => $this->tableType,
            'occasion' => $this->occasion,
            'special_requests' => $this->specialRequests,
            'email_updates' => $this->emailUpdates,
            'user_id' => $this->userId
        ];
    }

    public static function fromRequest(array $requestData): self
    {
        return new self(
            firstName: $requestData['firstName'] ?? $requestData['first_name'] ?? '',
            lastName: $requestData['lastName'] ?? $requestData['last_name'] ?? '',
            email: $requestData['email'] ?? '',
            phone: $requestData['phone'] ?? '',
            reservationDate: $requestData['reservationDate'] ?? $requestData['reservation_date'] ?? '',
            reservationTime: $requestData['reservationTime'] ?? $requestData['reservation_time'] ?? '',
            guests: (int) ($requestData['guests'] ?? 1),
            tableType: $requestData['tableType'] ?? $requestData['table_type'] ?? null,
            occasion: $requestData['occasion'] ?? null,
            specialRequests: $requestData['specialRequests'] ?? $requestData['special_requests'] ?? null,
            emailUpdates: (bool) ($requestData['emailUpdates'] ?? $requestData['email_updates'] ?? false),
            userId: $requestData['user_id'] ?? null
        );
    }
}