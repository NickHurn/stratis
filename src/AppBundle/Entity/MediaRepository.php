<?php
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Media;


class MediaRepository extends EntityRepository
{
	//--------------------------------------------------------------------
	//  Find the media filename matching the file we want
	//--------------------------------------------------------------------
	
	public function getMediaFilename($mediatype, $user_id, $job_id, $format, $seq=1)
    {
        $sql = "SELECT * FROM media WHERE mediatype=:mt AND user_id=:uid AND job_id=:jid AND format=:fmt AND seq=:seq";
		$em= $this->getEntityManager();
		$rec = $em->getRepository('AppBundle:Media')->findOneBy(['mediaType'=>$mediatype, 'userId'=>$user_id, 'jobId'=>$job_id, 'format'=>$format, 'seq'=>$seq]);

		if(empty($rec)) return null;
		$filename = '/media/' . floor($rec->getId()/1000) . '/' . $rec->getId() . '-' . strtolower($rec->getMediaType()) . '-' . $rec->getFilename() . '.' . $rec->getExtn();
		return $filename;
	}
	
	
	//--------------------------------------------------------------------
	//  Create a new media record matching the info we want
	//  Returns the media object
	//--------------------------------------------------------------------

	public function createMediaRecord($mediatype, $format, $extn='jpg', $seq=1, $user_id, $job_id)
    {
		$em = $this->getEntityManager();
		$media = new Media();
		$media->setMediaType($mediatype);
		$media->setFormat($format);
		$media->setExtn($extn);
		$media->setSeq($seq);
		$media->setFilename($this->randomString());
		$media->setUserId($user_id);
		$media->setJobId($job_id);
		$em->persist($media);
		$em->flush();
		return $media;
	}	
	

	
	//--------------------------------------------------------------------
	//  Random string function
	//--------------------------------------------------------------------
	
	private function randomString($length=25, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
	{
		$str = '';
		$max = mb_strlen($keyspace, '8bit') - 1;
		for ($i = 0; $i < $length; ++$i) {
			$str .= $keyspace[random_int(0, $max)];
		}
		return $str;
	}

	
	//--------------------------------------------------------------------
	//  Delete media file
	//--------------------------------------------------------------------
	
	public function deleteMediaFile($mediaId, $mediapath)
	{
		$em= $this->getEntityManager();
		$media = $em->getRepository('AppBundle:Media')->findOneBy(['id'=>$mediaId]);
		if($media)
		{
			$filename = $mediapath . floor($mediaId/1000) . '/' . $mediaId . '-' . strtolower($media->getMediaType()) . '-' . $media->getFilename() . '.' . $media->getExtn();
			unlink($filename);
			$em->remove($media);
			$em->flush();
		}
	}

}

	