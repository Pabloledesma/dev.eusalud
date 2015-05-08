<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use function view;
use DB;
use Vsmoraes\Pdf\Pdf;
use Maatwebsite\Excel\Excel;

class InfoController extends Controller {

    private $pdf;
    private $excel; 

    public function __construct(Pdf $pdf, Excel $excel) {
        $this->middleware('auth');
        $this->pdf = $pdf;
        $this->excel = $excel;
    }
    /**
    * Muestra una lista con los formularios disponibles
    ***/
    public function index() {
        return view('info.index');
    }

    /*
     * Muestra el formulario para generar el Certificado de pagos a profesionales de la salud
     */
    public function form_certificado_pagos_profesionales() {
        return view('info.certificado_pagos');
    }

    /**
    * Muestra el formulario para generar el informe de Pago a proveedores
    ***/
    public function form_pago_proveedores() {
        return view('info.pago_proveedores');
    }

    /**
    * Muestra el formulario para generar el informe de Pago a proveedores en excel
    ***/
    public function form_certificado_pagos_profesionales_excel()
    {
        return view('info.certificado_pagos_excel');
    }

    public function pago_proveedores(Requests\Certificado_de_pagos $request) {
        $input = $request->all();
        if (isset($input['num_id'])) {
            $num_id = $input['num_id'];
        } else {
            $num_id = \Auth::user()->num_id;
        }
        $headerTitle = 'Informe de pago a proveedores';
        $query = "SELECT 
            dbo.MOVCONT3.DOCCOD, 
            dbo.MOVCONT3.MvCNro,            
            dbo.MOVCONT3.MvCFch, 
            dbo.MOVCONT2.MvCNat, 
            dbo.CUENTAS.CntInt, 
            dbo.MOVCONT2.CntCod, 
            dbo.CUENTAS.CntDsc, 
            dbo.MOVCONT2.TrcCod, 
            dbo.TERCEROS.TrcRazSoc, 
            dbo.MOVCONT2.MvCVlr, 
            dbo.MOVCONT2.MvCDocRf1, 
            dbo.MOVCONT2.MvCDocRf2, 
            dbo.MOVCONT2.MvCDet, 
            dbo.MOVCONT2.MvCBse, 
            dbo.MOVCONT2.MvCImpCod
        FROM 
            ((dbo.MOVCONT3 INNER JOIN dbo.MOVCONT2 ON 
            (dbo.MOVCONT3.MCDpto = dbo.MOVCONT2.MCDpto) AND 
            (dbo.MOVCONT3.MvCNro = dbo.MOVCONT2.MvCNro) AND 
            (dbo.MOVCONT3.DOCCOD = dbo.MOVCONT2.DOCCOD) AND 
            (dbo.MOVCONT3.EMPCOD = dbo.MOVCONT2.EMPCOD)) 
            LEFT JOIN dbo.CUENTAS ON (dbo.MOVCONT2.CntCod = dbo.CUENTAS.CntCod) AND 
            (dbo.MOVCONT2.CntVig = dbo.CUENTAS.CntVig)) 
            LEFT JOIN dbo.TERCEROS ON dbo.MOVCONT2.TrcCod = dbo.TERCEROS.TrcCod
        WHERE (((dbo.MOVCONT3.MvCFch) Between convert(datetime, '" . $input['fecha_inicio'] . "' ,101) And 
        convert(datetime,'" . $input['fecha_final'] . "', 101)) AND ((dbo.MOVCONT3.MvCEst)<>'N') AND 
        ((dbo.MOVCONT2.TrcCod)= '" . $num_id . "')) ORDER BY dbo.MOVCONT3.MvCFch";

        $info = DB::connection('sqlsrv_info')->select($query);

        if (isset($info) && count($info) > 0) {
            $html = view('info.informe', compact('info', 'input', 'headerTitle'))->render();
            return $this->pdf->load($html, array(0, 0, 1300, 800))
                            ->filename('informe_de_pago_a_proveedores_' . date('Y-m-d H:i:s') . '.pdf')
                            ->download();
        }
        return view('info.sin_resultados', compact('input'));
    }

