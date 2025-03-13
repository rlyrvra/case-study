<?php

class CompanyInformation
{
    private ?int $id = null;              
    public string $name = '';            
    public string $date_established = '';
    public string $img_location = '';     
    public string $history = '';          
    public string $industry = '';         
    public string $business_type = '';    
    public string $size = '';             
    public ?int $employee_count = null;      
    public string $address = '';          
    public string $phone = '';            
    public string $email = '';            
    public string $website = '';
    public string $mission = '';          
    public string $vision = '';           
    public string $company_values = '';   
    public string $policies = '';         
    public string $compliance = '';       
    public string $notes = '';           
    public function __construct(
        
    ) {
        
    }
    
    public static function getTableName(): string {
        return 'company_profile'; 
    }


    public function getId(): ?int {
        return $this->id;
    }


    public function setId(?int $id): void {
        $this->id = $id;
    }
}

