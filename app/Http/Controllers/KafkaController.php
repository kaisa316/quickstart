<?php
/**
 * kafka study 
 */
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KafkaController extends Controller {

	/**
	 * 生产者
	 */
	public function producter(Request $request) {
		$rk = new \RdKafka\Producer();
		$rk->setLogLevel(LOG_DEBUG);
		$rk->addBrokers("127.0.0.1:9092,127.0.0.1:9093,127.0.0.1:9094");

		$topic = $rk->newTopic("test");
		$message = $request->input('message');
		$result = $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
		return $result;
	}

	/**
	 * 消费者-lowlevel形式
	 */
	public function consumer_lowlevel() {
		$rk = new \RdKafka\Consumer();
		$rk->setLogLevel(LOG_DEBUG);
		$rk->addBrokers("127.0.0.1:9092,127.0.0.1:9093,127.0.0.1:9094");

		$topic = $rk->newTopic("test");
		// The first argument is the partition to consume from.
		// The second argument is the offset at which to start consumption. Valid values
		// are: RD_KAFKA_OFFSET_BEGINNING, RD_KAFKA_OFFSET_END, RD_KAFKA_OFFSET_STORED.
		$topic->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);
		$msg = $topic->consume(0, 1000);
		if (null === $msg) {
			echo 'is null',"\n";
		} elseif ($msg->err) {
			echo $msg->errstr(), "\n";
		} else {
			echo $msg->payload, "\n";
		}

		return 'end';

		/*
		while (true) {
			// The first argument is the partition (again).
			// The second argument is the timeout.
			$msg = $topic->consume(0, 1000);
			if (null === $msg) {
				continue;
			} elseif ($msg->err) {
				echo $msg->errstr(), "\n";
				break;
			} else {
				echo $msg->payload, "\n";
			}
		}
		 */
	}

	/**
	 * 消费者--store offset形式
	 */
	public function consumer_store() {
		//get broker
		$rk = new \RdKafka\Consumer();
		$rk->setLogLevel(LOG_DEBUG);
		$rk->addBrokers("127.0.0.1:9092,127.0.0.1:9093,127.0.0.1:9094");

		//get topic
		$topicConf = new \RdKafka\TopicConf();
		$topicConf->set("auto.commit.interval.ms", 1e3);
		$topicConf->set("offset.store.sync.interval.ms", 60e3);
		$topic = $rk->newTopic("test", $topicConf);

		//consume
		//$topic->consumeStart(0, RD_KAFKA_OFFSET_STORED);
		$topic->consumeStart(0, 1);//partition,offset
		$msg = $topic->consume(0, 1000);//partition,timeout
		var_dump($msg);
		if(empty($msg) || $msg->err != RD_KAFKA_RESP_ERR_NO_ERROR) {
			//异常
			return '超时或者异常';
		} else {
			return $msg->payload;
		}
	}

}



?>
