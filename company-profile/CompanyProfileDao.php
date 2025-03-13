<?php
require_once __DIR__ . '/../includes/Helper.php';
require_once __DIR__ . '/../includes/enums/ActionResult.php';
require_once __DIR__ . '/CompanyInformation.php';

enum SelectorMode: int
{
    case SELECT          = 0;
    case UPDATE          = 1;
}


class CompanyProfileDao
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function updateCompanyInformation(
        ?CompanyInformation $companyInformation = null, 
        ?array $filterCriteria = null
    ): array|ActionResult {

        $queryParts = [];
        $whereParts = [];
        $params = [];

        if ($companyInformation !== null) {
            $queryParts = $this->buildSelectParts($queryParts, $companyInformation, SelectorMode::UPDATE);
        }
    
        if ($filterCriteria !== null && $companyInformation !== null) {
            $paramsAndWhere = $this->buildWhereParts($whereParts, $filterCriteria, $companyInformation);
            $whereParts = $paramsAndWhere['whereParts'];
            $params = array_merge($params, $paramsAndWhere['params']);  // Merge parameters for WHERE
        }
    
        $query = 'UPDATE company_profile SET ' . implode(", ", $queryParts);

        // Add WHERE conditions only if filtering
        if (!empty($whereParts)) {
            $query .= ' WHERE ' . implode(" ", $whereParts);
        }

        // Throw error
        if (empty($queryParts)) {
            throw new InvalidArgumentException("No valid fields provided for update.");
        }

        // print_r($whereParts);
        // print_r($params);

        // echo "<pre> $query </pre>";


        
        try {
            $this->pdo->beginTransaction();
    
            $statement = $this->pdo->prepare($query);
    
            // Bind parameters only if filtering
            $params = array_merge($params, $this->buildParams($params, $companyInformation));
            // print_r($params);
            foreach ($params as $param => $value) {
                $statement->bindValue($param, $value, Helper::getPdoParameterType($value));
            }
    
            $statement->execute();

            $this->pdo->commit();
    
            return ActionResult::SUCCESS;
        } catch (PDOException $exception) {
            $this->pdo->rollBack();
    
            error_log('Database Error: An error occurred while updating company profile. ' .
                      'Exception: ' . $exception->getMessage());
            echo $exception->getMessage();
            return ActionResult::FAILURE;
        }
    }

    public function fetchCompanyInformation(
        object|array|null $objects = null, 
        ?array $filterCriteria = null
    ): array|ActionResult {
    
        $queryParts = [];
        $whereParts = [];
        $params = [];
    
        // Ensure $objects is an array
        if ($objects !== null && !is_array($objects)) {
            $objects = [$objects]; // Convert single object to an array
        }
    
        // If at least one object exists, process them
        if (!empty($objects)) {
            foreach ($objects as $object) {
                if (!method_exists($object, 'getTableName')) {
                    throw new InvalidArgumentException("Each object must have a getTableName() method.");
                }
    
                $queryParts = $this->buildSelectParts($queryParts, $object);
            }
        }
    
        // If no objects, select everything from company_profile
        if (empty($objects)) {
            $queryParts[] = "company_profile.*";
            if ($filterCriteria !== null){
                $companyInformation = new CompanyInformation();
                $paramsAndWhere = $this->buildWhereParts($whereParts, $filterCriteria, $companyInformation);
                $whereParts = array_merge($whereParts, $paramsAndWhere['whereParts']);
                $params = array_merge($params, $paramsAndWhere['params']);
            }
        }
    
        // Process WHERE filters
        if ($filterCriteria !== null) {
            foreach ($objects as $object) {
                $paramsAndWhere = $this->buildWhereParts($whereParts, $filterCriteria, $object);
                $whereParts = array_merge($whereParts, $paramsAndWhere['whereParts']);
                $params = array_merge($params, $paramsAndWhere['params']);
            }
        }


    
        // Build base query
        $query = 'SELECT ' . implode(", ", $queryParts);
    
        // Add FROM table names dynamically
        $tables = [];
        if (!empty($objects)) {
            foreach ($objects as $object) {
                $tableName = $object::getTableName();
                $tables[] = "$tableName AS $tableName";
            }
        }
    
        if (!empty($tables)) {
            $query .= " FROM " . implode(", ", $tables);
        } else {
            $query .= " FROM company_profile AS company_profile";
        }
    
        // Add WHERE conditions
        if (!empty($whereParts) && $filterCriteria !== null) {
            $query .= ' WHERE ' . implode(" ", $whereParts);
        }
    
        // Throw error if no valid fields
        if (empty($queryParts)) {
            throw new InvalidArgumentException("No valid fields provided for selection.");
        }
    
        // print_r($whereParts);
        // print_r($params);

        // echo "<pre> $query </pre>";



    
        try {
            $statement = $this->pdo->prepare($query);
    
            // Bind parameters only if filtering
            foreach ($params as $param => $value) {
                $statement->bindValue($param, $value, Helper::getPdoParameterType($value));
            }
    
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
    
        } catch (PDOException $exception) {
            error_log('Database Error: ' . $exception->getMessage());
            echo $exception->getMessage();
            return ActionResult::FAILURE;
        }
    }
    

    // Handling SELECT Fields from $object dynamically
    private function buildSelectParts(
        array $queryParts, 
        object $object,
        SelectorMode $selector = SelectorMode::SELECT
    ): array {
        // Ensure the object has a method to get the table name
        if (!method_exists($object, 'getTableName')) {
            throw new InvalidArgumentException("Object must have a getTableName() method.");
        }
    
        $tableName = $object::getTableName(); // Get table name dynamically
    
        // Use reflection to get the object's public properties
        $reflection = new ReflectionClass($object);
        $properties = $reflection->getProperties();
    
        foreach ($properties as $property) {
            if ($property->isPublic()) {
                $propertyName = $property->getName();
                $value = $object->$propertyName;
    
                // Add only non-empty properties to SELECT/UPDATE clause
                if (!empty($value)) {
                    switch ($selector) {
                        case SelectorMode::SELECT:
                            $queryParts[] = "$tableName.$propertyName AS $propertyName";
                            break;
                        case SelectorMode::UPDATE:
                            $queryParts[] = "$propertyName = :$propertyName";
                            break;
                    }
                }
            }
        }
        return $queryParts;
    }

    // Handling WHERE Fields from $object dynamically
    private function buildWhereParts(
        array $whereParts, 
        array $filterCriteria, 
        object $object): array {
        $params = [];
    
        // Ensure the object has a method to get the table name
        if (!method_exists($object, 'getTableName')) {
            throw new InvalidArgumentException("Object must have a getTableName() method.");
        }
        $tableName = $object::getTableName(); // Get table name dynamically
    
        // Use reflection to get valid properties from the object
        $reflection = new ReflectionClass($object);
        $validProperties = array_map(fn($prop) => $prop->getName(), $reflection->getProperties());
    
        foreach ($filterCriteria as $index => $condition) {
            $property = $condition["column"] ?? null;
            $operator = $condition["operator"] ?? "="; // Default to "="
            $value = $condition["value"] ?? null;
            $boolean = strtoupper($condition["boolean"] ?? "AND"); // Default to "AND"
            $encrypted = !empty($condition["encrypted"]) && $condition["encrypted"] === true;
    
            // Ensure the property exists in the object
            if (!in_array($property, $validProperties, true)) {
                throw new InvalidArgumentException("Invalid property: $property in " . get_class($object));
                continue;
            }
    
            // Ensure operator is valid
            $allowedOperators = ["=", "!=", ">", "<", ">=", "<=", "LIKE", "IN"];
            if (!in_array(strtoupper($operator), $allowedOperators, true)) {
                throw new InvalidArgumentException("Invalid operator: $operator");
            }
    
            // Unique parameter key (to avoid conflicts)
            $paramKey = ":{$property}_{$index}";
    
            // Handle special case for "IN" operator
            if (strtoupper($operator) === "IN" && is_array($value)) {
                $placeholders = [];
                foreach ($value as $i => $v) {
                    $key = ":{$property}_{$index}_{$i}";
                    $placeholders[] = $key;
                    $params[$key] = $v;
                }
                $whereParts[] = "$tableName.$property IN (" . implode(", ", $placeholders) . ")";
            } else {
                if(!$encrypted) $whereParts[] = "$tableName.$property $operator $paramKey";
                if($encrypted) $whereParts[] = "SHA2($tableName.$property, 256) $operator $paramKey";
                $params[$paramKey] = $value;
            }
    
            // Add boolean operator (only between conditions)
            if ($index < count($filterCriteria) - 1) {
                $whereParts[] = $boolean;
            }
        }
    
        return [
            "whereParts" => $whereParts,
            "params" => $params
        ];
    }

    private function buildParams(
        array $params, 
        object $object
    ){
        $params = [];
        // Ensure the object has a method to get the table name
        if (!method_exists($object, 'getTableName')) {
            throw new InvalidArgumentException("Object must have a getTableName() method.");
        }
    
        $tableName = $object::getTableName(); // Get table name dynamically
    
        // Use reflection to get the object's public properties
        $reflection = new ReflectionClass($object);
        $properties = $reflection->getProperties();
    
        foreach ($properties as $property) {
            if ($property->isPublic()) {
                $propertyName = $property->getName();
                $value = $object->$propertyName;
    
                // Add only non-empty properties to SELECT/UPDATE clause
                if (!empty($value)) {
                    $params[$propertyName] = $value;
                }
            }
        }
        return $params;
    }
    
    
    

    
    
}