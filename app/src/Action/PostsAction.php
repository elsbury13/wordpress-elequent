<?php
namespace App\Action;

use App\Models\Posts;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use Psr\Log\LoggerInterface;

final class PostsAction
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
    public function getPost(Request $request, Response $response, array $args)
    {
        return $response->withJson(
            Posts::getPost($args['id']),
            201
        );
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function getPosts(Request $request, Response $response)
    {
        return $response->withJson(
            Posts::getPosts(),
            201
        );
    }
}
