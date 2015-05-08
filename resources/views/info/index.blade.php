@extends('eusalud2')
@section('content')

<div class="container container-fluid">
    <div class='row col-md-8 col-md-offset-2'>
        <div class="panel panel-default">
            <div class="panel-heading">Informes</div>
            <div class="panel-body">
                <h4>Certificado de pagos a profesionales de la salud</h4>
                <ul>
                    <li><a href="{{ url('info/form_certificado_pagos_profesionales') }}">PDF</a></li>
                    <li><a href="{{ url('info/form_certificado_pagos_profesionales') }}">EXCEL</a></li>
                </ul>
                <hr>
                <h4>Formulario de pago a proveedores</h4>
                <ul>
                    <li><a href="{{ url('info/form_pago_proveedores') }}">PDF</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@stop
