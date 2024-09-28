<?php

namespace App\Controller;

use App\Entity\Url;
use App\Repository\UrlRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ServiceUrlController extends AbstractController
{
    //Example: http://url-shortener.loc/apply-url?url=someurl&date=23.02.2024
    /**
     * @Route("/apply-url", name="apply_url")
     */
    public function applyUrl(Request $request): JsonResponse
    {
        /** @var UrlRepository $urlRepository */

       
        return $this->json([
            'name' => $request->get('url') ,
            'date' => $request->get('date') ,
        ]);
        // $urlRepository = $this->getDoctrine()->getRepository(Url::class);
        // $url = $urlRepository->findFirstByUrl($request->get('url'));

        // //Check if hash already exist
        // if (empty($url)) {

        //     //save new hash
        //     $url = new Url();
        //     $url->setUrl($request->get('url'));

        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($url);
        //     $entityManager->flush();

        //     return $this->json([
        //         'hash' => $url->getHash()
        //     ]);
        // }

        // return $this->json([
        //     'hash' => $url->getHash(),
        // ]);
    }


    //Example: http://url-shortener.loc/getstat-url?from=27-09-2024&to=10-10-2024    
    /**
     * @Route("/getstat-url", name="getstat_url")
     */
    public function betweenDateUrl(Request $request): JsonResponse
    {
        
        /** @var UrlRepository $urlRepository */
        $urlRepository = $this->getDoctrine()->getRepository(Url::class);
        
        $from = \DateTime::createFromFormat('d-m-Y', $request->get('from'));
        $to = \DateTime::createFromFormat('d-m-Y', $request->get('to'));


        if ( $from == null || $to == null) {
            throw new NotFoundHttpException('Date not valid');
        }

        return $this->json([
            'urls' => $urlRepository->findByTimeDifference( $from->format('Y-m-d'), $to->format('Y-m-d') ),
        ]);
    }

    //Example: http://url-shortener.loc/getdomin-url?domain=someurl  
    /**
     * @Route("/getdomin-url", name="getdomin_url")
     */
    public function byDomainUrl(Request $request): JsonResponse
    {
        
        /** @var UrlRepository $urlRepository */
        $urlRepository = $this->getDoctrine()->getRepository(Url::class);


        return $this->json([
            'urls' => $urlRepository->findByDomain( $request->get('domain') ),
        ]);
    }
}
