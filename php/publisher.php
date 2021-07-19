<?php

require_once __DIR__ . '/vendor/autoload.php';

class TaskPassenger extends Viloveul\Transport\Passenger
{

	protected $type = 'topic';

	public function point(): string
	{
		return 'sistem.notifikasi.exchange';
	}

	public function route(): string
	{
		return 'sistem.notifikasi';
	}

	public function data(): string
	{
		return json_encode($this->getAttributes());
	}

	public function handle(): void
	{
		$this->setAttribute('isi', date('Y-m-d H:i:s'));
	}
}

$bus = new Viloveul\Transport\Bus();
$bus->initialize();
$bus->addConnection('amqp://localhost:5672//');
$bus->process(new TaskPassenger());