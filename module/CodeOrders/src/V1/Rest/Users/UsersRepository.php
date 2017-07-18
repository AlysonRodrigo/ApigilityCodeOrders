<?php
/**
 * Created by PhpStorm.
 * User: alyson
 * Date: 17/07/17
 * Time: 23:09
 */

namespace CodeOrders\V1\Rest\Users;


use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Paginator\Adapter\DbTableGateway;

class UsersRepository
{

    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function save($data){
        $this->tableGateway->insert((array)$data);
        $id = $this->tableGateway->lastInsertValue;
        return $this->find($id);
    }

    public function findAll(){

        $tableGateway = $this->tableGateway;
        $paginatorAdapter = new DbTableGateway($tableGateway);

        return new UsersCollection($paginatorAdapter);
    }

    public function find($id){

        $resultSet = $this->tableGateway->select(['id' => (int)$id]);

        return $resultSet->current();
    }

    public function update($id,$data){
        $this->tableGateway->update((array)$data,["id" => (int)$id]);
        return $this->find($id);
    }

    public function delete($id){
        $result = $this->find($id);
        if(!$result)
        {
            return new ApiProblem(404,'Registro não encontrado');
        }
        $this->tableGateway->delete(['id'=>(int)$id]);
        return true;
    }
}