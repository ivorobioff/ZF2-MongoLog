<?php
namespace Developer\MongoLog;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Module implements ConfigProviderInterface
{
	/**
	 * Returns configuration to merge with application configuration
	 *
	 * @return array|\Traversable
	 */
	public function getConfig()
	{
		return [
			'service_manager' => [
				'abstract_factories' => [
					'Developer\MongoLog\Factory\AbstractLoggerFactory'
				]
			],

			'mongo_logs' => [
				'loggers' => [
				]
			]
		];
	}

	public function getAutoloaderConfig()
	{
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/MongoLog',
				),
			),
		);
	}
}