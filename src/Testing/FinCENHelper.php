<?php

namespace Advalis\LaravelPlaywright\Testing;

class FinCENHelper
{
	public function createRERReport(array $attributes = []): \App\Models\RerReport
	{
		return \App\Models\RerReport::factory()->create($attributes);
	}

	public function createGTOReport(array $attributes = []): \App\Models\GtoReport
	{
		return \App\Models\GtoReport::factory()->create($attributes);
	}

	public function createEntityHierarchy(string $type = 'trust'): array
	{
		$parent = \App\Models\Entity::factory()->create(['type' => $type]);
		$children = \App\Models\Entity::factory()
			->count(3)
			->for($parent, 'parent')
			->create();

		return [
			'parent' => $parent,
			'children' => $children,
		];
	}

	public function generateEntityLink(\App\Models\Entity $entity): string
	{
		$link = \App\Models\EntityLink::factory()
			->for($entity)
			->create([
				'expires_at' => now()->addDays(7),
			]);

		return route('entity.submit', $link->token);
	}
}