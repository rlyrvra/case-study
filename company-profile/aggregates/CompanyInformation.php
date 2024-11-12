<?php

class CompanyInformation
{
    public function __construct(
        private readonly string $location         ,
        private readonly string $industry         ,
        private readonly string $businessType     ,
        private readonly int $size                ,
        private readonly string $history
    ) {
        
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getIndustry(): string
    {
        return $this->industry;
    }

    public function getBusinessType(): string
    {
        return $this->businessType;
    }

    public function getSize(): int
    {
        return $this->size;
    }
    public function getHistory(): string
    {
        return $this->history;
    }
}
