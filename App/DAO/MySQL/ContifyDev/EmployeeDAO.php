<?php

namespace App\DAO\MySQL\ContifyDev;
use App\Models\EmployeeModel;

class EmployeeDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllEmployees($company, $limit, $offset): array
    {
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM employee
                WHERE
                    tenantId = :tenantId
                AND
                    enable = :enable LIMIT :limit OFFSET :offset
            ;');
        
        $statement->bindParam(':tenantId', $company, \PDO::PARAM_STR);
        $statement->bindValue(':enable', 1, \PDO::PARAM_INT);
        $statement->bindValue(':limit', (int) $limit, \PDO::PARAM_INT); 
        $statement->bindValue(':offset', (int) $offset, \PDO::PARAM_INT); 
        $statement->execute();
        $employees = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        return $employees;    
    }

    public function getEmployeesId(string $uid)
    {
        $statement = $this->pdo
            ->prepare('SELECT
                    *
                FROM employee
                WHERE
                    uid = :uid
                AND
                    enable = :enable
            ;');
        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->bindValue(':enable', 1, \PDO::PARAM_INT);
        $statement->execute();
        $employees = $statement->fetch(\PDO::FETCH_ASSOC);
        
        return $employees;
    }

    public function insertEmployees(EmployeeModel $employee): void
    {
        $enable = 1;
        
        $statement = $this->pdo->prepare('INSERT INTO employee(
            createdAt, 
            enable,
            tenantId,
            fullName,
            salary,
            admissionDate,
            startTimeStartPeriodMonToFri,
            endTimeStartPeriodMonToFri,
            startTimeEndPeriodMonToFri,
            endTimeEndPeriodMonToFri,
            startTimeSaturday,
            endTimeSaturday,
            uid) 
            VALUES(
                :createdAt,
                :enable,
                :tenantId,
                :fullName,
                :salary,
                :admissionDate,
                :startTimeStartPeriodMonToFri,
                :endTimeStartPeriodMonToFri,
                :startTimeEndPeriodMonToFri,
                :endTimeEndPeriodMonToFri,
                :startTimeSaturday,
                :endTimeSaturday,
                :uid
            );');

        $statement->bindValue("createdAt", $employee->getCreatedAt());
        $statement->bindValue("enable", 1, \PDO::PARAM_BOOL);
        $statement->bindValue("tenantId", $employee->getTenantId());   
        $statement->bindValue("fullName", $employee->getFullName());
        $statement->bindValue("salary", $employee->getSalary());
        $statement->bindValue("admissionDate", $employee->getAdmissionDate());
        $statement->bindValue("startTimeStartPeriodMonToFri", $employee->getStartTimeStartPeriodMonToFri());
        $statement->bindValue("endTimeStartPeriodMonToFri", $employee->getEndTimeStartPeriodMonToFri());
        $statement->bindValue("startTimeEndPeriodMonToFri", $employee->getStartTimeEndPeriodMonToFri());
        $statement->bindValue("endTimeEndPeriodMonToFri", $employee->getEndTimeEndPeriodMonToFri());
        $statement->bindValue("startTimeSaturday", $employee->getStartTimeSaturday());
        $statement->bindValue("endTimeSaturday", $employee->getEndTimeSaturday());
        $statement->bindValue("uid", $employee->getUid());
        $statement->execute();
    }

    public function deleteEmployees(string $uid)
    {
        $statement = $this->pdo
            ->prepare('UPDATE employee 
                    SET enable = :enable 
                    WHERE uid = :uid');

        $statement->bindParam(':uid', $uid, \PDO::PARAM_STR);
        $statement->bindValue(":enable", 0, \PDO::PARAM_INT);
        $statement->execute();
    }
}