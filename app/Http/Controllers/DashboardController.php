<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 05/03/2016
 * Time: 16:00.
 */

namespace App\Http\Controllers;

use App\Classes\Library\Services\Facebook;
use App\Classes\Repositories\AuditRepository;

/**
 * Class AdminController.
 *
 * All dashboard related classes should extend this controller.
 * This controller sets the required authenticated route. !!
 */
class DashboardController extends Controller
{
    /**
     * Basic overview of the website, here its the dashboard panel.
     *
     * @param AuditRepository $auditRepository
     * @return \Illuminate\Contracts\View\View
     * @internal param Facebook $facebook
     */
    public function index(AuditRepository $auditRepository)
    {
        $audits = $auditRepository->orderByDesc('created_at')->paginate(15);

        return view('dashboard::index')->with(['audits'=>$audits]);
    }
}
