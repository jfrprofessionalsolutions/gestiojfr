<?php

namespace App\Security;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Routing\RouterInterface;

//Classe que s'encarrega de fer les comprovacions d'autentificació d'usuari
class LoginFormAuthenticator extends AbstractAuthenticator
{
    private UsersRepository $usersRepository;
    private RouterInterface $router;

    //Es crea una funció de construcció per a personalitzar la búsqueda del usuari
    public function __construct(UsersRepository $usersRepository, RouterInterface $router)
    {
        $this->usersRepository = $usersRepository;
        $this->router = $router;
    }

    //Fució que comprova que es compleixen els requisits conforme s'ha enviat el formulari
    public function supports(Request $request): ?bool
    {
        // Comprova que s'està rebent una petició d'accés des del formulari de login i que aquesta és de tipus Post
        return $request->getPathInfo() === '/login' && $request->isMethod('POST');
    }

    //Funció que s'encarrega de comprovar que l'autenticació de l'usuari introduit sigui correcta
    public function authenticate(Request $request): Passport
    {
        //Es recuperen les dades rebudes
        $email = $request->request->get('email');
        $contrasenya = $request->request->get('contrasenya');


        //El primer argument (userBadge) comprova si l'usuari existeix dins de la base de dades i, el segón argument comprova si la contrasenya introduida és correcte
        return new Passport(
            new UserBadge($email, function($userIdentifier) {
                $dadesUsuari = $this->usersRepository->findOneBy(['email' => $userIdentifier]);
                if (!$dadesUsuari) {
                    throw new UserNotFoundException();
                }
                return $dadesUsuari;
            }),
            new PasswordCredentials( $contrasenya
        ));
    }

    //Funció que s'executa si l'autenticació ha sigut correcta
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse(
            $this->router->generate('app_pressupostos_index')
        );
    }

    //Funció que s'executa si hi ha hagut algún error a l'hora de validar l'autenticació
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        //Es recupera el típus d'error que hi ha hagut al inici de sessió
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        //Es redirigeix de nou a la pàgina de login per a mostrar quyin ha sigut l'error que hi ha hagut
        return new RedirectResponse(
            $this->router->generate('app_login')
        );
    }

//    public function start(Request $request, AuthenticationException $authException = null): Response
//    {
//        /*
//         * If you would like this class to control what happens when an anonymous user accesses a
//         * protected page (e.g. redirect to /login), uncomment this method and make this class
//         * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface.
//         *
//         * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
//         */
//    }
}