    public function certificado_pagos_profesionales(Requests\Certificado_de_pagos $request) {
        $input = $request->all();
        if (isset($input['num_id'])) {
            $num_id = $input['num_id'];
        } else {
            $num_id = \Auth::user()->num_id;
        }
        $headerTitle = 'Certificado de pagos a profesionales de la salud';
        $fileTitle = 'certificado_de_pagos_profesionales_';
        $query = "SELECT 
            dbo.MOVCONT3.DOCCOD, 
            dbo.MOVCONT3.MvCNro,            
            dbo.MOVCONT3.MvCFch, 
            dbo.MOVCONT2.MvCNat, 
            dbo.CUENTAS.CntInt, 
            dbo.MOVCONT2.CntCod, 
            dbo.CUENTAS.CntDsc, 
            dbo.MOVCONT2.TrcCod, 
            dbo.TERCEROS.TrcRazSoc, 
            dbo.MOVCONT2.MvCVlr, 
            dbo.MOVCONT2.MvCDocRf1, 
            dbo.MOVCONT2.MvCDocRf2, 
            dbo.MOVCONT2.MvCDet, 
            dbo.MOVCONT2.MvCBse, 
            dbo.MOVCONT2.MvCImpCod
        FROM 
            ((dbo.MOVCONT3 INNER JOIN dbo.MOVCONT2 ON 
            (dbo.MOVCONT3.MCDpto = dbo.MOVCONT2.MCDpto) AND 
            (dbo.MOVCONT3.MvCNro = dbo.MOVCONT2.MvCNro) AND 
            (dbo.MOVCONT3.DOCCOD = dbo.MOVCONT2.DOCCOD) AND 
            (dbo.MOVCONT3.EMPCOD = dbo.MOVCONT2.EMPCOD)) 
            LEFT JOIN dbo.CUENTAS ON (dbo.MOVCONT2.CntCod = dbo.CUENTAS.CntCod) AND 
            (dbo.MOVCONT2.CntVig = dbo.CUENTAS.CntVig)) 
            LEFT JOIN dbo.TERCEROS ON dbo.MOVCONT2.TrcCod = dbo.TERCEROS.TrcCod
        WHERE (((dbo.MOVCONT3.MvCFch) Between convert(datetime, '" . $input['fecha_inicio'] . "' ,101) And 
        convert(datetime,'" . $input['fecha_final'] . "', 101)) AND ((dbo.MOVCONT3.MvCEst)<>'N') AND 
        ((dbo.MOVCONT2.TrcCod)= '" . $num_id . "')) AND dbo.MOVCONT2.CntCod NOT LIKE '6%' ORDER BY dbo.MOVCONT3.MvCFch";

        $info = DB::connection('sqlsrv_info')->select($query);

        if (isset($info) && count($info) > 0) {
            $html = view('info.informe', compact('info', 'input', 'headerTitle'))->render();
            return $this->pdf->load($html, array(0, 0, 1300, 800))
                            ->filename($fileTitle . date('Y-m-d H:i:s') . '.pdf')
                            ->download();
        }
        return view('info.sin_resultados', compact('input'));
    }

    /**
     * Retorna un archivo de excel con el certificado_pagos_profesionales
     * @return documento de excel
     */
    
