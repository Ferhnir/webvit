<?php

namespace App\Controllers;

use Slim\Views\Twig as View;

use Illuminate\Database\Schema\Builder;

use App\Models\PaymentTransactions as PayTrans;

class ReportFormCtrl extends Controller
{
    protected $columns, $columnsHeader = [];
    protected $from, $to = '';

    public function index($request, $response)
    {

        return $this->view->render($response, 'reportForm.twig');
    
    }
    
    public function downloadCsvAction($request, $response)
    {       
        $this->setColumns();

        $this->from   = strtotime($this->request->getParam('date_from'));
        $this->to     = strtotime($this->request->getParam('date_to'));

        if($this->from > $this->to) {
            
            $to   = $this->from;
            $from = $this->to;
        
        } else {

            $to   = $this->to;
            $from = $this->from;

        }
        
        
        $query = PayTrans::select($this->columns)
                          ->where('status','=','1')
                          ->where(function ($query) use ($from, $to){
                              $query->whereBetween('timeCompleted',[$from, $to + 86400]);
                          })
                          ->get();
                          
        if($query->isEmpty())
        {
            $this->flash->addMessage('warning', 'There is no transaction payments between '.$this->request->getParam('date_from').' and '.$this->request->getParam('date_to'));
            
            return $response->withRedirect($this->router->pathFor('report.form'));
            
        }

        
        $stream = fopen('php://memory', 'w+');
    
        fputcsv($stream, $this->columnsHeader);

        foreach ($query as $fields) {
            $data = [];
            foreach($this->columns as $column_name){
                array_push($data, str_replace('\r\l',' ',$fields[$column_name]));
                
            }
            fputcsv($stream, $data);
        }

        rewind($stream);

        $filename = date('Y-m-d') . '_charity_report.csv';

        $response = $this->response
            ->withHeader('Content-Type', 'text/csv')
            ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->withHeader('Pragma', 'no-cache')
            ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->withHeader('Expires', '0');

        return $response->withBody(new \Slim\Http\Stream($stream));
        
    }

    private function setColumns()
    {
        $this->columns = [
            'firstname',
            'lastname',
            'note',
            'total_donation',
            'address_line1',
            'user_id',
            'email'
        ];

        $this->columnsHeader = [
            'First name',
            'Last name',
            'Note',
            'Total Donation',
            'Address',
            'User ID',
            'Email'
        ];
    }

}