<?php

namespace App\DTOs;

class CartItemDTO
{
    public int $item_id;
    public string $name;
    public ?string $brand;
    public ?string $image;
    public int $quantity;
    public ?string $url;

    public function __construct(array $data)
    {
        $this->item_id = (int) ($data['item_id'] ?? $data['id'] ?? 0);
        $this->name = trim((string) ($data['name'] ?? ''));
        $this->brand = $data['brand'] ?? null;
        $this->image = $data['image'] ?? null;
        $this->quantity = max(1, (int) ($data['quantity'] ?? $data['count'] ?? 1));
        $this->url = $data['url'] ?? null;
    }

    public static function fromArray(array $data): self
    {
        return new self($data);
    }

    public function toArray(): array
    {
        return [
            'item_id' => $this->item_id,
            'name' => $this->name,
            'brand' => $this->brand,
            'image' => $this->image,
            'quantity' => $this->quantity,
            'url' => $this->url,
        ];
    }
}
