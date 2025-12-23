<?php

use App\Models\SiteKeyword;
use Illuminate\Support\Facades\Schema;

$messages = [];

try{
	if (Schema::hasTable('site_keywords')) {
		$languages = SiteKeyword::getAllKeywords();

		foreach ($languages as $key => $value) {
			$messages[$value->keyword] = $value->arabic;
		}
	}

	return $messages;
} catch (\Throwable $th) {
	return [];
}
