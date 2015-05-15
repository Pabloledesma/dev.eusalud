<?php namespace App\Http\Controllers;
use DB;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
            $letras = str_split('abcdefghijklmñopqrstvwxyz');
            return view('ajax.index', compact('letras'));
	}
        
        public function get_terceros_by_letter()
        {
            if( isset($_POST['letra']) )
            {
                $query = "SELECT TOP 10 dbo.TERCEROS.TrcRazSoc FROM TERCEROS WHERE dbo.TERCEROS.TrcRazSoc LIKE '".$_POST['letra']."%' ORDER BY dbo.TERCEROS.TrcRazSoc";
                $info = DB::connection('sqlsrv_info')->select($query);
                if(isset($info) && count($info)>0 ){
                   
                    return view('ajax.terceros', compact('info'));
                } else {
                    return "no se encontraron resultados";
                }
            }
        }

}
