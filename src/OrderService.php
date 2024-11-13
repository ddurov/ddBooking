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
	 * @param array $ticketsPrices
	 * @param array $ticketsQuantities
	 * @param array $barcode
	 * @return void
	 * @throws EntityException
	 * @throws ORMException
	 */
	public function book(
		int $eventId,
		string $eventDate,
		array $ticketsPrices,
		array $ticketsQuantities,
		array $barcode
	): void
	{
		$query = $this->entityRepository->createQueryBuilder("o");

		foreach ($barcode as $key => $item) {
			$query->orWhere("o.barcode LIKE :barcode_$key")->setParameter("barcode_$key", "%|$item|%");
		}

		if ($query->getQuery()->getResult() !== [])
			throw new EntityException("Barcode already exists, try another.", 422);

		$this->create(
			$eventId,
			$eventDate,
			$ticketsPrices, $ticketsQuantities,
			$barcode
		);
	}

	/**
	 * @param int $barcode
	 * @return void
	 * @throws EntityException
	 */
	public function approve(int $barcode): void
	{
		if ($this->entityRepository
			->createQueryBuilder("o")
			->where("o.barcode LIKE :barcode")
			->setParameter("barcode", "%|$barcode|%")
			->getQuery()->getResult() === []
		) throw new EntityException("Barcode not found.", 422);
	}

	/**
	 * @param int $eventId
	 * @param string $eventDate
	 * @param array $ticketsPrices
	 * @param array $ticketsQuantities
	 * @param array|null $barcode
	 * @return void
	 * @throws ORMException
	 */
	private function create(
		int $eventId,
		string $eventDate,
		array $ticketsPrices,
		array $ticketsQuantities,
		array $barcode = null,
	): void
	{
		$total = 0;
		foreach ($ticketsQuantities as $type => $quantity) {
			if ($barcode === null) {
				for ($i = 0; $i < $quantity; $i++) {
					$barcode[] = rand(1, PHP_INT_MAX);
				}
			}
			$total += $ticketsPrices[$type] * $quantity;
		}
		$this->entityManager->persist(new OrderModel(
			$eventId,
			$eventDate, date("Y-m-d H:i:s"),
			$ticketsPrices, $ticketsQuantities,
			$total,
			"|".implode("|", $barcode)."|"
		));
		$this->entityManager->flush();
	}
}
