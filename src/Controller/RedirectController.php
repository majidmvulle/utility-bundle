<?php

declare(strict_types=1);

namespace Wbc\UtilityBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as CF;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RedirectController.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 */
class RedirectController extends Controller
{
    /**
     * @CF\Route("/{url}", name="majidmvulle_utility_remove_trailing_slash", requirements={"url" = ".*\/$"},
     *     methods={"GET"})
     */
    public function removeTrailingSlash(Request $request): RedirectResponse
    {
        $pathInfo = $request->getPathInfo();
        $requestUri = $request->getRequestUri();
        $url = str_replace($pathInfo, rtrim($pathInfo, ' /'), $requestUri);

        return $this->redirect($url, 301);
    }
}
