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
	#[Column] public int $userId;
	#[Column] public string $eventDate;
	#[Column] public string $createdDate;
	#[Column] public int $ticketAdultPrice;
	#[Column] public int $ticketAdultQuantity;
	#[Column] public int $ticketChildrenPrice;
	#[Column] public int $ticketChildrenQuantity;
	#[Column] public int $equalPrice;
	#[Column] public int $barCode;

	/**
	 * @param int $eventId
	 * @param int $userId
	 * @param string $eventDate
	 * @param string $createdDate
	 * @param int $ticketAdultPrice
	 * @param int $ticketAdultQuantity
	 * @param int $ticketChildrenPrice
	 * @param int $ticketChildrenQuantity
	 * @param int $equalPrice
	 * @param int $barCode
	 */
	public function __construct(int $eventId, int $userId, string $eventDate, string $createdDate, int $ticketAdultPrice, int $ticketAdultQuantity, int $ticketChildrenPrice, int $ticketChildrenQuantity, int $equalPrice, int $barCode)
	{
		$this->eventId = $eventId;
		$this->userId = $userId;
		$this->eventDate = $eventDate;
		$this->createdDate = $createdDate;
		$this->ticketAdultPrice = $ticketAdultPrice;
		$this->ticketAdultQuantity = $ticketAdultQuantity;
		$this->ticketChildrenPrice = $ticketChildrenPrice;
		$this->ticketChildrenQuantity = $ticketChildrenQuantity;
		$this->equalPrice = $equalPrice;
		$this->barCode = $barCode;
	}
}