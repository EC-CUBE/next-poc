<?php

namespace Eccube\GraphQL;

use ApiPlatform\GraphQl\Resolver\MutationResolverInterface;
use Eccube\Entity\Customer;
use Eccube\Entity\Master\CustomerStatus;
use Eccube\ORM\EntityManager;
use Eccube\ORM\Exception\ForeignKeyConstraintViolationException;
use Eccube\ORM\Exception\ORMException;
use Eccube\Repository\CustomerRepository;
use Eccube\Routing\Exception\RoutingException;
use Eccube\Routing\Generator\UrlGeneratorInterface;
use Eccube\Routing\Router;
use Eccube\Security\Core\User\UserPasswordHasher;
use Eccube\Service\MailService;

class EntryMutation implements MutationResolverInterface
{
    private UserPasswordHasher $passwordHasher;

    private CustomerRepository $customerRepository;

    private EntityManager $entityManager;

    private MailService $mailService;

    private Router $router;

    public function __construct(
        UserPasswordHasher $passwordHasher,
        CustomerRepository $customerRepository,
        EntityManager $entityManager,
        MailService $mailService,
        Router $router
    )
    {
        $this->passwordHasher = $passwordHasher;
        $this->customerRepository = $customerRepository;
        $this->entityManager = $entityManager;
        $this->mailService = $mailService;
        $this->router = $router;
    }

    /**
     * @param $customer Customer
     * @param array $context
     * @return object|null
     * @throws ForeignKeyConstraintViolationException
     * @throws ORMException|RoutingException
     */
    public function __invoke($customer, array $context)
    {
        $password = $this->passwordHasher->hashPassword($customer, $context['args']['input']['plain_password']);

        $customerStatusProvisional = $this->entityManager
            ->find(CustomerStatus::class, CustomerStatus::PROVISIONAL);

        $customer->setPassword($password)
            ->setStatus($customerStatusProvisional)
            ->setSecretKey($this->customerRepository->getUniqueSecretKey())
            ->setPoint(0);

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        $activateUrl = $this->router->generate('entry_activate',
            ['secret_key' => $customer->getSecretKey()],
            UrlGeneratorInterface::ABSOLUTE_URL);

        $this->mailService->sendCustomerConfirmMail($customer, $activateUrl);

        return $customer;
    }
}
