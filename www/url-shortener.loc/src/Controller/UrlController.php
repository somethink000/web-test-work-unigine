<?php

namespace App\Controller;

use App\Entity\Url;
use App\Repository\UrlRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UrlController extends AbstractController
{
    /**
     * @Route("/encode-url", name="encode_url")
     */
    public function encodeUrl(Request $request): JsonResponse
    {
        /** @var UrlRepository $urlRepository */
        $urlRepository = $this->getDoctrine()->getRepository(Url::class);
        $url = $urlRepository->findFirstByUrl($request->get('url'));

        //Check if hash already exist
        if (empty ($url)) {

            //save new hash
            $url = new Url();
            $url->setUrl($request->get('url'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($url);
            $entityManager->flush();

            return $this->json([
                'hash' => $url->getHash()
            ]);
        }
        return $this->json([
            'hash' => $url->getHash()
        ]);

    }

    
    /**
     * @Route("/find-url", name="find_url")
     */
    public function findUrl(Request $request)//: JsonResponse
    {
        /** @var UrlRepository $urlRepository */
        $urlRepository = $this->getDoctrine()->getRepository(Url::class);
        $url = $urlRepository->findOneByHash($request->get('hash'));
        if (empty ($url)) {
            return $this->json([
                'error' => 'Non-existent hash.'
            ]);
        }

        return $this->redirect($url->getUrl());
    
    }


    /**
     * @Route("/decode-url", name="decode_url")
     */
    public function decodeUrl(Request $request): JsonResponse
    {
        /** @var UrlRepository $urlRepository */
        $urlRepository = $this->getDoctrine()->getRepository(Url::class);
        $url = $urlRepository->findOneByHash($request->get('hash'));
        if (empty ($url)) {
            return $this->json([
                'error' => 'Non-existent hash.'
            ]);
        }
        return $this->json([
            'url' => $url->getUrl()
        ]);
    }
}
