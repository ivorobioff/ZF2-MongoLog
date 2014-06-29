<?php
namespace Developer\MongoLog\Factory;

use Developer\MongoDB\MongoConnector;
use Zend\Log\Logger;
use Zend\Log\Writer\MongoDB;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AbstractLoggerFactory implements AbstractFactoryInterface
{
	/**
	 * Determine if we can create a service with name
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @param $name
	 * @param $requestedName
	 * @return bool
	 */
	public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
	{
		$config = $serviceLocator->get('Config');
		if (!isset($config['mongo_logs']['loggers'][$requestedName])) return false;
		return true;
	}

	/**
	 * Create service with name
	 *
	 * @param ServiceLocatorInterface $serviceLocator
	 * @param $name
	 * @param $requestedName
	 * @return mixed
	 */
	public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
	{
		/**
		 * @var MongoConnector $mongoConnector
		 */
		$mongoConnector = $serviceLocator->get('MongoDB\Connector');
		$config = $serviceLocator->get('Config');
		$config = $config['mongo_logs'];

		$writer = new MongoDB(
			$mongoConnector->getClient(),
			$mongoConnector->getConfig()['database'],
			$config['loggers'][$requestedName]
		);

		$logger = new Logger();
		$logger->addWriter($writer);

		return $logger;
	}
}