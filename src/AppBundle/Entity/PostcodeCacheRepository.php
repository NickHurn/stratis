<?php
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use http\Params;


class PostcodeCacheRepository extends EntityRepository
{
    //----------------------------------------------------------------------------------
	//  Fetch addresses for postcode
	//----------------------------------------------------------------------------------
	
	public function getData($postcode, $house, $key, $url)
	{


        $this->clearOld();

        //  Format our postcode to uppercase, no spaces
        $postcode = strtoupper(strtr($postcode, array(' '=>'')));

        //  Check to see if the postcode is in our cache
        $em= $this->getEntityManager();
        $pc = $em->getRepository('AppBundle:PostcodeCache')->findOneBy(['postcode'=>$postcode]);

        //  If it is, great, return it
        if($pc)
        { 
			return $pc->getResponse();
		}
        
		//  Not in the cache, go fetch it

        $url = $url.$postcode."/".$house."?api-key=".$key;

        $data = file_get_contents($url);

        if ($data === false){
            return 'error';
        }
        //  If fetch failed, return failure

        if(!$data) return NULL;

        //  Store result in cache
        $pc = new \AppBundle\Entity\PostcodeCache();
        $pc->setPostcode($postcode);
        $pc->setDateCached(new \DateTime("now"));
        $pc->setResponse($data);
        $pc->setKeepCached(0);
        $em->persist($pc);        
        $em->flush();
        
        //  Return result
        return $data;
	}

    
    //----------------------------------------------------------------------------------
	//  Clear out old cached records
	//----------------------------------------------------------------------------------

	public function clearOld()
	{
        $result = $this->getEntityManager()
			->createQuery('DELETE FROM AppBundle:PostcodeCache pc WHERE pc.dateCached<:dt AND pc.keepCached=0')
            ->setParameters(array("dt"=> new \DateTime("-30 DAYS")))
			->getResult();

    }

}
