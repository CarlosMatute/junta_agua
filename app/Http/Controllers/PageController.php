<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use DB;
use Session;
use Exception;
use App\Models\User;

class PageController extends Controller
{
    /**
     * Show specified view.
     *
     */
    public function dashboardOverview1(): View
    {
        $clientes = collect(\DB::select("SELECT
                COUNT(1) CLIENTES
            FROM
                TBL_CLIENTES
            WHERE
                DELETED_AT IS NULL"))->first();

        $empleados = collect(\DB::select("SELECT
                COUNT(1) EMPLEADOS
            FROM
                PER_EMPLEADO
            WHERE
                DELETED_AT IS NULL"))->first();

        $clientes_ubicaciones = DB::select("SELECT
                TRIM(
                    COALESCE(TRIM(TC.PRIMER_NOMBRE) || ' ', '') || COALESCE(TRIM(TC.SEGUNDO_NOMBRE) || ' ', '') || COALESCE(TRIM(TC.PRIMER_APELLIDO) || ' ', '') || COALESCE(TRIM(TC.SEGUNDO_APELLIDO || ' '), '')
                ) CLIENTE,
                COUNT(TU.ID) UBICACIONES,
                TO_CHAR(TC.CREATED_AT, 'DD FMMonth YYYY') FECHA_CLIENTE_REGISTRADO
            FROM
                TBL_CLIENTES TC
                LEFT JOIN TBL_UBICACION TU ON TC.ID = TU.ID_CLIENTE
            WHERE
                TC.DELETED_AT IS NULL
                AND TU.DELETED_AT IS NULL
            GROUP BY
                CLIENTE,
                TC.CREATED_AT
            ORDER BY
                UBICACIONES DESC
            LIMIT 4");


        $contratos = collect(\DB::SELECT("SELECT COUNT(1) CONTRATOS
                FROM PUBLIC.TBL_CONTRATO TC
                JOIN TBL_CLIENTES C ON TC.ID_CLIENTE = C.ID
                JOIN TBL_UBICACION TU ON TC.ID_UBICACION = TU.ID
                JOIN TBL_SERVICIO TS ON TC.ID_SERVICIO = TS.ID
                WHERE TC.DELETED_AT IS NULL
                    AND C.DELETED_AT IS NULL
                    AND TU.DELETED_AT IS NULL
                    AND TS.DELETED_AT IS NULL"))->first();
        
        $sql_ingresos_mensuales = DB::SELECT("select sum(haber) FILTER (WHERE extract( month from fecha_hora ) = 1 ) as enero,
            sum(haber) FILTER (WHERE extract( month from fecha_hora ) = 2 ) as febrero,
            sum(haber) FILTER (WHERE extract( month from fecha_hora ) = 3 ) as marzo,
            sum(haber) FILTER (WHERE extract( month from fecha_hora ) = 4 ) as abril,
            sum(haber) FILTER (WHERE extract( month from fecha_hora ) = 5 ) as mayo,
            sum(haber) FILTER (WHERE extract( month from fecha_hora ) = 6 ) as junio,
            sum(haber) FILTER (WHERE extract( month from fecha_hora ) = 7 ) as julio,
            sum(haber) FILTER (WHERE extract( month from fecha_hora ) = 8 ) as agosto,
            sum(haber) FILTER (WHERE extract( month from fecha_hora ) = 9 ) as septiembre,
            sum(haber) FILTER (WHERE extract( month from fecha_hora ) = 10 ) as octubre,
            sum(haber) FILTER (WHERE extract( month from fecha_hora ) = 11 ) as noviembre,
            sum(haber) FILTER (WHERE extract( month from fecha_hora ) = 12 ) as diciembre	
            from public.tbl_movimientos
	where extract( year from created_at )  = extract( year from current_date )
        and deleted_at is null
	");
        
        $sql_cobros_mensuales = DB::SELECT("select sum(debe) FILTER (WHERE extract( month from fecha_hora ) = 1 ) as enero,
                sum(debe) FILTER (WHERE extract( month from fecha_hora ) = 2 ) as febrero,
                sum(debe) FILTER (WHERE extract( month from fecha_hora ) = 3 ) as marzo,
                sum(debe) FILTER (WHERE extract( month from fecha_hora ) = 4 ) as abril,
                sum(debe) FILTER (WHERE extract( month from fecha_hora ) = 5 ) as mayo,
                sum(debe) FILTER (WHERE extract( month from fecha_hora ) = 6 ) as junio,
                sum(debe) FILTER (WHERE extract( month from fecha_hora ) = 7 ) as julio,
                sum(debe) FILTER (WHERE extract( month from fecha_hora ) = 8 ) as agosto,
                sum(debe) FILTER (WHERE extract( month from fecha_hora ) = 9 ) as septiembre,
                sum(debe) FILTER (WHERE extract( month from fecha_hora ) = 10 ) as octubre,
                sum(haber) FILTER (WHERE extract( month from fecha_hora ) = 11 ) as noviembre,
                sum(debe) FILTER (WHERE extract( month from fecha_hora ) = 12 ) as diciembre	
        from public.tbl_movimientos
	where extract( year from created_at )  = extract( year from current_date )
        and deleted_at is null
	");

        return view('pages/dashboard-overview-1')->with("clientes", $clientes)
        ->with("empleados", $empleados)
        ->with("clientes_ubicaciones", $clientes_ubicaciones)
        ->with("contratos", $contratos)
        ->with("sql_ingresos_mensuales", $sql_ingresos_mensuales)
        ->with("sql_cobros_mensuales", $sql_cobros_mensuales)
                ;
    }

    /**
     * Show specified view.
     *
     */
    public function dashboardOverview2(): View
    {
        return view('pages/dashboard-overview-2');
    }

    /**
     * Show specified view.
     *
     */
    public function dashboardOverview3(): View
    {
        return view('pages/dashboard-overview-3');
    }

    /**
     * Show specified view.
     *
     */
    public function dashboardOverview4(): View
    {
        return view('pages/dashboard-overview-4');
    }

    /**
     * Show specified view.
     *
     */
    public function inbox(): View
    {
        return view('pages/inbox');
    }

    /**
     * Show specified view.
     *
     */
    public function categories(): View
    {
        return view('pages/categories');
    }

    /**
     * Show specified view.
     *
     */
    public function addProduct(): View
    {
        return view('pages/add-product');
    }

    /**
     * Show specified view.
     *
     */
    public function productList(): View
    {
        return view('pages/product-list');
    }

    /**
     * Show specified view.
     *
     */
    public function productGrid(): View
    {
        return view('pages/product-grid');
    }

    /**
     * Show specified view.
     *
     */
    public function transactionList(): View
    {
        return view('pages/transaction-list');
    }

    /**
     * Show specified view.
     *
     */
    public function transactionDetail(): View
    {
        return view('pages/transaction-detail');
    }

    /**
     * Show specified view.
     *
     */
    public function sellerList(): View
    {
        return view('pages/seller-list');
    }

    /**
     * Show specified view.
     *
     */
    public function sellerDetail(): View
    {
        return view('pages/seller-detail');
    }

    /**
     * Show specified view.
     *
     */
    public function reviews(): View
    {
        return view('pages/reviews');
    }

    /**
     * Show specified view.
     *
     */
    public function fileManager(): View
    {
        return view('pages/file-manager');
    }

    /**
     * Show specified view.
     *
     */
    public function pointOfSale(): View
    {
        return view('pages/point-of-sale');
    }

    /**
     * Show specified view.
     *
     */
    public function chat(): View
    {
        return view('pages/chat');
    }

    /**
     * Show specified view.
     *
     */
    public function post(): View
    {
        return view('pages/post');
    }

    /**
     * Show specified view.
     *
     */
    public function calendar(): View
    {
        return view('pages/calendar');
    }

    /**
     * Show specified view.
     *
     */
    public function crudDataList(): View
    {
        return view('pages/crud-data-list');
    }

    /**
     * Show specified view.
     *
     */
    public function crudForm(): View
    {
        return view('pages/crud-form');
    }

    /**
     * Show specified view.
     *
     */
    public function usersLayout1(): View
    {
        return view('pages/users-layout-1');
    }

    /**
     * Show specified view.
     *
     */
    public function usersLayout2(): View
    {
        return view('pages/users-layout-2');
    }

    /**
     * Show specified view.
     *
     */
    public function usersLayout3(): View
    {
        return view('pages/users-layout-3');
    }

    /**
     * Show specified view.
     *
     */
    public function profileOverview1(): View
    {
        return view('pages/profile-overview-1');
    }

    /**
     * Show specified view.
     *
     */
    public function profileOverview2(): View
    {
        return view('pages/profile-overview-2');
    }

    /**
     * Show specified view.
     *
     */
    public function profileOverview3(): View
    {
        return view('pages/profile-overview-3');
    }

    /**
     * Show specified view.
     *
     */
    public function wizardLayout1(): View
    {
        return view('pages/wizard-layout-1');
    }

    /**
     * Show specified view.
     *
     */
    public function wizardLayout2(): View
    {
        return view('pages/wizard-layout-2');
    }

    /**
     * Show specified view.
     *
     */
    public function wizardLayout3(): View
    {
        return view('pages/wizard-layout-3');
    }

    /**
     * Show specified view.
     *
     */
    public function blogLayout1(): View
    {
        return view('pages/blog-layout-1');
    }

    /**
     * Show specified view.
     *
     */
    public function blogLayout2(): View
    {
        return view('pages/blog-layout-2');
    }

    /**
     * Show specified view.
     *
     */
    public function blogLayout3(): View
    {
        return view('pages/blog-layout-3');
    }

    /**
     * Show specified view.
     *
     */
    public function pricingLayout1(): View
    {
        return view('pages/pricing-layout-1');
    }

    /**
     * Show specified view.
     *
     */
    public function pricingLayout2(): View
    {
        return view('pages/pricing-layout-2');
    }

    /**
     * Show specified view.
     *
     */
    public function invoiceLayout1(): View
    {
        return view('pages/invoice-layout-1');
    }

    /**
     * Show specified view.
     *
     */
    public function invoiceLayout2(): View
    {
        return view('pages/invoice-layout-2');
    }

    /**
     * Show specified view.
     *
     */
    public function faqLayout1(): View
    {
        return view('pages/faq-layout-1');
    }

    /**
     * Show specified view.
     *
     */
    public function faqLayout2(): View
    {
        return view('pages/faq-layout-2');
    }

    /**
     * Show specified view.
     *
     */
    public function faqLayout3(): View
    {
        return view('pages/faq-layout-3');
    }

    /**
     * Show specified view.
     *
     */
    public function login(): View
    {
        return view('pages/login');
    }

    /**
     * Show specified view.
     *
     */
    public function register(): View
    {
        return view('pages/register');
    }

    /**
     * Show specified view.
     *
     */
    public function errorPage(): View
    {
        return view('pages/error-page');
    }

    /**
     * Show specified view.
     *
     */
    public function updateProfile(): View
    {
        return view('pages/update-profile');
    }

    /**
     * Show specified view.
     *
     */
    public function changePassword(): View
    {
        return view('pages/change-password');
    }

    /**
     * Show specified view.
     *
     */
    public function regularTable(): View
    {
        return view('pages/regular-table');
    }

    /**
     * Show specified view.
     *
     */
    public function tabulator(): View
    {
        return view('pages/tabulator');
    }

    /**
     * Show specified view.
     *
     */
    public function modal(): View
    {
        return view('pages/modal');
    }

    /**
     * Show specified view.
     *
     */
    public function slideOver(): View
    {
        return view('pages/slide-over');
    }

    /**
     * Show specified view.
     *
     */
    public function notification(): View
    {
        return view('pages/notification');
    }

    /**
     * Show specified view.
     *
     */
    public function tab(): View
    {
        return view('pages/tab');
    }

    /**
     * Show specified view.
     *
     */
    public function accordion(): View
    {
        return view('pages/accordion');
    }

    /**
     * Show specified view.
     *
     */
    public function button(): View
    {
        return view('pages/button');
    }

    /**
     * Show specified view.
     *
     */
    public function alert(): View
    {
        return view('pages/alert');
    }

    /**
     * Show specified view.
     *
     */
    public function progressBar(): View
    {
        return view('pages/progress-bar');
    }

    /**
     * Show specified view.
     *
     */
    public function tooltip(): View
    {
        return view('pages/tooltip');
    }

    /**
     * Show specified view.
     *
     */
    public function dropdown(): View
    {
        return view('pages/dropdown');
    }

    /**
     * Show specified view.
     *
     */
    public function typography(): View
    {
        return view('pages/typography');
    }

    /**
     * Show specified view.
     *
     */
    public function icon(): View
    {
        return view('pages/icon');
    }

    /**
     * Show specified view.
     *
     */
    public function loadingIcon(): View
    {
        return view('pages/loading-icon');
    }

    /**
     * Show specified view.
     *
     */
    public function regularForm(): View
    {
        return view('pages/regular-form');
    }

    /**
     * Show specified view.
     *
     */
    public function datepicker(): View
    {
        return view('pages/datepicker');
    }

    /**
     * Show specified view.
     *
     */
    public function tomSelect(): View
    {
        return view('pages/tom-select');
    }

    /**
     * Show specified view.
     *
     */
    public function fileUpload(): View
    {
        return view('pages/file-upload');
    }

    /**
     * Show specified view.
     *
     */
    public function wysiwygEditorClassic(): View
    {
        return view('pages/wysiwyg-editor-classic');
    }

    /**
     * Show specified view.
     *
     */
    public function wysiwygEditorInline(): View
    {
        return view('pages/wysiwyg-editor-inline');
    }

    /**
     * Show specified view.
     *
     */
    public function wysiwygEditorBalloon(): View
    {
        return view('pages/wysiwyg-editor-balloon');
    }

    /**
     * Show specified view.
     *
     */
    public function wysiwygEditorBalloonBlock(): View
    {
        return view('pages/wysiwyg-editor-balloon-block');
    }

    /**
     * Show specified view.
     *
     */
    public function wysiwygEditorDocument(): View
    {
        return view('pages/wysiwyg-editor-document');
    }

    /**
     * Show specified view.
     *
     */
    public function validation(): View
    {
        return view('pages/validation');
    }

    /**
     * Show specified view.
     *
     */
    public function chart(): View
    {
        return view('pages/chart');
    }

    /**
     * Show specified view.
     *
     */
    public function slider(): View
    {
        return view('pages/slider');
    }

    /**
     * Show specified view.
     *
     */
    public function imageZoom(): View
    {
        return view('pages/image-zoom');
    }
}
