<?php

namespace App\EventSubscriber\Entity;

use App\Entity\Artwork;

use App\Service\FileService;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ArtworkSubscriber implements EventSubscriber
{
	/*
	 * injecter un service dans un autre service hors contrôleur
	 *    - créer une propriété de classe
	 *    - créer un constructeur qui reçoit en paramètre le service à injecter
	 *    - dans le constructeur, lier le paramètre à la propriété de classe
	 */
	private $fileService;

	public function __construct( FileService $fileService)
	{
		$this->fileService = $fileService;
	}

	/*
	 * souscripteur d'entité doctrine
	 *  - la méthode doit retourner un tableau des événements à écouter
	 *      - prePersist / postPersist : avant ou après une insertion
	 *      - preUpdate / postUpdate : avant ou après une modification
	 *      - preRemove / postRemove : avant ou après une suppression
	 *      - postLoad : après l'instanciation d'une entité
	 *  - les méthodes liées aux événements doivent reprendre strictement le nom de l'événement à écouter
	 *  - toutes les méthodes recoivent un paramètre de type LifecycleEventArgs
	 *  - référencer le souscripteur dans config/services.yaml
	 */
	public function prePersist(LifecycleEventArgs $args):void
	{
		// par défaut, les souscripteurs écoutent toutes les entités
		$entity = $args->getObject();


		// si l'entité n'est pas Artwork
		if(!$entity instanceof Artwork){
			return;
		} else {
            //dd($entity->getName());
			// transfert d'image
			if($entity->getPicture() instanceof UploadedFile){
				$this->fileService->upload($entity->getPicture(), 'img/artwork');


				// mise à jour de la propriété image
				$entity->setPicture( $this->fileService->getFileName() );
			}
		}
	}

	public function postLoad(LifecycleEventArgs $args):void
	{
		// par défaut, les souscripteurs écoutent toutes les entités
		$entity = $args->getObject();

		// si l'entité n'est pas Product
		if(!$entity instanceof Artwork){
			return;
		} else {
			// création d'une propriété dynamique pour stocker le nom de l'image
			$entity->prevImage = $entity->getPicture();
		}
	}

	public function preUpdate(LifecycleEventArgs $args):void
	{
		// par défaut, les souscripteurs écoutent toutes les entités
		$entity = $args->getObject();

		// si l'entité n'est pas Product
		if(!$entity instanceof Artwork){
			return;
		} else {
		    //dd($entity->getName());
			// si une image a été sélectionnée
			if($entity->getPicture() instanceof UploadedFile){
				// transfert de la nouvelle image
				$this->fileService->upload($entity->getPicture(), 'img/artwork');
				$entity->setPicture( $this->fileService->getFileName() );

				// supprimer l'ancienne image
				if(file_exists("img/artwork/{$entity->prevImage}")) {
					$this->fileService->remove('img/artwork', $entity->prevImage);
				}
			}
			// si aucune image n'a été sélectionnée
			else {
				$entity->setPicture( $entity->prevImage );
			}
		}
	}

	public function getSubscribedEvents():array
	{
		return [
			Events::prePersist,
			Events::postLoad,
			Events::preUpdate,
		];
	}

}