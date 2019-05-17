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
	 * 消费者
	 */
	public function consumer(Request $request) {
		$type = $request->input('type');
		if($type == 'lowlevel') {
			return $this->consumer_lowlevel();
		} elseif ($type == 'store') {
			return $this->consumer_store();
		} else {
			return $this->consumer_highlevel();
		}
	}

	/**
	 * 消费者-lowlevel形式
	 */
	private  function consumer_lowlevel() {
		$rk = new \RdKafka\Consumer();
		$rk->setLogLevel(LOG_DEBUG);
		$rk->addBrokers("127.0.0.1:9092,127.0.0.1:9093,127.0.0.1:9094");

		$topic = $rk->newTopic("test");
		// The first argument is the partition to consume from.
		// The second argument is the offset at which to start consumption. Valid values
		// are: RD_KAFKA_OFFSET_BEGINNING, RD_KAFKA_OFFSET_END, RD_KAFKA_OFFSET_STORED.
		$topic->consumeStart(0, 3);//partition,offset
		$msg = $topic->consume(0, 3000);
		var_dump($msg);
		if (null === $msg) {
			echo 'is null',"\n";
		} elseif ($msg->err) {
			echo $msg->errstr(), "\n";
		} else {
			echo $msg->payload, "\n";
		}

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
	private function consumer_store() {
		//get broker
		$rk = new \RdKafka\Consumer();
		$rk->setLogLevel(LOG_DEBUG);
		$rk->addBrokers("127.0.0.1:9092,127.0.0.1:9093,127.0.0.1:9094");

		//get topic
		$topicConf = new \RdKafka\TopicConf();
		$topicConf->set("auto.commit.interval.ms", 1e3);
		$topicConf->set("offset.store.sync.interval.ms", 60e3);
		$topicConf->set('auto.commit.enable', 'false');
		$topicConf->set("offset.store.method", 'broker');
		$topic = $rk->newTopic("test", $topicConf);

		//consume
		$offset = 3;
		$topic->consumeStart(0, $offset);//offset 可以存储在数据库或者redis中
		$msg = $topic->consume(0, 1000);//partition,timeout
		var_dump($msg);
		if(empty($msg) || $msg->err != RD_KAFKA_RESP_ERR_NO_ERROR) {
			//异常
			return '超时或者异常';
		} else {
			//$topic->offsetStore(0,$msg->offset);
			return $msg->payload;
		}
	}

	private function consumer_highlevel() {
		$conf = new \RdKafka\Conf();
		/*// Set a rebalance callback to log partition assignments (optional)
		$conf->setRebalanceCb(function (RdKafka\KafkaConsumer $kafka, $err, array $partitions = null) {
			switch ($err) {
			case RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS:
				echo "Assign: ";
				var_dump($partitions);
				$kafka->assign($partitions);
				break;

			case RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS:
				echo "Revoke: ";
				var_dump($partitions);
				$kafka->assign(NULL);
				break;

			default:
				throw new \Exception($err);
			}
		});
*/
		// Configure the group.id. All consumer with the same group.id will consume
		// different partitions.
		$conf->set('group.id', 'yy_test_group');

		// Initial list of Kafka brokers
		$conf->set('metadata.broker.list', '127.0.0.1:9092,127.0.0.1:9093,127.0.0.1:9094');

		$topicConf = new \RdKafka\TopicConf();

		// Set where to start consuming messages when there is no initial offset in
		// offset store or the desired offset is out of range.
		// 'smallest': start from the beginning
		$topicConf->set('auto.offset.reset', 'smallest');
		$topicConf->set('enable.auto.commit', 'false');
		$topicConf->set('offset.store.method', 'broker');

		// Set the configuration to use for subscribed/assigned topics
		$conf->setDefaultTopicConf($topicConf);

		$consumer = new \RdKafka\KafkaConsumer($conf);

		// Subscribe to topic 'test'
		$consumer->subscribe(['test']);
		$message = $consumer->consume(20*1000);//超时时间要设置长一些
		switch ($message->err) {
			case RD_KAFKA_RESP_ERR_NO_ERROR:
				//success
				var_dump($message);
				$consumer->commit();
				break;
			case RD_KAFKA_RESP_ERR__PARTITION_EOF:
				echo "No more messages; will wait for more\n";
				break;
			case RD_KAFKA_RESP_ERR__TIMED_OUT:
				echo "Timed out\n";
				break;
			default:
				throw new \Exception($message->errstr(), $message->err);
				break;
		}
		/*while (true) {
			$message = $consumer->consume(3000);
			switch ($message->err) {
			case RD_KAFKA_RESP_ERR_NO_ERROR:
				var_dump($message);
				break;
			case RD_KAFKA_RESP_ERR__PARTITION_EOF:
				echo "No more messages; will wait for more\n";
				break;
			case RD_KAFKA_RESP_ERR__TIMED_OUT:
				echo "Timed out\n";
				break;
			default:
				throw new \Exception($message->errstr(), $message->err);
				break;
			}
		}*/
	}	

}



?>
