<?php
namespace App\Action;

use App\Models\Posts;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use Psr\Log\LoggerInterface;

final class PagesAction
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
     * @param array $args
     * @return Response
     */
    public function getPage(Request $request, Response $response, array $args)
    {
        return $response->withJson(
            Posts::getPage($args['id']),
            201
        );
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function getPages(Request $request, Response $response, array $args)
    {
        return $response->withJson(
            Posts::getPages(),
            201
        );
    }
}
