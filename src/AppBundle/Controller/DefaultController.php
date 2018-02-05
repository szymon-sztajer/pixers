<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
	/**
	 * @Route("/", name="homepage")
	 * Template("@App/Default/contact.html.twig")
	 */
	public function indexAction(Request $request)
	{
		$form = $this->createForm('AppBundle\Form\ContactType', null, array(
			'action' => $this->generateUrl('homepage'),
			'method' => 'POST'
		));

		if ($request->isMethod('POST')) {
			$form->handleRequest($request);

			if ($form->isValid()) {
				if ($this->sendEmail($form->getData())) {
                    $this->addFlash(
                        'success',
                        'Your message has been sent!'
                    );
                    $form = $this->createForm('AppBundle\Form\ContactType', null, array(
                        'action' => $this->generateUrl('homepage'),
                        'method' => 'POST'
                    ));
				} else {
                    $this->addFlash(
                        'danger',
                        'Your message has not been sent!'
                    );
                }
			} else {
                $this->addFlash(
                        'danger',
                        'Your form contains validation errors!'
                    );
            }
            return $this->render('@App/Default/contact_ajax.html.twig', [
                'form' => $form->createView()
            ]);
		}

        return $this->render('@App/Default/contact.html.twig', [
                'form' => $form->createView()
            ]);
	}

	public function sendEmail($mailData)
	{
		$mailer = $this->container->get('mailer');
		$message = (new \Swift_Message($mailData['subject'] ?? 'Contact form message'))
			->setFrom($mailData['email'] ?? '')
			->setTo($this->container->getParameter('recipients_email'))
			->setBody(
				$mailData['message'] ?? '',
				'text/plain'
			);

		return $mailer->send($message);
	}
}
