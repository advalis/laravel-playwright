<?php

namespace Advalis\LaravelPlaywright\Testing;

class OAuth2Helper
{
	public function mockOAuthToken(array $claims): string
	{
		// Generate test JWT token
		$header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
		$payload = base64_encode(json_encode(array_merge([
			'sub' => '1',
			'iat' => time(),
			'exp' => time() + 3600,
		], $claims)));

		$signature = hash_hmac('sha256', "$header.$payload", config('app.key'), true);
		$signature = base64_encode($signature);

		return "$header.$payload.$signature";
	}

	public function loginAs($user): array
	{
		// Create session for user
		auth()->login($user);

		// Generate tokens
		return [
			'access_token' => $this->mockOAuthToken(['sub' => $user->id]),
			'token_type' => 'Bearer',
			'expires_in' => 3600,
		];
	}
}