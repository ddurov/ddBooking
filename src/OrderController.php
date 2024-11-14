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
	 * @return void
	 * @throws EntityException
	 * @throws ORMException
	 * @throws ParametersException
	 */
	#[NoReturn] public function book(): void
	{
		parent::validateData($this->data, [
			/* тут используются данные, пришедшие из запроса к API, согласно ТЗ, они вырезаны и замоканы
			"eventId" => "required|numeric",
			"eventDate" => "required|date:Y-m-d H:i:s",
			"ticketsPrices" => "required|array",
   			"ticketsPrices.kid" => "required|numeric",
         		"ticketsPrices.adult" => "required|numeric",
	   		"ticketsPrices.benefit" => "required|numeric",
         		"ticketsPrices.group" => "required|numeric",
			"ticketsQuantities" => "required|array",
      			"ticketsQuantity.kid" => "required|numeric",
         		"ticketsQuantity.adult" => "required|numeric",
	   		"ticketsQuantity.benefit" => "required|numeric",
         		"ticketsQuantity.group" => "required|numeric",
			*/
			"barcode" => "required|array",
		]);

		$this->orderService->book(
			/*
			$this->data["eventId"],
			$this->data["eventDate"],
			$this->data["ticketsPrices"], $this->data["ticketsQuantities"],
			*/
			rand(),
			date("Y-m-d H:i:s", rand()),
			[
				"kid" => rand(100, 10000),
				"adult" => rand(100, 10000),
				"benefit" => rand(100, 10000),
				"group" => rand(100, 10000)
			],
			[
				"kid" => rand(1, 50),
				"adult" => rand(1, 50),
				"benefit" => rand(1, 50),
				"group" => rand(1, 50)
			],
			$this->data["barcode"]
		);

		parent::sendResponse(new SuccessResponse("Order successfully booked."));
	}

	/**
	 * @return void
	 * @throws ParametersException
	 * @throws EntityException
	 */
	#[NoReturn] public function approve(): void
	{
		parent::validateData($this->data, [
			"barcode" => "required|numeric",
		]);

		$this->orderService->approve($this->data["barcode"]);

		parent::sendResponse(new SuccessResponse("Order successfully booked."));
	}
}
