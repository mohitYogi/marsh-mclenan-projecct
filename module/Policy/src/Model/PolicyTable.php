<?php

namespace Policy\Model;

use Zend\Db\TableGateway\TableGatewayInterface;

class PolicyTable
{

    protected $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function savePolicy(Policy $policy)
    {
        $data = [
            'id' => $policy->getId(),
            'first_name' => $policy->getFirstName(),
            'last_name' => $policy->getLastName(),
            'policy_number' => $policy->getPolicyNumber(),
            'start_date' => $policy->getStartDate(),
            'end_date' => $policy->getEndDate(),
            'premium' => $policy->getPremium(),
        ];
        if ($policy->getId()) {
            $this->tableGateway->update($data, [
                'id' => $policy->getId()
            ]);
        } else {
            $this->tableGateway->insert($data);
        }
    }

    public function getPolicy(int $id)
    {
        $current = $this->tableGateway->select([
            'id' => $id
        ]);
        return $current->current();
    }

    public function deletePolicy(int $id)
    {
        $this->tableGateway->delete([
            'id' => $id
        ]);
    }
}
