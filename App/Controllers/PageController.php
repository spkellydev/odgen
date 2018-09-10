<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PageController
{
    private $c = null;

    public function __construct($container)
    {
        $this->c = $container;
    }

    public function index(Request $request, Response $response, $args)
    {
        return $this->c['view']->render($response, 'Welcome.twig', [
            'title' => "Ogden Insurance & Consulting | Shrewsbury, New Jersey",
            'desc' => "Ogden Insurance & Consulting is a local insurance company offering coverage for medial, travel, and medicare insurance for individuals and groups.",
            'token' => $_SESSION['token'],
        ]);
    }

    public function about(Request $request, Response $response, $args)
    {
        return $this->c['view']->render($response, 'pages/About.twig', [
            'title' => "Our Company | Ogden Insurance & Co. | Local Insurance Company",
            'desc' => "Ogden Insurance & Co has over 30 years of experience. We find affordable insurance rates for New Jersey individuals and groups.",
        ]);
    }

    public function contact(Request $request, Response $response, $args)
    {
        return $this->c['view']->render($response, 'pages/Contact.twig', [
            'title' => "Get In Touch | Insurance Company Nearby | Ogden Insurance & Co.",
            'desc' => "Get a quote on insurance today or get in touch with our team to discover affordable rates.",
            'token' => $_SESSION['token'],
        ]);
    }

    public function privacy(Request $request, Response $response, $args)
    {
        return $this->c['view']->render($response, 'pages/Privacy.twig', [
            'title' => 'Our Privacy Policy and Terms',
            'desc' => "We will only use your information to find you the best rates possible. We're a local insurance company that cares.",
        ]);
    }

    public function thankYou(Request $request, Response $response, $args)
    {
        return $this->c['view']->render($response, 'pages/ThankYou.twig', [
            'title' => 'Thank You!',
            'desc' => "Thank you for contacting Ogden Insurance & Co.",
            'noindex' => true,
        ]);
    }

    public function notFound(Request $request, Response $response, $args)
    {
        return $this->c['view']->render($response, 'pages/NotFound.twig', [
            'title' => "Whoops! Please Get in Touch for Help!",
            'desc' => "Whoops! 404!",
        ]);
    }
}
