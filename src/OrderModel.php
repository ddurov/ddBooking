<?php

namespace Theater;

use Core\Models\Model;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'orders')]
class OrderModel extends Model
{
	#[Column] public int $eventId;
	#[Column] public string $eventDate;
	#[Column] public string $createdDate;
	#[Column] public array $ticketsPrices;
	#[Column] public array $ticketsQuantities;
	#[Column] public int $equalPrice;
	#[Column] public string $barcode;

	/**
	 * @param int $eventId
	 * @param string $eventDate
	 * @param string $createdDate
	 * @param array $ticketsPrices
	 * @param array $ticketsQuantities
	 * @param int $equalPrice
	 * @param string $barcode
	 */
	public function __construct(int $eventId, string $eventDate, string $createdDate, array $ticketsPrices, array $ticketsQuantities, int $equalPrice, string $barcode)
	{
		$this->eventId = $eventId;
		$this->eventDate = $eventDate;
		$this->createdDate = $createdDate;
		$this->ticketsPrices = $ticketsPrices;
		$this->ticketsQuantities = $ticketsQuantities;
		$this->equalPrice = $equalPrice;
		$this->barcode = $barcode;
	}
}