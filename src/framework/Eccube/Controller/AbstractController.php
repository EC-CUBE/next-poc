<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eccube\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Eccube\Common\Constant;
use Eccube\Common\EccubeConfig;
use Eccube\Form\FormFactory;
use Eccube\ORM\EntityManager;
use Eccube\Routing\Exception\RoutingException;
use Eccube\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class AbstractController implements ServiceSubscriberInterface
{
    use SymfonyControllerTrait;

    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    protected EntityManager $entityManager;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @param EccubeConfig $eccubeConfig
     * @required
     */
    public function setEccubeConfig(EccubeConfig $eccubeConfig)
    {
        $this->eccubeConfig = $eccubeConfig;
    }

    /**
     * @param EntityManager $entityManager
     * @required
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param TranslatorInterface $translator
     * @required
     */
    public function setTranslator(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param SessionInterface $session
     * @required
     */
    public function setSession(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @param FormFactory $formFactory
     * @required
     */
    public function setFormFactory(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @required
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function addSuccess($message, $namespace = 'front')
    {
        $this->addFlash('eccube.'.$namespace.'.success', $message);
    }

    public function addSuccessOnce($message, $namespace = 'front')
    {
        $this->addFlashOnce('eccube.'.$namespace.'.success', $message);
    }

    public function addError($message, $namespace = 'front')
    {
        $this->addFlash('eccube.'.$namespace.'.error', $message);
    }

    public function addErrorOnce($message, $namespace = 'front')
    {
        $this->addFlashOnce('eccube.'.$namespace.'.error', $message);
    }

    public function addDanger($message, $namespace = 'front')
    {
        $this->addFlash('eccube.'.$namespace.'.danger', $message);
    }

    public function addDangerOnce($message, $namespace = 'front')
    {
        $this->addFlashOnce('eccube.'.$namespace.'.danger', $message);
    }

    public function addWarning($message, $namespace = 'front')
    {
        $this->addFlash('eccube.'.$namespace.'.warning', $message);
    }

    public function addWarningOnce($message, $namespace = 'front')
    {
        $this->addFlashOnce('eccube.'.$namespace.'.warning', $message);
    }

    public function addInfo($message, $namespace = 'front')
    {
        $this->addFlash('eccube.'.$namespace.'.info', $message);
    }

    public function addInfoOnce($message, $namespace = 'front')
    {
        $this->addFlashOnce('eccube.'.$namespace.'.info', $message);
    }

    public function addRequestError($message, $namespace = 'front')
    {
        $this->addFlash('eccube.'.$namespace.'.request.error', $message);
    }

    public function addRequestErrorOnce($message, $namespace = 'front')
    {
        $this->addFlashOnce('eccube.'.$namespace.'.request.error', $message);
    }

    public function clearMessage()
    {
        $this->session->getFlashBag()->clear();
    }

    public function deleteMessage()
    {
        $this->clearMessage();
        $this->addWarning('admin.common.delete_error_already_deleted', 'admin');
    }

    public function hasMessage(string $type): bool
    {
        return $this->session->getFlashBag()->has($type);
    }

    public function addFlashOnce(string $type, $message): void
    {
        if (!$this->hasMessage($type)) {
            $this->addFlash($type, $message);
        }
    }

    protected function addFlash(string $type, $message): void
    {
        try {
            $this->container->get('request_stack')->getSession()->getFlashBag()->add($type, $message);
        } catch (\LogicException $e) {
            // fallback session
            $this->session->getFlashBag()->add($type, $message);
        }
    }

    /**
     * @param string $targetPath
     */
    public function setLoginTargetPath($targetPath, $namespace = null)
    {
        if (is_null($namespace)) {
            $this->session->getFlashBag()->set('eccube.login.target.path', $targetPath);
        } else {
            $this->session->getFlashBag()->set('eccube.'.$namespace.'.login.target.path', $targetPath);
        }
    }

    /**
     * Forwards the request to another controller.
     *
     * @param string $route The name of the route
     * @param array  $path An array of path parameters
     * @param array  $query An array of query parameters
     *
     * @return \Symfony\Component\HttpFoundation\Response A Response instance
     */
    public function forwardToRoute($route, array $path = [], array $query = [])
    {
        $Route = $this->get('router')->getRouteCollection()->get($route);
        if (!$Route) {
            throw new RouteNotFoundException(sprintf('The named route "%s" as such route does not exist.', $route));
        }

        return $this->forward($Route->getDefault('_controller'), $path, $query);
    }

    /**
     * Checks the validity of a CSRF token.
     *
     * if token is invalid, throws AccessDeniedHttpException.
     *
     * @return bool
     *
     * @throws AccessDeniedHttpException
     */
    protected function isTokenValid()
    {
        /** @var Request $request */
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $token = $request->get(Constant::TOKEN_NAME)
            ? $request->get(Constant::TOKEN_NAME)
            : $request->headers->get('ECCUBE-CSRF-TOKEN');

        if (!$this->isCsrfTokenValid(Constant::TOKEN_NAME, $token)) {
            throw new AccessDeniedHttpException('CSRF token is invalid.');
        }

        return true;
    }

    /**
     * @throws RoutingException
     */
    public function generateUrl(string $route, array $parameters = [], int $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH): string
    {
        try {
            return $this->container->get('router')->generate($route, $parameters, $referenceType);
        } catch (\Exception $e) {
            throw new RoutingException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public static function getSubscribedServices()
    {
        return [
            'router' => '?'.RouterInterface::class,
            'request_stack' => '?'.RequestStack::class,
            'http_kernel' => '?'.HttpKernelInterface::class,
            'serializer' => '?'.SerializerInterface::class,
            'session' => '?'.SessionInterface::class,
            'security.authorization_checker' => '?'.AuthorizationCheckerInterface::class,
            'twig' => '?'.Environment::class,
            'doctrine' => '?'.ManagerRegistry::class, // to be removed in 6.0
            'form.factory' => '?'.FormFactoryInterface::class,
            'security.token_storage' => '?'.TokenStorageInterface::class,
            'security.csrf.token_manager' => '?'.CsrfTokenManagerInterface::class,
            'parameter_bag' => '?'.ContainerBagInterface::class,
        ];
    }

}
