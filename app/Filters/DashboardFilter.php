<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if(!session()->get("usuario") || session("usuario")->tipo != "admin") {
            return redirect()->to("/login")->with("mensaje", "acceso denegado (desde DashboardFilter.php)");
        }
        
        // if(session("usuario") == null) {
        //     return redirect()->to("/login")->with("mensaje", "no te hagas el/la bolud@ que ni siquiera estas loguead@");
        // }

        // if(session()->get("usuario")->tipo != "admin") {
        //     return redirect()->to(route_to("usuario.login"))->with("mensaje", session("usuario")->usuario . ", no sos admin, no te hagas el/la bolud@ que sabemos que tu id es " . session("usuario")->id . " y tu email es " . session("usuario")->email);
        // }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
