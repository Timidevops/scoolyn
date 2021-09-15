<?php

    namespace App\Logging;

    use Aws\CloudWatchLogs\CloudWatchLogsClient;
    use Illuminate\Support\Facades\Log;
    use Maxbanton\Cwh\Handler\CloudWatch;
    use Monolog\Logger;

    class CloudwatchLoggerFactory
    {
        /**
         * Create a custom Monolog instance.
         *
         * @param  array  $config
         * @return \Monolog\Logger
         */
        public function __invoke(array $config)
        {
            $sdkParams = $config["sdk"];
            $tags = $config["tags"] ?? [ ];
            $name = $config["name"] ?? 'cloudwatch';

            // Instantiate AWS SDK CloudWatch Logs Client
            $client = new CloudWatchLogsClient($sdkParams);

            // Log group name, will be created if none
            $groupName = env('CLOUDWATCH_GROUP', config('app.name') . '-' . config('app.env'));

            // Log stream name, will be created if none
            $streamName = env('CLOUDWATCH_STREAM', config('app.hostname'));

            // Days to keep logs, 14 by default. Set to `null` to allow indefinite retention.
            $retentionDays = $config["retention"];

            // Instantiate handler (tags are optional)
            $handler = new CloudWatch($client, $groupName, $streamName, $retentionDays, 10000, $tags);

            // Create a log channel
            $logger = new Logger($name);
            // Set handler
            $logger->pushHandler($handler);

            return $logger;
        }
    }
