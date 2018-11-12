<?php

namespace App\Controllers;

use Slim\Views\Twig as View;

use Illuminate\Database\Schema\Builder;

use App\Models\PaymentTransactions as PayTrans;

class ReportFormCtrl extends Controller
{
    protected $columns = [];

    public function index($request, $response)
    {

        return $this->view->render($response, 'reportForm.twig', [
            'charities' => $charities
        ]);
    
    }

    public function downloadCsvAction($request, $response)
    {

        $this->setColumns();

        $query = PayTrans::join('charities','payment_transactions.to_charity','=','charities.charity_id')
                           ->select($this->columns)
                           ->where('to_charity','=',$charity_id)
                           ->get();

        $stream = fopen('php://memory', 'w+');
    
        fputcsv($stream, $this->columns, ';');

        foreach ($query as $fields) {
            $data = [];
            foreach($this->columns as $column_name){
                array_push($data, $fields[$column_name]);
            }
            fputcsv($stream, $data, ';');
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
            'charity_name',
            'address_line1',
            'address_line2',
            'address_line3',
            'address_line4',
            'text1',
            'text2',
            'text3',
            'text4',
            'user_id',
            'email'
        ];
    }

}