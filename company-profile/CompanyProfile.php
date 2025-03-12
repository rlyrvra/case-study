<?php
require_once __DIR__ . '/../includes/Helper.php';
require_once __DIR__ . '/../includes/enums/ActionResult.php';
require_once __DIR__ . 'CompanyInformation.php';

class CompanyProfile
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function updateCompanyInformation(CompanyInformation $companyInformation): ActionResult{
        $query = '
            UPDATE company_profile
            SET
                location            = :location              ,
                industry            = :industry              ,
                business_type       = :business_type         ,
                size                = :size                  ,
                history             = :history
        ';

        try {
            $this->pdo->beginTransaction();

            $statement = $this->pdo->prepare($query);

            $statement->bindValue(':location'              , $companyInformation->getLocation()            , Helper::getPdoParameterType($companyInformation->getLocation()            ));
            $statement->bindValue(':industry'              , $companyInformation->getIndustry()            , Helper::getPdoParameterType($companyInformation->getIndustry()            ));
            $statement->bindValue(':business_type'         , $companyInformation->getBusinessType()        , Helper::getPdoParameterType($companyInformation->getBusinessType()        ));
            $statement->bindValue(':size'                  , $companyInformation->getSize()                , Helper::getPdoParameterType($companyInformation->getSize()                ));
            $statement->bindValue(':history'               , $companyInformation->getHistory()             , Helper::getPdoParameterType($companyInformation->getHistory()             ));

            $statement->execute();

            $this->pdo->commit();

            return ActionResult::SUCCESS;

        } catch (PDOException $exception) {
            $this->pdo->rollBack();

            error_log('Database Error: An error occurred while updating company profile. ' .
                      'Exception: ' . $exception->getMessage());

            return ActionResult::FAILURE;
        }
    }
    public function fetchCompanyInformation(): ActionResult|array 
    {
        $query = "
        SELECT
        location,
        industry,
        business_type,
        size,
        history
        FROM
        company_profile
        WHERE 1
        ";

        try 
        {
            $statement = $this->pdo->prepare($query);

            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $exception) 
        {
            error_log("Database Error: An error occurred while fetching the company profile records. " .
            "Exception: {$exception->getMessage()}");

            return ActionResult::FAILURE;
        }
    }
}