<?php

namespace App\Controller;

use App\Entity\Url;
use App\Repository\UrlRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UrlServiceController extends AbstractController
{
    //Example: http://url-shortener.loc/apply-url 
    /**
     * @Route("/apply-url", name="apply_url")
     */
    public function applyUrl(Request $request): JsonResponse
    {
        /** @var UrlRepository $urlRepository */

        $date = \DateTime::createFromFormat('d-m-Y', $request->get('date'));
    
        if ( $date == null) {
            throw new NotFoundHttpException('Date not valid');
        }
        
        return $this->json([
            'url' => $request->get('url') ,
            'date' =>  $date,
        ]);
       
    }


    //Example: http://url-shortener.loc/getstat-url?from=27-09-2024&to=now   
    /**
     * @Route("/getstat-url", name="getstat_url")
     */
    public function betweenDateUrl(Request $request): JsonResponse
    {
        
        /** @var UrlRepository $urlRepository */
        $urlRepository = $this->getDoctrine()->getRepository(Url::class);
        

        $from = \DateTime::createFromFormat('d-m-Y', $request->get('from'));

        $date = new \DateTimeImmutable();
        $curdate = $request->get('to') == 'now' ? $date->format('d-m-Y') : $request->get('to');
        $to = \DateTime::createFromFormat('d-m-Y', $curdate);


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
