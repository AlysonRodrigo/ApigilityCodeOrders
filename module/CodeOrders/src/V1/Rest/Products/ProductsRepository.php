<?php
/**
 * Created by PhpStorm.
 * User: alyson
 * Date: 18/07/17
 * Time: 00:42
 */

namespace CodeOrders\V1\Rest\Products;


use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Paginator\Adapter\DbTableGateway;

class ProductsRepository
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

        return new ProductsCollection($paginatorAdapter);
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