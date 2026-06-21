<?php

namespace App\Services;

use App\DTOs\QuotationDTO;
use App\Models\Quotation;
use App\Repositories\QuotationRepository;

class QuotationService
{
    public function __construct(
        protected QuotationRepository $quotationRepository,
        protected EmailService $emailService,
    ) {
    }

    public function createQuotation(QuotationDTO $quotationDTO): Quotation
    {
        $quotation = $this->quotationRepository->create($quotationDTO->toArray());

        $this->emailService->sendQuotationEmails($quotation);

        return $quotation;
    }

    public function findQuotation(int $id): ?Quotation
    {
        return $this->quotationRepository->find($id);
    }
}
