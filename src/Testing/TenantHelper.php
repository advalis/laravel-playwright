<?php

namespace Advalis\LaravelPlaywright\Testing;

class TenantHelper
{
	public function switchToFirm(int $firmId): void
	{
		session(['current_firm_id' => $firmId]);
	}

	public function switchToOffice(int $officeId): void
	{
		session(['current_office_id' => $officeId]);
	}

	public function createTestTenant(array $attributes = []): array
	{
		$firm = \App\Models\Firm::factory()->create($attributes);
		$office = \App\Models\Office::factory()->for($firm)->create();
		$user = \App\Models\FirmUser::factory()->for($firm)->create();

		return [
			'firm' => $firm,
			'office' => $office,
			'user' => $user,
		];
	}
}