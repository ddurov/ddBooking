<?php

namespace Theater;

use Core\Controller;
use Core\Database;
use Core\Exceptions\EntityException;
use Core\Exceptions\ParametersException;
use Core\Models\SuccessResponse;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\Exception\ORMException;
use JetBrains\PhpStorm\NoReturn;

class OrderController extends Controller
{
	private OrderService $orderService;

	/**
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->orderService = new OrderService(Database::getInstance()->getEntityManager());
		parent::__construct();
	}

	/**
	 * @throws EntityException
	 * @throws ORMException
	 * @throws ParametersException
	 */
	#[NoReturn] public function book(): void
	{
		parent::validateData($this->data, [
			"eventId" => "numeric",
			"eventDate" => "date:Y-m-d H:i:s",
			"ticketAdultPrice" => "required|numeric",
			"ticketAdultQuantity" => "required|numeric",
			"ticketKidPrice" => "required|numeric",
			"ticketKidQuantity" => "required|numeric",
			"barcode" => "required|numeric|max:".(int)getenv("MAX_BARCODES_FOR_EACH_EVENT"),
		]);

		$this->orderService->book(
			1,
			date("Y-m-d H:i:s"),
			$this->data["ticketAdultPrice"],
			$this->data["ticketAdultQuantity"],
			$this->data["ticketKidPrice"],
			$this->data["ticketKidQuantity"],
			1,
			$this->data["barcode"]
		);

		parent::sendResponse(new SuccessResponse("Order successfully booked."));
	}

	public function approve(): void
	{

	}
}