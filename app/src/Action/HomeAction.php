<?php
namespace App\Action;

use App\Models\Options;
use App\Models\Posts;
use App\Models\User;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use Psr\Log\LoggerInterface;

final class HomeAction
{
    private $view;
    private $logger;

    /**
     * @param Twig $view
     * @param LoggerInterface $logger
     */
    public function __construct(Twig $view, LoggerInterface $logger)
    {
        $this->view = $view;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response)
    {
        $siteInfo = Options::getSiteInformation();
        $siteInfo[] = Posts::getPhoneDetails();
        $siteInfo[] = Posts::getLogo();

        return $response->withJson($siteInfo, 201);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function getMenu(Request $request, Response $response, array $args)
    {
        return $response->withJson(
            Posts::getMenu($args['id']),
            201
        );
    }
}
