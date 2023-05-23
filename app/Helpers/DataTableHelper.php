<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class DataTableHelper
{
    private $request;

    public function __construct(Request  $request)
    {
        $this->request = $request;
    }

    public function getParams(){
        /*
         * $params = [
         *  orders => [["name", "asc"]],
         *  searchByColumn => ["name","created"],
         *  searchQuery    => "",
         *  limit       => 10,
         *  start       => 0
         * ]
         */
        $params = [
            "orders"          => $this->getOrders(),
            "searchByColumn"  => $this->getSearchByColumn(),
            "searchQuery"     => $this->request->search['value'],
            "limit"           => $this->request->length,
            "start"           => $this->request->start
        ];
        return $params;
    }

    function getOrders(){
        $orders = array();
        foreach ($this->request->order as $orderTable){
            $columnIndex = $orderTable['column'];
            $columnName = $this->request->columns[$columnIndex]['name'];
            if(strlen($columnName) > 0) {
                $orderItem = [$columnName, $orderTable['dir']];
                array_push($orders, $orderItem);
            }
        }
        return $orders;
    }
    function getSearchByColumn(){
        $searchByColumn = array();
        foreach ($this->request->columns as $col){
            if($col['searchable'] === "true")
                array_push($searchByColumn, $col['name']);
        }
        return $searchByColumn;
    }

    public function getResult($data, $total){
        return  [
            "draw" => $this->request->draw,
            "data" => $data,
            "recordsFiltered" => $total,
            "recordsTotal" => $total
        ];
    }
}