    public function testExcel(Requests\Certificado_de_pagos $request) {

        //Para los informes de excel
        //$html = view('auth.login')->render();
        //return $this->pdf->load($html)->download();
        
        $input = $request->all();
        if (isset($input['num_id'])) {
            $num_id = $input['num_id'];
        } else {
            $num_id = \Auth::user()->num_id;
        }
        $headerTitle = 'Certificado de pagos a profesionales de la salud';
        $fileTitle = 'certificado_de_pagos_profesionales_';
        $query = "SELECT 
            dbo.MOVCONT3.DOCCOD, 
            dbo.MOVCONT3.MvCNro,            
            dbo.MOVCONT3.MvCFch, 
            dbo.MOVCONT2.MvCNat, 
            dbo.CUENTAS.CntInt, 
            dbo.MOVCONT2.CntCod, 
            dbo.CUENTAS.CntDsc, 
            dbo.MOVCONT2.TrcCod, 
            dbo.TERCEROS.TrcRazSoc, 
            dbo.MOVCONT2.MvCVlr, 
            dbo.MOVCONT2.MvCDocRf1, 
            dbo.MOVCONT2.MvCDocRf2, 
            dbo.MOVCONT2.MvCDet, 
            dbo.MOVCONT2.MvCBse, 
            dbo.MOVCONT2.MvCImpCod
        FROM 
            ((dbo.MOVCONT3 INNER JOIN dbo.MOVCONT2 ON 
            (dbo.MOVCONT3.MCDpto = dbo.MOVCONT2.MCDpto) AND 
            (dbo.MOVCONT3.MvCNro = dbo.MOVCONT2.MvCNro) AND 
            (dbo.MOVCONT3.DOCCOD = dbo.MOVCONT2.DOCCOD) AND 
            (dbo.MOVCONT3.EMPCOD = dbo.MOVCONT2.EMPCOD)) 
            LEFT JOIN dbo.CUENTAS ON (dbo.MOVCONT2.CntCod = dbo.CUENTAS.CntCod) AND 
            (dbo.MOVCONT2.CntVig = dbo.CUENTAS.CntVig)) 
            LEFT JOIN dbo.TERCEROS ON dbo.MOVCONT2.TrcCod = dbo.TERCEROS.TrcCod
        WHERE (((dbo.MOVCONT3.MvCFch) Between convert(datetime, '" . $input['fecha_inicio'] . "' ,101) And 
        convert(datetime,'" . $input['fecha_final'] . "', 101)) AND ((dbo.MOVCONT3.MvCEst)<>'N') AND 
        ((dbo.MOVCONT2.TrcCod)= '" . $num_id . "')) AND dbo.MOVCONT2.CntCod NOT LIKE '6%' ORDER BY dbo.MOVCONT3.MvCFch";

        $info = DB::connection('sqlsrv_info')->select($query);

        if (isset($info) && count($info) > 0) {
            
            $this->excel->create('Certificado de pagos a profesionales de la salud', function($excel) use($info, $input, $headerTitle) {
            $excel->sheet('Sheetname', function($sheet) use($info, $input, $headerTitle) {
                 
                $sheet->loadview('info.informe', compact('info', 'headerTitle', 'input'));
                // Font family
                $sheet->setFontFamily('Comic Sans MS');

                // Set font with ->setStyle()`
                $sheet->setStyle(array(
                    'font' => array(
                        'name'      =>  'Calibri',
                        'size'      =>  12,
                        'bold'      =>  true
                    )
                ));
//                $sheet->mergeCells('A1:M1');
//                $sheet->mergeCells('A2:M2');
//                $data = [];
//
//                /*** Cabecera ***/
//                
//                array_push($data, array('Clínica EuSalud'));
//                array_push($data, array('Certificado de pagos a profesionales de la salud'));
//                array_push($data, array('Tercero', 'Nombre del Tercero'));
//                array_push($data, array( $info[0]->TrcCod, $info[0]->TrcRazSoc));
//                array_push($data, array(
//                    'Documento Contable',
//                    'Numero de documento contable',
//                    'Fecha',
//                    'Naturaleza',
//                    'Tipo de Cuenta',
//                    'Cuenta',
//                    'Nombre de cuenta',
//                    'Valor',
//                    'Referencia 1',
//                    'Referencia 2',
//                    'Detalle',
//                    'Base',
//                    'Impuesto',
//                ));
//                
//                /*** Información ***/
//                          
//                    foreach( $info as $row ){
//                        array_push($data, array(
//                            $row->DOCCOD,
//                            $row->MvCNro,
//                            $row->MvCFch,
//                            $row->MvCNat,
//                            $row->CntInt,
//                            $row->CntCod,
//                            $row->CntDsc,
//                            '$' . number_format( $row->MvCVlr ),
//                            $row->MvCDocRf1,
//                            $row->MvCDocRf2,
//                            $row->MvCDet,
//                            '$' . number_format( $row->MvCBse ),
//                            $row->MvCImpCod,
//                        ));
//                    }
                               
//                $sheet->fromArray($data, null, 'A1', false, false);
//                
//                /*** ESTILOS ***/
//                
//                $sheet->cells('A1:M1', function($cells) {
//
//                    $cells->setFontColor('#ffffff');
//                    $cells->setFontFamily('Calibri');
//                    $cells->setFontSize(16);
//                    $cells->setFontWeight('bold');
//                    $cells->setAlignment('center');
//                    $cells->setValignment('middle');
//                    $cells->setBackground('#1E7F74');
//                });
//                $sheet->cells('A2:M2', function($cells) {
//
//                    $cells->setFontColor('#ffffff');
//                    $cells->setFontFamily('Calibri');
//                    $cells->setFontSize(12);
//                    $cells->setFontWeight('bold');
//                    $cells->setAlignment('center');
//                    $cells->setValignment('middle');
//                    $cells->setBackground('#1E7F74');
//                });
//
//                $sheet->cells('A3:M3', function($cells) {
//                    $cells->setFontColor('#000000');
//                    $cells->setFontFamily('Calibri');
//                    $cells->setFontSize(10);
//                    $cells->setFontWeight('bold');
//                    $cells->setAlignment('center');
//                    $cells->setValignment('middle');
//                    $cells->setBackground('#FFFFFF');
//                  });
                });
            })->download('xlsx');
        } else {
            return view('info.sin_resultados', compact('input'));
        }        
    }
}
