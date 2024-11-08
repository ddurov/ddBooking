<?php

namespace Theater;

use Core\Exceptions\EntityException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;

class OrderService
{
	private EntityManager $entityManager;
	private EntityRepository $entityRepository;

	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
		$this->entityRepository = $entityManager->getRepository(OrderModel::class);
	}

	/**
	 * @param int $eventId
	 * @param string $eventDate
	 * @param int $ticketAdultPrice
	 * @param int $ticketAdultQuantity
	 * @param int $ticketKidPrice
	 * @param int $ticketKidQuantity
	 * @param int $userId
	 * @param int $barcode
	 * @return void
	 * @throws EntityException
	 * @throws ORMException
	 */
	public function book(
		int $eventId,
		string $eventDate,
		int $ticketAdultPrice,
		int $ticketAdultQuantity,
		int $ticketKidPrice,
		int $ticketKidQuantity,
		int $userId,
		int $barcode
	): void
	{

		if ($this->entityRepository->findOneBy(["barCode" => $barcode]) !== null) {
			throw new EntityException("Barcode already exists, try another.", 422);
		}
		$this->entityManager->persist(new OrderModel(
			$eventId,
			$userId,
			$eventDate, date("Y-m-d H:i:s"),
			$ticketAdultPrice, $ticketAdultQuantity,
			$ticketKidPrice, $ticketKidQuantity,
			($ticketAdultPrice * $ticketAdultQuantity) + ($ticketKidPrice * $ticketKidQuantity),
			$barcode
		));
		$this->entityManager->flush();
	}
}