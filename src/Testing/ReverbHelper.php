<?php

namespace Advalis\LaravelPlaywright\Testing;

use Illuminate\Support\Facades\Broadcast;

class ReverbHelper
{
	public function broadcastTestEvent(string $channel, string $event, array $data): void
	{
		Broadcast::channel($channel, function () {
			return true; // Allow all in testing
		});

		broadcast(new \App\Events\TestEvent($event, $data))->toChannel($channel);
	}

	public function simulateReportStatusUpdate(int $reportId, string $status): void
	{
		$this->broadcastTestEvent(
			"private-report.$reportId",
			'ReportStatusUpdated',
			['report_id' => $reportId, 'status' => $status]
		);
	}
}