<?php

namespace App\DTOs;

class QuotationDTO
{
    public string $name;
    public ?string $company_name;
    public string $email;
    public string $mobile;
    public int $no_days;
    public string $pickup_date;
    public string $location;
    public array $equipments;
    public ?string $notes;

    public function __construct(array $data)
    {
        $this->name = trim((string) ($data['name'] ?? ''));
        $this->company_name = isset($data['company_name']) ? trim((string) $data['company_name']) : null;
        $this->email = trim((string) ($data['email'] ?? ''));
        $this->mobile = trim((string) ($data['mobile'] ?? ''));
        $this->no_days = max(1, (int) ($data['no_days'] ?? 1));
        $this->pickup_date = trim((string) ($data['pickup_date'] ?? ''));
        $this->location = trim((string) ($data['location'] ?? ''));
        $this->equipments = array_map(fn ($item) => CartItemDTO::fromArray((array) $item)->toArray(), $data['equipments'] ?? []);
        $this->notes = isset($data['notes']) ? trim((string) $data['notes']) : null;
    }

    public static function fromArray(array $data): self
    {
        return new self($data);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'company_name' => $this->company_name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'no_days' => $this->no_days,
            'pickup_date' => $this->pickup_date,
            'location' => $this->location,
            'equipments' => $this->equipments,
            'notes' => $this->notes,
        ];
    }
}
